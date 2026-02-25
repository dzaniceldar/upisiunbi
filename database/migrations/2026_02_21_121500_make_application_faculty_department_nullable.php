<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MakeApplicationFacultyDepartmentNullable extends Migration
{
    public function up()
    {
        DB::statement('ALTER TABLE applications MODIFY faculty_id BIGINT UNSIGNED NULL');
        DB::statement('ALTER TABLE applications MODIFY department_id BIGINT UNSIGNED NULL');
    }

    public function down()
    {
        DB::statement('ALTER TABLE applications MODIFY faculty_id BIGINT UNSIGNED NOT NULL');
        DB::statement('ALTER TABLE applications MODIFY department_id BIGINT UNSIGNED NOT NULL');
    }
}
