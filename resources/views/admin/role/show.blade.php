@extends('admin.layouts.main')

@section('title', 'View Role')

@section('main_contant')
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="card">
            <div class="card-header border-0 pt-6 d-flex justify-content-between align-items-center">
                <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">{{ $role->name }}</h1>
                @hasPermission('roles.edit')
                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-primary">Edit</a>
                @endhasPermission
            </div>
            <div class="card-body">
                <h5 class="mb-3">Permission names</h5>
                <ul class="list-unstyled">
                    @forelse($role->permissions as $permission)
                        <li><code>{{ $permission->name }}</code></li>
                    @empty
                        <li>No permissions assigned.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
