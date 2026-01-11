@section('title','Add Sub Division')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Add Sub Division</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            
            <div class="col-xl-6">
                <div class="card card-flush h-lg-100" id="kt_attendance_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_attendance_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('sub-division.store') }}">
                        @csrf
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Sub Division Name</label>
                                <input type="text" class="form-control form-control-solid" name="name" placeholder="Enter Sub Division name" />
                                @error('name')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Division</label>
                                <select class="form-select form-select-solid" name="division_id" id="division_id" data-control="select2" data-placeholder="Select Division...">
                                    <option value="">Select Division...</option>
                                    @foreach($divisions as $division)
                                        <option value="{{ $division->id }}">{{ $division->name }}</option>
                                    @endforeach
                                </select>
                                @error('division_id')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('sub-division.index')}}"  data-kt-attendance-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-attendance-form="submit" class="btn btn-primary">
                                    <span class="indicator-label">Save</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
