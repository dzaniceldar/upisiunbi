<?php

namespace App\Services;

use App\Models\Application;
use App\Models\ScoringRule;

class ScoringService
{
    public function calculate(Application $application)
    {
        $rules = ScoringRule::with('subject')
            ->where('department_id', $application->department_id)
            ->get()
            ->keyBy('subject_id');

        $breakdown = [];
        $total = 0;

        foreach ($application->grades()->with('subject')->get() as $gradeRow) {
            $rule = $rules->get($gradeRow->subject_id);
            if (! $rule || $gradeRow->grade === null) {
                continue;
            }

            $points = round(((float) $gradeRow->grade) * ((float) $rule->weight), 2);
            if ($rule->max_points !== null) {
                $points = min($points, (float) $rule->max_points);
            }

            $breakdown[] = [
                'subject' => $gradeRow->subject->name,
                'grade' => (float) $gradeRow->grade,
                'weight' => (float) $rule->weight,
                'points' => $points,
            ];
            $total += $points;
        }

        return [
            'total' => round($total, 2),
            'breakdown' => $breakdown,
        ];
    }
}
