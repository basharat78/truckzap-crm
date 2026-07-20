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
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Received</th>
                                            <th>Sender</th>
                                            <th>Group</th>
                                            <th>Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($leads as $lead)
                                            <tr>
                                                <td>{{ optional($lead->sent_at)->format('d M Y, h:i A') ?? $lead->created_at->format('d M Y, h:i A') }}</td>
                                                <td>
                                                    {{ $lead->sender_name ?? '-' }}
                                                    @if ($lead->sender_phone)
                                                        <br><small class="text-muted">{{ $lead->sender_phone }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ $lead->group_name ?? '-' }}</td>
                                                <td>{{ $lead->message }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="text-center">No leads received yet.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $leads->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
