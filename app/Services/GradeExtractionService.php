<?php

namespace App\Services;

use App\Models\Application;
use App\Models\Document;
use App\Models\Subject;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Spatie\PdfToText\Pdf;
use Thiagoalessio\TesseractOCR\TesseractOCR;

class GradeExtractionService
{
    public function extractFromDocument(Application $application, Document $document)
    {
        $absolutePath = storage_path('app/'.$document->path);
        $text = '';

        try {
            if ($document->mime === 'application/pdf') {
                $text = trim((string) Pdf::getText($absolutePath));
            }
        } catch (\Throwable $e) {
            Log::warning('PDF text extraction failed', ['document_id' => $document->id, 'error' => $e->getMessage()]);
        }

        if ($text === '') {
            try {
                $text = trim((new TesseractOCR($absolutePath))->lang('bos', 'hrv', 'eng')->run());
            } catch (\Throwable $e) {
                Log::warning('OCR extraction failed', ['document_id' => $document->id, 'error' => $e->getMessage()]);
                return [];
            }
        }

        $subjects = Subject::where('department_id', $application->department_id)->get();
        $lines = preg_split('/\r\n|\r|\n/', mb_strtolower($text));
        $suggestions = [];

        foreach ($subjects as $subject) {
            $normalizedSubject = $this->normalize($subject->name);
            foreach ($lines as $line) {
                $normalizedLine = $this->normalize($line);
                if (! Str::contains($normalizedLine, $normalizedSubject)) {
                    continue;
                }

                preg_match('/\b([1-5](?:[.,]\d{1,2})?)\b/u', $line, $gradeMatch);
                if (! isset($gradeMatch[1])) {
                    continue;
                }

                $grade = (float) str_replace(',', '.', $gradeMatch[1]);
                $confidence = $this->calculateConfidence($normalizedSubject, $normalizedLine);

                $suggestions[$subject->id] = [
                    'grade' => $grade,
                    'source' => 'ocr',
                    'confidence' => $confidence,
                    'suggested_line' => trim($line),
                ];
                break;
            }
        }

        return $suggestions;
    }

    private function normalize($value)
    {
        $value = mb_strtolower($value ?? '');
        $value = str_replace(['č', 'ć', 'š', 'ž', 'đ'], ['c', 'c', 's', 'z', 'd'], $value);
        $value = preg_replace('/[^a-z0-9\s]/', ' ', $value);
        $value = preg_replace('/\s+/', ' ', $value);

        return trim($value);
    }

    private function calculateConfidence($normalizedSubject, $normalizedLine)
    {
        similar_text($normalizedSubject, $normalizedLine, $percent);
        return round((float) $percent, 2);
    }
}
