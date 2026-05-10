@extends('admin.layouts.main')

@section('title', 'Edit Role')

@section('main_contant')
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Edit Role</h1>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('roles.update', $role) }}">
                    @csrf @method('PUT')
                    <div class="mb-5">
                        <label class="form-label required">Role Name</label>
                        <input type="text" class="form-control form-control-solid" name="name" value="{{ old('name', $role->name) }}" required />
                    </div>
                    <div class="mb-5">
                        <label class="form-label">Permissions (by <code>name</code>)</label>
                        @foreach($permissions as $module => $modulePermissions)
                            <div class="mb-4">
                                <h5 class="mb-2">{{ $module ? ucfirst((string) $module) : 'General' }}</h5>
                                <div class="row">
                                    @foreach($modulePermissions as $permission)
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="permission_{{ $permission->id }}"
                                                    {{ in_array($permission->id, old('permissions', $selectedPermissions)) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                    <code>{{ $permission->name }}</code>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('roles.index') }}" class="btn btn-light me-3 ms-3">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
