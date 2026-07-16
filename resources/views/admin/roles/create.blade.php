@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ route('admin.dashboard.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Roles &amp; Permissions</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Roles</a></div>
                <div class="breadcrumb-item">Create</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>New Role</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('admin/roles') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Role Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="form-group">
                                    <label class="d-flex align-items-center justify-content-between">
                                        <span>Permissions</span>
                                        <span>
                                            <input type="checkbox" id="select-all-permissions">
                                            <label for="select-all-permissions" class="mb-0 ml-1">Select All</label>
                                        </span>
                                    </label>

                                    @forelse ($permissionGroups ?? [] as $group => $permissions)
                                        <div class="card mb-2">
                                            <div class="card-header py-2 d-flex align-items-center justify-content-between">
                                                <strong>{{ ucfirst($group) }}</strong>
                                                <div>
                                                    <input type="checkbox" class="select-group-permissions" data-group="{{ $group }}">
                                                    <label class="mb-0 ml-1">Select All</label>
                                                </div>
                                            </div>
                                            <div class="card-body py-2">
                                                <div class="row">
                                                    @foreach ($permissions as $permission)
                                                        <div class="col-md-3">
                                                            <div class="form-group form-check">
                                                                <input type="checkbox"
                                                                    class="form-check-input permission-checkbox group-{{ $group }}"
                                                                    name="permissions[]"
                                                                    id="permission-{{ $permission->id }}"
                                                                    value="{{ $permission->id }}"
                                                                    {{ collect(old('permissions'))->contains($permission->id) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="permission-{{ $permission->id }}">
                                                                    {{ $permission->name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-muted">No permissions available.</p>
                                    @endforelse
                                </div>

                                <div class="form-group mb-0">
                                    <button type="submit" class="btn btn-primary">Create Role</button>
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
        $('#select-all-permissions').on('change', function() {
            $('.permission-checkbox').prop('checked', $(this).is(':checked'));
            $('.select-group-permissions').prop('checked', $(this).is(':checked'));
        });

        $('.select-group-permissions').on('change', function() {
            var group = $(this).data('group');
            $('.group-' + group).prop('checked', $(this).is(':checked'));
        });
    </script>
@endpush
