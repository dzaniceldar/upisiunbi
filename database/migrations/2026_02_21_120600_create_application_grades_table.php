<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationGradesTable extends Migration
{
    public function up()
    {
        Schema::create('application_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('applications')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->decimal('grade', 4, 2)->nullable();
            $table->enum('source', ['manual', 'ocr'])->default('manual');
            $table->decimal('confidence', 5, 2)->nullable();
            $table->text('suggested_line')->nullable();
            $table->timestamps();
            $table->unique(['application_id', 'subject_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('application_grades');
    }
}
