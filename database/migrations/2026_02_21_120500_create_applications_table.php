<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('faculty_id')->nullable()->constrained('faculties');
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->enum('status', ['Draft', 'Submitted', 'Under review', 'Accepted', 'Rejected', 'Needs correction'])->default('Draft');
            $table->decimal('total_points', 8, 2)->default(0);
            $table->enum('extraction_status', ['pending', 'processed', 'needs_review', 'failed'])->default('pending');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('locked_at')->nullable();
            $table->timestamps();
            $table->unique('user_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
