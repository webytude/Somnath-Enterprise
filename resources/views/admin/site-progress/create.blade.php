@section('title','Add Site Progress')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Add Site Progress</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-8">
                <div class="card card-flush h-lg-100" id="kt_site_progress_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_site_progress_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('site-progress.store') }}">
                            @csrf
                            
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Location</span>
                                </label>
                                <select class="form-select form-select-solid" name="location_id" id="location_id" data-control="select2" data-placeholder="Select Location...">
                                    <option value="">Select Location...</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Work Name</span>
                                </label>
                                <select class="form-select form-select-solid" name="work_name" id="work_name" data-control="select2" data-placeholder="Select Work Name...">
                                    <option value="">Select Work Name...</option>
                                    @foreach($workNames as $workName)
                                        <option value="{{ $workName }}" {{ old('work_name') == $workName ? 'selected' : '' }}>{{ $workName }}</option>
                                    @endforeach
                                </select>
                                @error('work_name')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Work Site</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="work_site" value="{{ old('work_site') }}" placeholder="Enter Work Site" />
                                @error('work_site')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Work Stage</label>
                                <textarea class="form-control form-control-solid" name="work_stage" rows="3" placeholder="Enter Work Stage">{{ old('work_stage') }}</textarea>
                                @error('work_stage')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Photo URL</label>
                                <input type="url" class="form-control form-control-solid" name="photo_url" value="{{ old('photo_url') }}" placeholder="Enter Photo URL (optional)" />
                                @error('photo_url')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                                <div class="form-text">Enter a valid URL for the photo (optional)</div>
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Date</span>
                                </label>
                                <input type="date" class="form-control form-control-solid" name="date" value="{{ old('date') }}" />
                                @error('date')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Remark</label>
                                <textarea class="form-control form-control-solid" name="remark" rows="3" placeholder="Enter Remark">{{ old('remark') }}</textarea>
                                @error('remark')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('site-progress.index')}}" data-kt-site-progress-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-site-progress-form="submit" class="btn btn-primary">
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

