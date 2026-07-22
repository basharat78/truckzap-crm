@forelse ($agentStats ?? [] as $stat)
    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
        <div class="card agent-stat-card">
            <div class="card-body">
                <h5 class="agent-stat-card__name text-truncate" title="{{ $stat->agent_name }}">
                    <i class="fas fa-headset text-primary mr-2"></i>{{ $stat->agent_name }}
                </h5>
                <div class="row text-center no-gutters">
                    <div class="col-4">
                        <div class="agent-stat-card__number">{{ $stat->today_calls }}</div>
                        <small class="text-muted">Today</small>
                    </div>
                    <div class="col-4">
                        <div class="agent-stat-card__number text-success">{{ $stat->today_connected }}</div>
                        <small class="text-muted">Connected</small>
                    </div>
                    <div class="col-4">
                        <div class="agent-stat-card__number text-danger">{{ $stat->today_missed }}</div>
                        <small class="text-muted">Missed</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@empty
    <div class="col-12">
        <div class="alert alert-info">No calls logged for any agent today yet.</div>
    </div>
@endforelse
