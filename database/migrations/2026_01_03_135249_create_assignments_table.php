<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('filename');
            $table->string('filepath');
            $table->dateTimeTz('starts_at');
            $table->dateTimeTz('ends_at');
            $table->string('priority')->default('low');
            $table->string('status')->default('ongoing');
            $table->foreignId('user_id')->constrained(User::class)->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
