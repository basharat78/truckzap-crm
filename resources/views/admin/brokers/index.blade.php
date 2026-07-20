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
                                <button type="button" id="copy-form-link" class="btn btn-secondary btn-sm mr-2" data-url="{{ url('form') }}">
                                    <i class="fas fa-link"></i> Copy Form Link
                                </button>
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

    <div class="modal fade" id="viewBrokerModal" tabindex="-1" role="dialog" aria-labelledby="viewBrokerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewBrokerModalLabel">Broker Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center" id="viewBrokerLoading">
                        <i class="fas fa-spinner fa-spin"></i> Loading...
                    </div>
                    <div id="viewBrokerContent" style="display: none;">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Company Name:</strong> <span id="vb-company_name"></span></p>
                                <p><strong>Dispatcher Name:</strong> <span id="vb-dispatcher_name"></span></p>
                                <p><strong>MC Number:</strong> <span id="vb-mc_number"></span></p>
                                <p><strong>DOT Number:</strong> <span id="vb-dot_number"></span></p>
                                <p><strong>Website:</strong> <span id="vb-website"></span></p>
                                <p><strong>Status:</strong> <span id="vb-status"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Contact Name:</strong> <span id="vb-name"></span></p>
                                <p><strong>Email:</strong> <span id="vb-email"></span></p>
                                <p><strong>Phone:</strong> <span id="vb-phone"></span></p>
                                <p><strong>Address:</strong> <span id="vb-address"></span></p>
                                <p><strong>City/State/Zip:</strong> <span id="vb-city_state_zip"></span></p>
                                <p><strong>Credit Score:</strong> <span id="vb-credit_score"></span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Equipment Type:</strong> <span id="vb-equipment_type"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Operating States:</strong> <span id="vb-operating_states"></span></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Days to Pay:</strong> <span id="vb-days_to_pay"></span></p>
                            </div>
                        </div>
                        <p><strong>Notes:</strong></p>
                        <p id="vb-notes"></p>
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
        $('#copy-form-link').on('click', function () {
            var url = $(this).data('url');

            navigator.clipboard.writeText(url).then(function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Copied!',
                    text: 'Broker form link copied to clipboard.',
                    confirmButtonColor: '#6777ef',
                    timer: 1500,
                    showConfirmButton: false
                });
            }).catch(function () {
                Swal.fire('Error!', 'Could not copy the link to clipboard.', 'error');
            });
        });

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
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center text-nowrap' },
            ]
        });

        $('#status-filter').on('change', function () {
            brokersTable.draw();
        });

        $('.status-card').on('click', function (e) {
            e.preventDefault();
            $('#status-filter').val($(this).data('status')).trigger('change');
        });

        $(document).on('click', '.view-item', function (e) {
            e.preventDefault();
            var url = $(this).data('url');

            $('#viewBrokerContent').hide();
            $('#viewBrokerLoading').show();
            $('#viewBrokerModal').modal('show');

            $.ajax({
                url: url,
                type: 'GET',
                success: function (response) {
                    var broker = response.broker;

                    $('#vb-company_name').text(broker.company_name || '-');
                    $('#vb-dispatcher_name').text(broker.dispatcher_name || '-');
                    $('#vb-mc_number').text(broker.mc_number || '-');
                    $('#vb-dot_number').text(broker.dot_number || '-');
                    $('#vb-website').text(broker.website || '-');
                    $('#vb-status').text(broker.status ? broker.status.charAt(0).toUpperCase() + broker.status.slice(1) : '-');
                    $('#vb-name').text(broker.name || '-');
                    $('#vb-email').text(broker.email || '-');
                    $('#vb-phone').text(broker.phone || '-');
                    $('#vb-address').text(broker.address || '-');
                    $('#vb-city_state_zip').text([broker.city, broker.state, broker.zip_code].filter(Boolean).join(', ') || '-');
                    $('#vb-credit_score').text(broker.credit_score || '-');
                    $('#vb-equipment_type').text((broker.equipment_type || []).join(', ') || '-');
                    $('#vb-operating_states').text((broker.operating_states || []).join(', ') || '-');
                    $('#vb-days_to_pay').text(broker.days_to_pay || '-');
                    $('#vb-notes').text(broker.notes || '-');

                    $('#viewBrokerLoading').hide();
                    $('#viewBrokerContent').show();
                },
                error: function () {
                    $('#viewBrokerModal').modal('hide');
                    Swal.fire('Error!', 'Something went wrong while fetching broker details.', 'error');
                }
            });
        });
    </script>
@endpush
