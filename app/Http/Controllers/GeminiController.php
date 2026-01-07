<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Task;
use Exception;
use Gemini\Data\Blob;
use Gemini\Enums\MimeType;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

final class GeminiController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        DB::beginTransaction();

        // Create assignment with processing status
        $assignment = Assignment::create([
            'title' => $request->title,
            'filename' => $request->filename,
            'filepath' => $request->filepath,
            'starts_at' => now(),
            'ends_at' => now()->addWeek(),
            'user_id' => $request->user_id,
        ]);

        try {
            // Call Gemini API
            $prompt = $this->buildPrompt();

            $response = Gemini::generativeModel(model: 'gemini-3-flash-preview')
                ->generateContent([
                    $prompt,
                    new Blob(
                        mimeType: MimeType::APPLICATION_PDF,
                        data: base64_encode(
                            file_get_contents($request->full_path)
                        )
                    ),
                ]);

            // Parse response
            $data = $this->parseResponse($response->text());

            // dd($data);

            // Update assignment with extracted data
            $assignment->update([
                'ends_at' => $data['deadline'] ?? now()->addWeek(),
                'priority' => $data['priority'] ?? 'medium',
            ]);

            // Create tasks
            foreach ($data['tasks'] as $taskData) {
                Task::create([
                    'title' => $taskData['title'],
                    'description' => $taskData['description'],
                    'order' => $taskData['order'],
                    'assignment_id' => $assignment->id,
                ]);
            }

            Log::info(sprintf('Assignment %s analyzed successfully', $assignment->id), [
                'tasks_count' => count($data['tasks']),
                'deadline' => $data['deadline'] ?? null,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'assignment' => $assignment->load('tasks'),
                'message' => 'Assignment created and analyzed successfully',
            ]);
        } catch (Exception $exception) {

            DB::rollBack();

            // Delete the uploaded file from storage
            if (Storage::disk('public')->exists($request->filepath)) {
                Storage::disk('public')->delete($request->filepath);
            }

            Log::error('Gemini Analysis Error', [
                'assignment_id' => $assignment->id,
                'error' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to analyze document: ' . $exception->getMessage(),
            ], 500);
        }
    }

    private function buildPrompt(): string
    {
        return <<<'PROMPT'
        You are an AI assistant that analyzes academic assignment documents and extracts structured information.
        Analyze this assignment document and extract the following information in JSON format:

            1. **Course Code** - Any course identifier (e.g., CSC584)
            2. **Deadline** - Submission date in YYYY-MM-DD format
            3. **Submission Instructions** - Where and how to submit
            4. **Requirements/Tasks** - Break down the "What do you need to do" section into individual actionable tasks

        **IMPORTANT: Return ONLY valid JSON in this exact structure:**
        ```json
        {
            "deadline": "2025-12-27",
            "submission_method": "Google Classroom",
            "priority": 3,
            "tasks": [
                {
                    "title": "Create database and table",
                    "description": "Create a database named student_profiles with a table profile to store user profile details",
                    "order": 1
                },
                {
                    "title": "Develop JavaBean class",
                    "description": "Develop a JavaBean class (ProfileBean.java) to represent the profile data with private attributes, public getters, and setters",
                    "order": 2    
                },
                {
                    "title": "Modify Servlet for form handling",
                    "description": "Modify your Servlet to handle the form submission from the HTML page",
                    "order": 3
                }  
            ],  
            "additional_notes": "Upload the whole project and database to GitHub and share the link"
        }```

        **Rules:**
            - Extract ALL numbered or bulleted requirements as separate tasks
            - Each task should have a clear, concise title and detailed description
            - Maintain the original order of tasks
            - If deadline contains relative date like "today" or "next week", convert to actual date based on document context, if not explicitly stated, set to null.
            - Set priority as 1-3, each respectively represents 'low', 'medium' and 'high' based on the context.
            - Include sub-requirements as part of the task description (like the bullet points under "Create JSP pages").
            - Return ONLY the JSON, no additional text or markdown formatting.
        PROMPT;
    }

    private function parseResponse(string $response): array
    {
        // Remove markdown code blocks if present
        $cleaned = preg_replace('/```json\s*|\s*```/', '', $response);
        $cleaned = mb_trim($cleaned);

        // Try to parse JSON
        $data = json_decode($cleaned, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Invalid JSON response from Gemini: ' . json_last_error_msg() . "\n\nResponse: " . $response);
        }

        // Validate required fields
        if (! isset($data['tasks']) || ! is_array($data['tasks'])) {
            throw new Exception('Invalid response structure: missing tasks array');
        }

        return $data;
    }
}
