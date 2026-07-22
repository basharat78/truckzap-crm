<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\MightyCallDataTable;
use App\Http\Controllers\Controller;
use App\Models\MightyCall;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class MightyCallController extends Controller
{
    public function index(MightyCallDataTable $dataTable): View|JsonResponse
    {
        if (request()->ajax()) {
            return $dataTable->render('admin.mighty_calls.index');
        }

        $agentStats = $this->todaysAgentStats();

        $agents = MightyCall::whereNotNull('agent_extension')
            ->select('agent_extension', 'agent_name')
            ->get()
            ->unique('agent_extension')
            ->sortBy('agent_name')
            ->values();

        return $dataTable->render('admin.mighty_calls.index', compact('agentStats', 'agents'));
    }

    public function agentCards(): ViewContract
    {
        return view('admin.mighty_calls._agent_cards', [
            'agentStats' => $this->todaysAgentStats(),
        ]);
    }

    protected function todaysAgentStats(): Collection
    {
        $todayStart = now('America/Chicago')->startOfDay()->utc();
        $todayEnd = now('America/Chicago')->endOfDay()->utc();

        return MightyCall::whereNotNull('agent_extension')
            ->whereBetween('call_started_at', [$todayStart, $todayEnd])
            ->get()
            ->groupBy('agent_extension')
            ->map(function ($calls, $extension) {
                return (object) [
                    'agent_extension' => $extension,
                    'agent_name' => $calls->first()->agent_name ?: ('Ext. ' . $extension),
                    'today_calls' => $calls->count(),
                    'today_missed' => $calls->where('call_status', 'Missed')->count(),
                    'today_connected' => $calls->where('call_status', 'Connected')->count(),
                ];
            })
            ->sortBy('agent_name')
            ->values();
    }
}
