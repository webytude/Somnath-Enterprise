@section('title','Add Division')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Add Division</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-12">
                <div class="card card-flush h-lg-100" id="kt_division_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_division_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('division.store') }}">
                            @csrf
                            
                            <!-- Basic Information Section -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-10">
                                <h4 class="text-gray-800 mb-4">Basic Information</h4>
                                <div class="row g-5">
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label required">Division Name</label>
                                        <input type="text" class="form-control form-control-solid" name="name" value="{{ old('name') }}" placeholder="Enter Division name" required />
                                        @error('name')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label required">Department</label>
                                        <select class="form-select form-select-solid" name="department_id" id="department_id" data-control="select2" data-placeholder="Select Department..." required>
                                            <option value="">Select Department...</option>
                                            @foreach($departments as $dept)
                                                <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('department_id')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label required">Sub Department</label>
                                        <select class="form-select form-select-solid" name="subdepartment_id" id="subdepartment_id" data-control="select2" data-placeholder="Select Sub Department..." required>
                                            <option value="">Select Sub Department...</option>
                                        </select>
                                        @error('subdepartment_id')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">Head of Division Name</label>
                                        <input type="text" class="form-control form-control-solid" name="head_of_division_name" value="{{ old('head_of_division_name') }}" placeholder="Enter Head of Division Name" />
                                        @error('head_of_division_name')
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
                                        <label class="fs-6 fw-bold form-label">Mobile Number Of Head</label>
                                        <input type="text" class="form-control form-control-solid" name="head_mobile_number" value="{{ old('head_mobile_number') }}" placeholder="Enter Mobile Number Of Head" />
                                        @error('head_mobile_number')
                                            <span class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">Contact Number</label>
                                        <input type="text" class="form-control form-control-solid" name="contact_number" value="{{ old('contact_number') }}" placeholder="Enter Contact Number" />
                                        @error('contact_number')
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

                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('division.index') }}" data-kt-division-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-division-form="submit" class="btn btn-primary">
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

@section('custom_scripts')
<script>
    $(document).ready(function() {
        $('#department_id').on('change', function() {
            var departmentId = $(this).val();
            var subdepartmentSelect = $('#subdepartment_id');
            
            // Clear existing options
            subdepartmentSelect.empty();
            subdepartmentSelect.append('<option value="">Select Sub Department...</option>');
            
            if (departmentId) {
                $.ajax({
                    url: '{{ route("division.getSubdepartments") }}',
                    type: 'GET',
                    data: { department_id: departmentId },
                    success: function(data) {
                        $.each(data, function(key, value) {
                            subdepartmentSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        // Trigger select2 update
                        subdepartmentSelect.trigger('change');
                    }
                });
            }
        });
    });
</script>
@endsection
