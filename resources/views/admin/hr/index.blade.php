@extends('admin.layouts.master')

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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h4>Interview Evaluations</h4>
                            <a href="{{ url('admin/hr/create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Create Evaluation
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="interview-evaluations-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Candidate Name</th>
                                            <th>Position</th>
                                            <th>Department</th>
                                            <th>Interviewer</th>
                                            <th>Interview Date</th>
                                            <th>Total Score</th>
                                            <th>Recommendation</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $sampleEvaluations = [
                                                [
                                                    'id' => 1,
                                                    'candidate_name' => 'John Miller',
                                                    'phone' => '(555) 123-4567',
                                                    'email' => 'john.miller@example.com',
                                                    'position' => 'Dispatcher',
                                                    'department' => 'Operations',
                                                    'expected_salary' => '$45,000',
                                                    'experience' => '3 years',
                                                    'city' => 'Chicago, IL',
                                                    'reference' => 'Referred by Mike Adams',
                                                    'interviewer' => 'Sarah Johnson',
                                                    'interview_date' => '2026-07-10',
                                                    'communication' => 8,
                                                    'english' => 9,
                                                    'computer_skills' => 7,
                                                    'confidence' => 8,
                                                    'learning_ability' => 8,
                                                    'dispatch_knowledge' => 6,
                                                    'negotiation_skills' => 7,
                                                    'typing_speed' => 55,
                                                    'total_score' => 53,
                                                    'strengths' => 'Strong communicator, quick learner.',
                                                    'weaknesses' => 'Limited dispatch experience.',
                                                    'comments' => 'Good culture fit, needs onboarding support.',
                                                    'recommendation' => 'Recommended',
                                                    'status' => 'Pending',
                                                ],
                                                [
                                                    'id' => 2,
                                                    'candidate_name' => 'Amina Yusuf',
                                                    'phone' => '(555) 987-6543',
                                                    'email' => 'amina.yusuf@example.com',
                                                    'position' => 'Recruiter',
                                                    'department' => 'HR',
                                                    'expected_salary' => '$50,000',
                                                    'experience' => '5 years',
                                                    'city' => 'Dallas, TX',
                                                    'reference' => 'LinkedIn applicant',
                                                    'interviewer' => 'David Lee',
                                                    'interview_date' => '2026-07-14',
                                                    'communication' => 9,
                                                    'english' => 9,
                                                    'computer_skills' => 8,
                                                    'confidence' => 9,
                                                    'learning_ability' => 9,
                                                    'dispatch_knowledge' => 5,
                                                    'negotiation_skills' => 8,
                                                    'typing_speed' => 62,
                                                    'total_score' => 57,
                                                    'strengths' => 'Excellent negotiation and interpersonal skills.',
                                                    'weaknesses' => 'New to trucking industry terminology.',
                                                    'comments' => 'Highly polished interview, strong references.',
                                                    'recommendation' => 'Highly Recommended',
                                                    'status' => 'Selected',
                                                ],
                                            ];
                                        @endphp

                                        @foreach ($sampleEvaluations as $evaluation)
                                            <tr>
                                                <td>{{ $evaluation['id'] }}</td>
                                                <td>{{ $evaluation['candidate_name'] }}</td>
                                                <td>{{ $evaluation['position'] }}</td>
                                                <td>{{ $evaluation['department'] }}</td>
                                                <td>{{ $evaluation['interviewer'] }}</td>
                                                <td>{{ $evaluation['interview_date'] }}</td>
                                                <td>{{ $evaluation['total_score'] }}</td>
                                                <td>{{ $evaluation['recommendation'] }}</td>
                                                <td>{{ $evaluation['status'] }}</td>
                                                <td class="text-center text-nowrap">
                                                    <a href="#" class="view-item btn btn-sm btn-info" data-record="{{ json_encode($evaluation) }}"><i class="fas fa-eye"></i></a>
                                                    <a href="{{ url('admin/hr/' . $evaluation['id'] . '/edit') }}" class="btn btn-sm btn-primary ml-2"><i class="fas fa-edit"></i></a>
                                                    <a href="#" class="delete-item btn btn-sm btn-danger ml-2"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).on('click', '.view-item', function (e) {
            e.preventDefault();
            var evaluation = $(this).data('record');

            $('#ve-candidate_name').text(evaluation.candidate_name || '-');
            $('#ve-phone').text(evaluation.phone || '-');
            $('#ve-email').text(evaluation.email || '-');
            $('#ve-position').text(evaluation.position || '-');
            $('#ve-department').text(evaluation.department || '-');
            $('#ve-expected_salary').text(evaluation.expected_salary || '-');
            $('#ve-experience').text(evaluation.experience || '-');
            $('#ve-city').text(evaluation.city || '-');
            $('#ve-reference').text(evaluation.reference || '-');
            $('#ve-interviewer').text(evaluation.interviewer || '-');
            $('#ve-interview_date').text(evaluation.interview_date || '-');
            $('#ve-communication').text(evaluation.communication || '-');
            $('#ve-english').text(evaluation.english || '-');
            $('#ve-computer_skills').text(evaluation.computer_skills || '-');
            $('#ve-confidence').text(evaluation.confidence || '-');
            $('#ve-learning_ability').text(evaluation.learning_ability || '-');
            $('#ve-dispatch_knowledge').text(evaluation.dispatch_knowledge || '-');
            $('#ve-negotiation_skills').text(evaluation.negotiation_skills || '-');
            $('#ve-typing_speed').text(evaluation.typing_speed || '-');
            $('#ve-total_score').text(evaluation.total_score || '-');
            $('#ve-strengths').text(evaluation.strengths || '-');
            $('#ve-weaknesses').text(evaluation.weaknesses || '-');
            $('#ve-comments').text(evaluation.comments || '-');
            $('#ve-recommendation').text(evaluation.recommendation || '-');
            $('#ve-status').text(evaluation.status || '-');

            $('#viewEvaluationModal').modal('show');
        });
    </script>
@endpush
