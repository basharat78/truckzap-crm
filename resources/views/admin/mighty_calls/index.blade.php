@extends('admin.layouts.master')

@push('styles')
    <style>
        .agent-stat-card__name {
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .agent-stat-card__number {
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1.2;
        }
    </style>
@endpush

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Call Recordings (QC)</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Call Recordings</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row" id="agent-cards-container">
                @include('admin.mighty_calls._agent_cards')
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between flex-wrap">
                            <h4>MightyCall Recordings</h4>
                            <div class="d-flex align-items-center flex-wrap">
                                <select id="direction-filter" class="form-control form-control-sm mr-2 mb-2" style="width: auto;">
                                    <option value="">All Directions</option>
                                    <option value="Incoming">Incoming</option>
                                    <option value="Outgoing">Outgoing</option>
                                </select>

                                <select id="agent-filter" class="form-control form-control-sm mr-2 mb-2" style="width: auto;">
                                    <option value="">All Agents</option>
                                    @foreach ($agents ?? [] as $agent)
                                        <option value="{{ $agent->agent_extension }}">{{ $agent->agent_name }}</option>
                                    @endforeach
                                </select>
                                   <select id="duration-filter" class="form-control form-control-sm mr-2 mb-2" style="width: auto;">
                                    <option value="">Duration</option>
                                    <option value="60">1 Minute+</option>
                                </select>
                                <input type="date" id="date-from-filter" class="form-control form-control-sm mr-2 mb-2" style="width: auto;" title="From date">
                                <input type="date" id="date-to-filter" class="form-control form-control-sm mr-2 mb-2" style="width: auto;" title="To date">
                                <button type="button" id="clear-filters" class="btn btn-secondary btn-sm mb-2">Clear</button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="mighty-calls-table">
                                    <thead>
                                        <tr>
                                            <th>Received</th>
                                            <th>Direction</th>
                                            <th>Caller</th>
                                            <th>Called</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                            <th>Recording</th>
                                            <th>AI Summary</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="recordingModal" tabindex="-1" role="dialog" aria-labelledby="recordingModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="recordingModalLabel">Call Recording</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <audio id="recordingPlayer" controls style="width: 100%;">
                        Your browser does not support the audio element.
                    </audio>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="aiSummaryModal" tabindex="-1" role="dialog" aria-labelledby="aiSummaryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="aiSummaryModalLabel"><i class="fas fa-robot mr-2"></i>AI Call Summary</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center text-muted">
                    <i class="fas fa-robot fa-2x mb-3"></i>
                    <p class="mb-0">AI-generated call summaries are coming soon. Once enabled, this will show a summary of the call generated from the recording.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var mightyCallsTable = $('#mighty-calls-table').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: {
                url: "{{ url('admin/mc') }}",
                data: function (d) {
                    d.direction = $('#direction-filter').val();
                    d.agent = $('#agent-filter').val();
                    d.date_from = $('#date-from-filter').val();
                    d.date_to = $('#date-to-filter').val();
                    d.duration = $('#duration-filter').val();

                }
            },
            columns: [
                { data: 'received_at', name: 'received_at' },
                { data: 'direction', name: 'direction' },
                { data: 'caller', name: 'caller', orderable: false, searchable: false },
                { data: 'called', name: 'called', orderable: false, searchable: false },
                { data: 'duration', name: 'duration' },
                { data: 'call_status', name: 'call_status', orderable: false, searchable: false },
                { data: 'recording', name: 'recording', orderable: false, searchable: false },
                { data: 'summary', name: 'summary', orderable: false, searchable: false },
            ]
        });

        
          $('#duration-filter, #direction-filter, #agent-filter, #date-from-filter, #date-to-filter').on('change', function () {
            mightyCallsTable.draw();
        });

        $('#clear-filters').on('click', function () {
            $('#direction-filter, #agent-filter').val('');
            $('#date-from-filter, #date-to-filter').val('');
                 $('#duration-filter').val('');
            mightyCallsTable.draw();
        });

        setInterval(function () {
            mightyCallsTable.ajax.reload(null, false);
        }, 15000);

        setInterval(function () {
            $('#agent-cards-container').load("{{ url('admin/mc/agent-cards') }}");
        }, 15000);

        $(document).on('click', '.play-recording', function (e) {
            e.preventDefault();

            var url = $(this).data('url');
            var player = document.getElementById('recordingPlayer');

            player.pause();
            player.src = url;
            $('#recordingModal').modal('show');
            player.play();
        });

        $(document).on('click', '.view-summary', function (e) {
            e.preventDefault();

            $('#aiSummaryModal').modal('show');
        });

        $('#recordingModal').on('hidden.bs.modal', function () {
            var player = document.getElementById('recordingPlayer');
            player.pause();
            player.src = '';
        });
    </script>
@endpush
