@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Brokers</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Brokers</div>
            </div>
        </div>

        <div class="section-body">
            @php
                $statusCounts = $statusCounts ?? collect();
                $statusCards = [
                    'active' => ['label' => 'Active', 'icon' => 'fa-check-circle', 'bg' => 'bg-success'],
                    'inactive' => ['label' => 'Inactive', 'icon' => 'fa-pause-circle', 'bg' => 'bg-secondary'],
                    'blacklisted' => ['label' => 'Blacklisted', 'icon' => 'fa-ban', 'bg' => 'bg-danger'],
                ];
            @endphp

            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a href="#" class="status-card" data-status="">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary">
                                <i class="fas fa-truck-loading"></i>
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
                            <h4>All Brokers</h4>
                            <div class="d-flex align-items-center">
                                <select id="status-filter" class="form-control form-control-sm mr-2" style="width: auto;">
                                    <option value="">All Statuses</option>
                                    <option value="active">Active</option>
                                    <option value="pending">Pending</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="blacklisted">Blacklisted</option>
                                </select>
                                <a href="{{ url('admin/brokers/create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i> Create Broker
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="brokers-table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Company Name</th>
                                            <th>MC Number</th>
                                            <th>Contact Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>City/State</th>
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
@endsection

@push('scripts')
    <script>
        var brokersTable = $('#brokers-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('admin/brokers') }}",
                data: function (d) {
                    d.status = $('#status-filter').val();
                }
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'company_name', name: 'company_name' },
                { data: 'mc_number', name: 'mc_number' },
                { data: 'name', name: 'name' },
                { data: 'phone', name: 'phone' },
                { data: 'email', name: 'email' },
                { data: 'city_state', name: 'city_state', orderable: false, searchable: false },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });

        $('#status-filter').on('change', function () {
            brokersTable.draw();
        });

        $('.status-card').on('click', function (e) {
            e.preventDefault();
            $('#status-filter').val($(this).data('status')).trigger('change');
        });
    </script>
@endpush
