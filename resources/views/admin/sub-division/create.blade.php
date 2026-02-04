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
            <div class="col-xl-12">
                <div class="card card-flush h-lg-100" id="kt_sub_division_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_sub_division_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('sub-division.store') }}">
                            @csrf
                            
                            <!-- Basic Information Section -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-10">
                                <h4 class="text-gray-800 mb-4">Basic Information</h4>
                                <div class="row g-5">
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label required">Sub-Division Name</label>
                                        <input type="text" class="form-control form-control-solid" name="name" value="{{ old('name') }}" placeholder="Enter Sub Division name" required />
                                        @error('name')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label required">Division</label>
                                        <select class="form-select form-select-solid" name="division_id" id="division_id" data-control="select2" data-placeholder="Select Division..." required>
                                            <option value="">Select Division...</option>
                                            @foreach($divisions as $division)
                                                <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('division_id')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">Head of Sub Division</label>
                                        <input type="text" class="form-control form-control-solid" name="head_of_sub_division" value="{{ old('head_of_sub_division') }}" placeholder="Enter Head of Sub Division" />
                                        @error('head_of_sub_division')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">Name of Sub-Div. Head</label>
                                        <input type="text" class="form-control form-control-solid" name="name_of_sub_div_head" value="{{ old('name_of_sub_div_head') }}" placeholder="Enter Name of Sub-Div. Head" />
                                        @error('name_of_sub_div_head')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="fs-6 fw-bold form-label">Sub-Division Address</label>
                                        <textarea class="form-control form-control-solid" name="address" rows="3" placeholder="Enter Sub-Division Address">{{ old('address') }}</textarea>
                                        @error('address')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">Mobile Number Of Head</label>
                                        <input type="text" class="form-control form-control-solid" name="head_mobile_number" value="{{ old('head_mobile_number') }}" placeholder="Enter Mobile Number Of Head" />
                                        @error('head_mobile_number')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="separator mb-10"></div>

                            <!-- Additional Information Section -->
                            <div class="mb-10">
                                <h4 class="text-gray-800 mb-4">Additional Information</h4>
                                <div class="row g-5">
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">Sub-Div. Cont. Per. Name</label>
                                        <input type="text" class="form-control form-control-solid" name="sub_div_contact_person_name" value="{{ old('sub_div_contact_person_name') }}" placeholder="Enter Sub-Div. Contact Person Name" />
                                        @error('sub_div_contact_person_name')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">Contact Person Name</label>
                                        <input type="text" class="form-control form-control-solid" name="contact_person_name" value="{{ old('contact_person_name') }}" placeholder="Enter Contact Person Name" />
                                        @error('contact_person_name')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">Contact Person Mobile Number</label>
                                        <input type="text" class="form-control form-control-solid" name="contact_person_mobile_number" value="{{ old('contact_person_mobile_number') }}" placeholder="Enter Contact Person Mobile Number" />
                                        @error('contact_person_mobile_number')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="separator mb-10"></div>

                            <!-- Remarks Section -->
                            <div class="mb-10">
                                <div class="row g-5">
                                    <div class="col-md-12">
                                        <label class="fs-6 fw-bold form-label">Remarks</label>
                                        <textarea class="form-control form-control-solid" name="remark" rows="4" placeholder="Enter Remarks">{{ old('remark') }}</textarea>
                                        @error('remark')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('sub-division.index') }}" data-kt-sub-division-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-sub-division-form="submit" class="btn btn-primary">
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
