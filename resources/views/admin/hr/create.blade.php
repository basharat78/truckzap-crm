@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Create Interview Evaluation</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ url('admin/hr') }}">HR</a></div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Interview Evaluation Form</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('admin/hr') }}" method="POST" id="interview-evaluation-form">
                                @csrf

                                <h6 class="text-uppercase text-muted mb-3">Candidate Information</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Candidate Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="candidate_name" value="{{ old('candidate_name') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Phone <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Position</label>
                                            <input type="text" class="form-control" name="position" value="{{ old('position') }}">
                                        </div>
                                    </div> --}}
                                     <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Position <span class="text-danger">*</span></label>
                                            <select name="position" id="" class="form-control" required>
                                                <option value="">Select Position</option>
                                                <option value="dispatcher" {{ old('position') == 'dispatcher' ? 'selected' : '' }}>Dispatcher</option>
                                                <option value="sales executive" {{ old('position') == 'sales executive' ? 'selected' : '' }}>Sales Executive</option>
                                                <option value="hr" {{ old('position') == 'hr' ? 'selected' : '' }}>Human Resource (HR)</option>
                                                 <option value="carrier sales" {{ old('position') == 'carrier sales' ? 'selected' : '' }}>Carrier Sales</option>
                                                <option value="accounts" {{ old('position') == 'accounts' ? 'selected' : '' }}>Accounts</option>
                                                <option value="onboarding" {{ old('position') == 'onboarding' ? 'selected' : '' }}>OnBoarding</option>
                                                 <option value="marketing" {{ old('position') == 'marketing' ? 'selected' : '' }}>Marketing</option>
                                                <option value="other" {{ old('position') == 'other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>
                                    </div> 

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Department</label>
                                            <input type="text" class="form-control" name="department" value="{{ old('department') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Expected Salary <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="expected_salary" value="{{ old('expected_salary') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Experience</label>
                                            <input type="number" class="form-control" name="experience" value="{{ old('experience') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">City</label>
                                            <input type="text" class="form-control" name="city" value="{{ old('city') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Reference</label>
                                            <input type="text" class="form-control" name="reference" value="{{ old('reference') }}">
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <h6 class="text-uppercase text-muted mb-3">Interview Information</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Interviewer <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="interviewer" value="{{ old('interviewer') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Interview Date <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="interview_date" value="{{ old('interview_date') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <h6 class="text-uppercase text-muted mb-3">Skills Evaluation (1-10)</h6>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Communication</label>
                                            <input type="number" class="form-control skill-score" name="communication" min="1" max="10" value="{{ old('communication') }}" >
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">English</label>
                                            <input type="number" class="form-control skill-score" name="english" min="1" max="10" value="{{ old('english') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Computer Skills</label>
                                            <input type="number" class="form-control skill-score" name="computer_skills" min="1" max="10" value="{{ old('computer_skills') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Confidence</label>
                                            <input type="number" class="form-control skill-score" name="confidence" min="1" max="10" value="{{ old('confidence') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Learning Ability</label>
                                            <input type="number" class="form-control skill-score" name="learning_ability" min="1" max="10" value="{{ old('learning_ability') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Dispatch Knowledge</label>
                                            <input type="number" class="form-control skill-score" name="dispatch_knowledge" min="1" max="10" value="{{ old('dispatch_knowledge') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Negotiation Skills</label>
                                            <input type="number" class="form-control skill-score" name="negotiation_skills" min="1" max="10" value="{{ old('negotiation_skills') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Typing Speed (WPM)</label>
                                            <input type="number" class="form-control" name="typing_speed" min="0" value="{{ old('typing_speed') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="">Total Score</label>
                                            <input type="number" class="form-control" name="total_score" id="total_score" value="{{ old('total_score') }}" readonly>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <h6 class="text-uppercase text-muted mb-3">Interview Notes</h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Strengths</label>
                                            <textarea class="form-control" name="strengths" rows="3">{{ old('strengths') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Weaknesses</label>
                                            <textarea class="form-control" name="weaknesses" rows="3">{{ old('weaknesses') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Comments</label>
                                            <textarea class="form-control" name="comments" rows="3">{{ old('comments') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <h6 class="text-uppercase text-muted mb-3">Final Decision</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Recommendation</label>
                                            <select name="recommendation" class="form-control">
                                                <option value="">Select</option>
                                                <option value="highly_recommended" {{ old('recommendation') == 'highly_recommended' ? 'selected' : '' }}>Highly Recommended</option>
                                                <option value="recommended" {{ old('recommendation') == 'recommended' ? 'selected' : '' }}>Recommended</option>
                                                <option value="maybe" {{ old('recommendation') == 'maybe' ? 'selected' : '' }}>Maybe</option>
                                                <option value="not_recommended" {{ old('recommendation') == 'not_recommended' ? 'selected' : '' }}>Not Recommended</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <select name="status" class="form-control" required>
                                                <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="selected" {{ old('status') == 'selected' ? 'selected' : '' }}>Selected</option>
                                                <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                <option value="on_hold" {{ old('status') == 'on_hold' ? 'selected' : '' }}>On Hold</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary">Create Evaluation</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        (function () {
            function recalcTotalScore() {
                var total = 0;
                $('.skill-score').each(function () {
                    total += parseInt($(this).val(), 10) || 0;
                });
                $('#total_score').val(total);
            }

            $(document).on('input', '.skill-score', recalcTotalScore);
            recalcTotalScore();
        })();
    </script>
@endpush
