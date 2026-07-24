@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Create Broker</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Brokers</a></div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>New Broker</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('admin/brokers') }}" method="POST">
                                @csrf

                                <h6 class="text-uppercase text-muted mb-3">Company Information</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Dispatcher Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="dispatcher_name" value="{{ old('dispatcher_name') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Company Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">MC Number <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="mc_number" value="{{ old('mc_number') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">DOT Number</label>
                                            <input type="text" class="form-control" name="dot_number" value="{{ old('dot_number') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Website</label>
                                            <input type="url" class="form-control" name="website" value="{{ old('website') }}" placeholder="https://">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <select name="status" class="form-control">
                                                <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                <option value="blacklisted" {{ old('status') == 'blacklisted' ? 'selected' : '' }}>Blacklisted</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <h6 class="text-uppercase text-muted mb-3">Contact Information</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Contact Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Department</label>
                                            <select name="department" id="">
                                                <option value="">Select Department</option>
                                                <option value="sales" {{ old('department') == 'sales' ? 'selected' : '' }}>Sales</option>
                                                <option value="support" {{ old('department') == 'support' ? 'selected' : '' }}>Support</option>
                                                <option value="operations" {{ old('department') == 'operations' ? 'selected' : '' }}>Operations</option>
                                            </select>
                                        </div>
                                    </div> --}}

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Phone <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <h6 class="text-uppercase text-muted mb-3">Address Information</h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Address <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="address" value="{{ old('address') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">City <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="city" value="{{ old('city') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">State <span class="text-danger">*</span></label>
                                            <select name="state"  class="form-control select2">
                                                <option value="">Select</option>
                                                @foreach (config('states.states') as $key => $state)
                                                    <option @selected($key === old('state')) value="{{ $key }}">{{ $state }}</option>
                                                @endforeach
                                            </select>
                                 </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Zip Code <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="zip_code" value="{{ old('zip_code') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <h6 class="text-uppercase text-muted mb-3">Operations</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Equipment Type <span class="text-danger">*</span></label>
                                            <select name="equipment_type[]" class="form-control select2" multiple required>
                                                @foreach ($equipmentTypes ?? ['Box Truck', 'Dry Van', 'Flatbed', 'Reefer (Refrigerated)', 'Step Deck', 'Lowboy', 'Conestoga', 'Power Only', 'Tanker', 'Car Hauler', 'Hotshot','RGN','Sprinter Van','Intermodal'] as $type)
                                                    <option @selected(collect(old('equipment_type'))->contains($type)) value="{{ $type }}">{{ $type }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Operating States <span class="text-danger">*</span></label>
                                            <select name="operating_states[]" class="form-control select2" multiple required>
                                                @foreach (config('states.states') as $key => $state)
                                                    <option @selected(collect(old('operating_states'))->contains($key)) value="{{ $key }}">{{ $state }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Credit Score</label>
                                            <input type="text" class="form-control" name="credit_score" value="{{ old('credit_score') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="">Days to Pay</label>
                                            <input type="number" class="form-control" name="days_to_pay" value="{{ old('days_to_pay') }}">
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Notes</label>
                                            <textarea class="form-control" name="notes" rows="3">{{ old('notes') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary">Create Broker</button>
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
        $('.select2').select2();
    </script>
@endpush
