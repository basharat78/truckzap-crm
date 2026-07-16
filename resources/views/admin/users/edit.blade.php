@extends('admin.layouts.master')

@section('contents')
    <section class="section">
        <div class="section-header">
            <div class="section-header-back">
                <a href="{{ url('admin/users') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
            </div>
            <h1>Edit User</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('admin.dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ url('admin/users') }}">Users</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit User</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url('admin/users/' . $user->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Name <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Password</label>
                                            <input type="password" class="form-control" name="password">
                                            <small class="text-muted">Leave blank to keep current password.</small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Confirm Password</label>
                                            <input type="password" class="form-control" name="password_confirmation">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Role</label>
                                            <select name="role" class="form-control select2">
                                                <option value="">-- Select Role --</option>
                                                @foreach ($roles ?? [] as $role)
                                                    <option value="{{ $role->id }}" {{ old('role', $user->roles->first()->id ?? null) == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Status</label>
                                            <select name="status" class="form-control">
                                                <option value="1" {{ old('status', $user->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ old('status', $user->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Avatar</label>
                                            <div id="image-preview" class="image-preview avatar-preview">
                                                <label for="image-upload" id="image-label">Change File</label>
                                                <input type="file" name="avatar" id="image-upload" accept="image/*" />
                                                <input type="hidden" name="old_avatar" value="{{ $user->avatar }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group mb-0">
                                            <button type="submit" class="btn btn-primary">Update User</button>
                                        </div>
                                    </div>
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

        $(document).ready(function() {
            $('.avatar-preview').css({
                'background-image': 'url({{ asset($user->avatar ?? "default/avatar.png") }})',
                'background-size': 'cover',
                'background-position': 'center center'
            });
        });

        $.uploadPreview({
            input_field: "#image-upload",
            preview_box: "#image-preview",
            label_field: "#image-label",
            label_default: "Choose File",
            label_selected: "Change File",
            no_label: false,
            success_callback: null
        });
    </script>
@endpush
