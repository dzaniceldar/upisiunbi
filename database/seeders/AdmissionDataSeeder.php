<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Faculty;
use App\Models\ScoringRule;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdmissionDataSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'Biotehnički fakultet' => ['Agronomija', 'Prehrambena tehnologija', 'Zaštita okoliša'],
            'Ekonomski fakultet' => ['Računovodstvo i revizija', 'Menadžment', 'Finansije i bankarstvo'],
            'Pedagoški fakultet' => ['Bosanski jezik i književnost', 'Matematika i informatika', 'Razredna nastava'],
            'Pravni fakultet' => ['Opći pravni smjer', 'Kriminologija', 'Upravno pravo'],
            'Tehnički fakultet' => ['Elektrotehnika', 'Građevinarstvo', 'Mašinstvo', 'Drvna tehnologija'],
            'Fakultet zdravstvenih studija' => ['Sestrinstvo', 'Fizioterapija', 'Sanitarno inženjerstvo'],
            'Islamski pedagoški fakultet' => ['Islamska vjeronauka', 'Socijalna pedagogija'],
        ];

        $subjects = ['Bosanski jezik', 'Matematika', 'Engleski jezik', 'Informatika', 'Historija', 'Biologija', 'Hemija'];

        foreach ($data as $facultyName => $departments) {
            $faculty = Faculty::updateOrCreate(
                ['slug' => Str::slug($facultyName)],
                [
                    'name' => $facultyName,
                    'description' => 'Fakultet Univerziteta u Bihaću sa relevantnim studijskim programima i upisnim kvotama.',
                    'contact_email' => 'info@'.Str::slug($facultyName).'.unbi.ba',
                    'contact_phone' => '+387 37 000 000',
                    'website' => 'https://www.unbi.ba',
                    'instructions' => 'Bodovanje se vrši na osnovu relevantnih predmeta i pripadajućih težina za odabrani odsjek.',
                    'document_instructions' => 'Obavezni dokumenti: identifikacioni dokument, svjedodžbe/diploma, rodni list i dokaz o uplati.',
                ]
            );

            foreach ($departments as $departmentName) {
                $department = Department::updateOrCreate(
                    [
                        'faculty_id' => $faculty->id,
                        'slug' => Str::slug($departmentName),
                    ],
                    [
                        'name' => $departmentName,
                        'description' => 'Studijski program sa definisanim kriterijima bodovanja.',
                        'instructions' => 'Minimalni prag i posebni uslovi se primjenjuju prema konkursu Univerziteta.',
                    ]
                );

                foreach ($subjects as $index => $subjectName) {
                    $subject = Subject::updateOrCreate(
                        ['department_id' => $department->id, 'name' => $subjectName],
                        ['code' => strtoupper(Str::substr(Str::slug($subjectName, ''), 0, 4)).($index + 1)]
                    );

                    ScoringRule::updateOrCreate(
                        ['department_id' => $department->id, 'subject_id' => $subject->id],
                        ['weight' => 1 + ($index % 3) * 0.25, 'max_points' => 12.5]
                    );
                }
            }
        }
    }
}
