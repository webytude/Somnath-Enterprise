@extends('admin.layouts.main')

@section('title', 'Permissions')

@section('main_contant')
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="card">
            <div class="card-header border-0 pt-6">
                <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Permissions</h1>
            </div>
            <div class="card-body py-4">
                <p class="text-muted mb-4">Access is checked using <code>permissions.name</code> (not Laravel route names). Use the same string in middleware and <code>@@hasPermission('your.permission')</code>.</p>
                <div class="table-responsive">
                    <table class="table table-row-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Module</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permissions as $permission)
                                <tr>
                                    <td><code>{{ $permission->name }}</code></td>
                                    <td>{{ $permission->module ? ucfirst((string) $permission->module) : '—' }}</td>
                                    <td>{{ $permission->action ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center">No permissions found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
