@section('title','Add Firm')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Add Firm</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-12">
                <div class="card card-flush h-lg-100" id="kt_firm_form_main">
                    <!-- <div class="card-header">
                        <h3 class="card-title">Firm Information</h3>
                    </div> -->
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_firm_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('firms.store') }}">
                            @csrf
                            
                            <!-- Basic Information Section -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-10">
                                <h4 class="text-gray-800 mb-4">Basic Information</h4>
                                <div class="row g-5">
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label required">Name</label>
                                        <input type="text" class="form-control form-control-solid" name="name" value="{{ old('name') }}" placeholder="Enter Firm Name" required />
                                        @error('name')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">Mobile No.</label>
                                        <input type="text" class="form-control form-control-solid" name="mobile_number" value="{{ old('mobile_number') }}" placeholder="Enter Mobile Number" />
                                        @error('mobile_number')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="fs-6 fw-bold form-label">Address</label>
                                        <textarea class="form-control form-control-solid" name="address" rows="3" placeholder="Enter Address">{{ old('address') }}</textarea>
                                        @error('address')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">Pancard</label>
                                        <input type="text" class="form-control form-control-solid" name="pancard" value="{{ old('pancard') }}" placeholder="Enter Pancard" />
                                        @error('pancard')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">GST</label>
                                        <input type="text" class="form-control form-control-solid" name="gst" value="{{ old('gst') }}" placeholder="Enter GST" />
                                        @error('gst')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">PF Code</label>
                                        <input type="text" class="form-control form-control-solid" name="pf_code" value="{{ old('pf_code') }}" placeholder="Enter PF Code" />
                                        @error('pf_code')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">Email Id</label>
                                        <input type="email" class="form-control form-control-solid" name="email" value="{{ old('email') }}" placeholder="Enter Email Id" />
                                        @error('email')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="separator mb-10"></div>

                            <!-- Bank Information Section -->
                            <div class="mb-10">
                                <h4 class="text-gray-800 mb-4">Bank Information</h4>
                                <div class="row g-5">
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label">Bank Name</label>
                                        <input type="text" class="form-control form-control-solid" name="bank_name" value="{{ old('bank_name') }}" placeholder="Enter Bank Name" />
                                        @error('bank_name')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label">Bank A/c. No.</label>
                                        <input type="text" class="form-control form-control-solid" name="bank_account_no" value="{{ old('bank_account_no') }}" placeholder="Enter Bank Account Number" />
                                        @error('bank_account_no')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label">IFSC Code</label>
                                        <input type="text" class="form-control form-control-solid" name="ifsc_code" value="{{ old('ifsc_code') }}" placeholder="Enter IFSC Code" />
                                        @error('ifsc_code')
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
                                        <label class="fs-6 fw-bold form-label">Head Name</label>
                                        <input type="text" class="form-control form-control-solid" name="head_name" value="{{ old('head_name') }}" placeholder="Enter Head Name" />
                                        @error('head_name')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">Head Mo. No</label>
                                        <input type="text" class="form-control form-control-solid" name="head_mobile_number" value="{{ old('head_mobile_number') }}" placeholder="Enter Head Mobile Number" />
                                        @error('head_mobile_number')
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
                                <a href="{{ route('firms.index') }}" data-kt-firm-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-firm-form="submit" class="btn btn-primary">
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
