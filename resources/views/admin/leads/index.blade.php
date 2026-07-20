@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Leads</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Leads</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h4>Leads from WhatsApp</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="leads-table">
                                    <thead>
                                        <tr>
                                            <th>Received</th>
                                            <th>Sender</th>
                                            <th>Group</th>
                                            <th>Message</th>
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

    <div class="modal fade" id="fullMessageModal" tabindex="-1" role="dialog" aria-labelledby="fullMessageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fullMessageModalLabel">Full Message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p id="fullMessageContent" style="white-space: pre-wrap;"></p>
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
        var leadsTable = $('#leads-table').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'desc']],
            ajax: {
                url: "{{ url('admin/leads') }}"
            },
            columns: [
                { data: 'received_at', name: 'received_at' },
                { data: 'sender', name: 'sender', orderable: false, searchable: false },
                { data: 'group_name', name: 'group_name' },
                { data: 'message', name: 'message' },
            ]
        });

        setInterval(function () {
            leadsTable.ajax.reload(null, false);
        }, 15000);

        $(document).on('click', '.read-more-message', function (e) {
            e.preventDefault();
            $('#fullMessageContent').text($(this).data('message'));
            $('#fullMessageModal').modal('show');
        });
    </script>
@endpush
