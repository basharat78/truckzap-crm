@extends('admin.layouts.master')

@push('styles')
    <style>
        .card-statistic-1 .card-header h4 {
            white-space: nowrap;
        }
    </style>
@endpush

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>HR</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item">HR</div>
            </div>
        </div>

        <div class="section-body">
            @php
                $statusCounts = $statusCounts ?? collect();
                $statusCards = [
                    'pending' => ['label' => 'Pending', 'icon' => 'fa-clock', 'bg' => 'bg-warning'],
                    'selected' => ['label' => 'Selected', 'icon' => 'fa-check-circle', 'bg' => 'bg-success'],
                    'rejected' => ['label' => 'Rejected', 'icon' => 'fa-times-circle', 'bg' => 'bg-danger'],
                    'on_hold' => ['label' => 'On Hold', 'icon' => 'fa-pause-circle', 'bg' => 'bg-secondary'],
                ];
            @endphp

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a href="#" class="status-card" data-status="">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total</h4>
                                </div>
                                <div class="card-body">
                                    {{ $statusCounts->sum() }}
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                @foreach ($statusCards as $key => $card)
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <a href="#" class="status-card" data-status="{{ $key }}">
                            <div class="card card-statistic-1">
                                <div class="card-icon {{ $card['bg'] }}">
                                    <i class="fas {{ $card['icon'] }}"></i>
                                </div>
                                <div class="card-wrap">
                                    <div class="card-header">
                                        <h4>{{ $card['label'] }}</h4>
                                    </div>
                                    <div class="card-body">
                                        {{ $statusCounts[$key] ?? 0 }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h4>Interview Evaluations</h4>
                            <div class="d-flex align-items-center">
                                <select id="status-filter" class="form-control form-control-sm mr-2" style="width: auto;">
                                    <option value="">All Statuses</option>
                                    <option value="pending">Pending</option>
                                    <option value="selected">Selected</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="on_hold">On Hold</option>
                                </select>
                                <a href="{{ url('admin/hr/create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Create Evaluation
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="hr-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Candidate Name</th>
                                            <th>Position</th>
                                            <th>Department</th>
                                            <th>Interviewer</th>
                                            <th>Interview Date</th>
                                            <th>Total Score</th>
                                            <th>Status</th>
                                            <th>Action</th>
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

    <div class="modal fade" id="viewEvaluationModal" tabindex="-1" role="dialog" aria-labelledby="viewEvaluationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewEvaluationModalLabel">Interview Evaluation Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center" id="viewEvaluationLoading">
                        <i class="fas fa-spinner fa-spin"></i> Loading...
                    </div>
                    <div id="viewEvaluationContent" style="display: none;">
                        <h6 class="text-uppercase text-muted mb-3">Candidate Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Candidate Name:</strong> <span id="ve-candidate_name"></span></p>
                                <p><strong>Phone:</strong> <span id="ve-phone"></span></p>
                                <p><strong>Email:</strong> <span id="ve-email"></span></p>
                                <p><strong>Position:</strong> <span id="ve-position"></span></p>
                                <p><strong>Department:</strong> <span id="ve-department"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Expected Salary:</strong> <span id="ve-expected_salary"></span></p>
                                <p><strong>Experience:</strong> <span id="ve-experience"></span></p>
                                <p><strong>City:</strong> <span id="ve-city"></span></p>
                                <p><strong>Reference:</strong> <span id="ve-reference"></span></p>
                            </div>
                        </div>

                        <hr>

                        <h6 class="text-uppercase text-muted mb-3">Interview Information</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Interviewer:</strong> <span id="ve-interviewer"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Interview Date:</strong> <span id="ve-interview_date"></span></p>
                            </div>
                        </div>

                        <hr>

                        <h6 class="text-uppercase text-muted mb-3">Skills Evaluation (1-10)</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <p><strong>Communication:</strong> <span id="ve-communication"></span></p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>English:</strong> <span id="ve-english"></span></p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Computer Skills:</strong> <span id="ve-computer_skills"></span></p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Confidence:</strong> <span id="ve-confidence"></span></p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Learning Ability:</strong> <span id="ve-learning_ability"></span></p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Dispatch Knowledge:</strong> <span id="ve-dispatch_knowledge"></span></p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Negotiation Skills:</strong> <span id="ve-negotiation_skills"></span></p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Typing Speed (WPM):</strong> <span id="ve-typing_speed"></span></p>
                            </div>
                            <div class="col-md-3">
                                <p><strong>Total Score:</strong> <span id="ve-total_score"></span></p>
                            </div>
                        </div>

                        <hr>

                        <h6 class="text-uppercase text-muted mb-3">Interview Notes</h6>
                        <p><strong>Strengths:</strong></p>
                        <p id="ve-strengths"></p>
                        <p><strong>Weaknesses:</strong></p>
                        <p id="ve-weaknesses"></p>
                        <p><strong>Comments:</strong></p>
                        <p id="ve-comments"></p>

                        <hr>

                        <h6 class="text-uppercase text-muted mb-3">Final Decision</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Recommendation:</strong> <span id="ve-recommendation"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Status:</strong> <span id="ve-status"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var hrTable = $('#hr-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('admin/hr') }}",
                data: function (d) {
                    d.status = $('#status-filter').val();
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'candidate_name', name: 'candidate_name' },
                { data: 'position', name: 'position' },
                { data: 'department', name: 'department' },
                { data: 'interviewer', name: 'interviewer' },
                { data: 'interview_date', name: 'interview_date' },
                { data: 'total_score', name: 'total_score' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center text-nowrap' },
            ]
        });

        $('#status-filter').on('change', function () {
            hrTable.draw();
        });

        $('.status-card').on('click', function (e) {
            e.preventDefault();
            $('#status-filter').val($(this).data('status')).trigger('change');
        });

        $(document).on('click', '.view-item', function (e) {
            e.preventDefault();
            var url = $(this).data('url');

            $('#viewEvaluationContent').hide();
            $('#viewEvaluationLoading').show();
            $('#viewEvaluationModal').modal('show');

            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    var hr = response.hr;

                    $('#ve-candidate_name').text(hr.candidate_name || '-');
                    $('#ve-phone').text(hr.phone || '-');
                    $('#ve-email').text(hr.email || '-');
                    $('#ve-position').text(hr.position || '-');
                    $('#ve-department').text(hr.department || '-');
                    $('#ve-expected_salary').text(hr.expected_salary || '-');
                    $('#ve-experience').text(hr.experience || '-');
                    $('#ve-city').text(hr.city || '-');
                    $('#ve-reference').text(hr.reference || '-');
                    $('#ve-interviewer').text(hr.interviewer || '-');
                    $('#ve-interview_date').text(hr.interview_date || '-');
                    $('#ve-communication').text(hr.communication || '-');
                    $('#ve-english').text(hr.english || '-');
                    $('#ve-computer_skills').text(hr.computer_skills || '-');
                    $('#ve-confidence').text(hr.confidence || '-');
                    $('#ve-learning_ability').text(hr.learning_ability || '-');
                    $('#ve-dispatch_knowledge').text(hr.dispatch_knowledge || '-');
                    $('#ve-negotiation_skills').text(hr.negotiation_skills || '-');
                    $('#ve-typing_speed').text(hr.typing_speed || '-');
                    $('#ve-total_score').text(hr.total_score || '-');
                    $('#ve-strengths').text(hr.strengths || '-');
                    $('#ve-weaknesses').text(hr.weaknesses || '-');
                    $('#ve-comments').text(hr.comments || '-');
                    $('#ve-recommendation').text(hr.recommendation || '-');
                    $('#ve-status').text(hr.status ? hr.status.replace('_', ' ').replace(/\b\w/g, c => c.toUpperCase()) : '-');

                    $('#viewEvaluationLoading').hide();
                    $('#viewEvaluationContent').show();
                },
                error: function () {
                    $('#viewEvaluationModal').modal('hide');
                    Swal.fire('Error!', 'Something went wrong while fetching evaluation details.', 'error');
                }
            });
        });
    </script>
@endpush
