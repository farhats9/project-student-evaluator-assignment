<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects');
            $table->foreignId('evaluator_id')->constrained('evaluators');
            $table->text('admin_comments')->nullable();
            $table->text('admin_remarks')->nullable();
            $table->text('evaluator_comments')->nullable();
            $table->text('evaluator_remarks')->nullable();
            $table->string('status')->default('awaiting_consent');
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
