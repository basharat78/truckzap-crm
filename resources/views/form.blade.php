<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Broker Form &mdash; Truckzap</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/modules/select2/dist/css/select2.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/components.css') }}">

</head>

<body>
  <div id="app">
    <section class="section">
      <div class="container mt-5 mb-5">
        <div class="row">
          <div class="col-12 col-lg-10 offset-lg-1">
            <div class="login-brand">
              Truck Zap
            </div>

            <div class="card card-primary">
              <div class="card-header">
                <h4>Broker Form</h4>
              </div>
              <div class="card-body">
                <form action="{{ url('form') }}" method="POST">
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
                                <label for="">DOT Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="dot_number" value="{{ old('dot_number') }}" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Website</label>
                                <input type="url" class="form-control" name="website" value="{{ old('website') }}" placeholder="https://">
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

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" required>
                            </div>
                        </div>

                        <div class="col-md-4">
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
                                <select name="state" class="form-control select2" required>
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Equipment Type <span class="text-danger">*</span></label>
                                <select name="equipment_type[]" class="form-control select2" multiple required>
                                    @foreach (['Box Truck', 'Dry Van', 'Flatbed', 'Reefer (Refrigerated)', 'Step Deck', 'Lowboy', 'Conestoga', 'Power Only', 'Tanker', 'Car Hauler', 'Hotshot', 'RGN', 'Sprinter Van', 'Intermodal'] as $type)
                                        <option @selected(collect(old('equipment_type'))->contains($type)) value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Operating States <span class="text-danger">*</span></label>
                                <select name="operating_states[]" class="form-control select2" multiple required>
                                    @foreach (config('states.states') as $key => $state)
                                        <option @selected(collect(old('operating_states'))->contains($key)) value="{{ $key }}">{{ $state }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="">Credit Score</label>
                                <input type="text" class="form-control" name="credit_score" value="{{ old('credit_score') }}">
                            </div>
                        </div>

                        <div class="col-md-3">
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
                        <button type="submit" class="btn btn-primary btn-lg">Submit Application</button>
                    </div>
                </form>
              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; Truck Zap {{ date('Y') }}
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="{{ asset('admin/assets/modules/jquery.min.js') }}"></script>
  <script src="{{ asset('admin/assets/modules/popper.js') }}"></script>
  <script src="{{ asset('admin/assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('admin/assets/modules/select2/dist/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('admin/assets/js/stisla.js') }}"></script>
  <script src="{{ asset('admin/assets/js/scripts.js') }}"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    (function () {
        $('.select2').select2();

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: @json(session('success')),
                confirmButtonColor: '#6777ef'
            });
        @endif
    })();
  </script>
</body>
</html>
