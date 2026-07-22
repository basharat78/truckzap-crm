<?php

namespace App\Console\Commands;

use App\Models\MightyCall;
use App\Services\MightyCallService;
use Illuminate\Console\Command;

class SyncMightyCallsCommand extends Command
{
    protected $signature = 'mightycall:sync-calls {--minutes=15 : How far back to sync, in minutes}';

    protected $description = 'Pull recent calls from MightyCall and store them locally';

    public function handle(MightyCallService $service): int
    {
        $startUtc = now()->subMinutes((int) $this->option('minutes'))->format('Y-m-d\TH:i:s');
        $endUtc = now()->format('Y-m-d\TH:i:s');

        $pageSize = 50;
        $skip = 0;
        $synced = 0;

        do {
            $response = $service->listCalls([
                'startUtc' => $startUtc,
                'endUtc' => $endUtc,
                'pageSize' => $pageSize,
                'skip' => $skip,
            ]);

            $calls = $response['data']['calls'] ?? [];
            $total = $response['data']['total'] ?? 0;

            foreach ($calls as $call) {
                $calledParticipants = $call['called'] ?? [];
                $called = collect($calledParticipants)->firstWhere('isConnected', true)
                    ?? ($calledParticipants[0] ?? []);

                $isOutgoing = ($call['direction'] ?? null) === 'Outgoing';
                $agentName = $isOutgoing ? ($call['caller']['name'] ?? null) : ($called['name'] ?? null);
                $agentExtension = $isOutgoing ? ($call['caller']['extension'] ?? null) : ($called['extension'] ?? null);

                MightyCall::updateOrCreate(
                    ['mightycall_call_id' => $call['id']],
                    [
                        'direction' => $call['direction'] ?? null,
                        'call_status' => $call['callStatus'] ?? null,
                        'business_number' => $call['businessNumber'] ?? null,
                        'caller_name' => $call['caller']['name'] ?? null,
                        'caller_phone' => $call['caller']['phone'] ?? null,
                        'caller_extension' => $call['caller']['extension'] ?? null,
                        'called_name' => $called['name'] ?? null,
                        'called_phone' => $called['phone'] ?? null,
                        'agent_name' => $agentName,
                        'agent_extension' => $agentExtension,
                        'duration_ms' => $call['duration'] ?? null,
                        'recording_filename' => $call['callRecord']['fileName'] ?? null,
                        'recording_url' => $call['callRecord']['uri'] ?? null,
                        'call_started_at' => $call['dateTimeUtc'] ?? null,
                        'synced_at' => now(),
                    ]
                );

                $synced++;
            }

            $skip += $pageSize;
        } while ($skip < $total);

        $this->info("Synced {$synced} call(s).");

        return self::SUCCESS;
    }
}
