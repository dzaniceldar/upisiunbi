<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScoringRulesTable extends Migration
{
    public function up()
    {
        Schema::create('scoring_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->decimal('weight', 8, 2)->default(1);
            $table->decimal('max_points', 8, 2)->nullable();
            $table->timestamps();
            $table->unique(['department_id', 'subject_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('scoring_rules');
    }
}
