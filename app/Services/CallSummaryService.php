<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use OpenAI\Laravel\Facades\OpenAI;
use RuntimeException;

class CallSummaryService
{
    public function summarize(string $recordingUrl): string
    {
        $tmpPath = $this->downloadRecording($recordingUrl);

        try {
            $transcript = $this->transcribe($tmpPath);

            if (trim($transcript) === '') {
                return 'No speech was detected in this recording.';
            }

            return $this->generateSummary($transcript);
        } finally {
            if (file_exists($tmpPath)) {
                unlink($tmpPath);
            }
        }
    }

    protected function downloadRecording(string $url): string
    {
        $response = Http::timeout(60)->get($url);

        if ($response->failed()) {
            throw new RuntimeException("Failed to download recording: {$response->status()}");
        }

        $tmpPath = sys_get_temp_dir() . '/' . Str::uuid() . '.wav';
        file_put_contents($tmpPath, $response->body());

        return $tmpPath;
    }

    protected function transcribe(string $filePath): string
    {
        $response = OpenAI::audio()->transcribe([
            'model' => 'whisper-1',
            'file' => fopen($filePath, 'r'),
            'response_format' => 'text',
        ]);

        return is_string($response) ? $response : ($response->text ?? '');
    }

    protected function generateSummary(string $transcript): string
    {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-4o',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You summarize customer service phone call transcripts for a trucking dispatch company. Write a concise 3-4 sentence summary covering: who called, the purpose of the call, key details discussed, and any action items or follow-ups needed.',
                ],
                ['role' => 'user', 'content' => $transcript],
            ],
            'max_tokens' => 300,
        ]);

        return trim($response->choices[0]->message->content ?? 'Unable to generate a summary.');
    }
}
