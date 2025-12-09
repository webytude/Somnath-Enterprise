@section('title','Edit Staff')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Edit Staff</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-12">
                <div class="card card-flush h-lg-100" id="kt_staff_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_staff_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('staff.update', $staff->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Personal Information -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-5">
                                <h3 class="mb-3">Personal Information</h3>
                            </div>
                            
                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Name</span>
                                    </label>
                                    <input type="text" class="form-control form-control-solid" name="name" value="{{ old('name', $staff->name) }}" placeholder="Enter Name" />
                                    @error('name')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Father Name</label>
                                    <input type="text" class="form-control form-control-solid" name="father_name" value="{{ old('father_name', $staff->father_name) }}" placeholder="Enter Father Name" />
                                    @error('father_name')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Date of Birth</label>
                                    <input type="date" class="form-control form-control-solid" name="dob" value="{{ old('dob', $staff->dob ? $staff->dob->format('Y-m-d') : '') }}" />
                                    @error('dob')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Date of Joining</label>
                                    <input type="date" class="form-control form-control-solid" name="doj" value="{{ old('doj', $staff->doj ? $staff->doj->format('Y-m-d') : '') }}" />
                                    @error('doj')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Designation</label>
                                    <input type="text" class="form-control form-control-solid" name="designation" value="{{ old('designation', $staff->designation) }}" placeholder="Enter Designation" />
                                    @error('designation')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Photo</label>
                                    @if($staff->photo)
                                        <div class="mb-2">
                                            <img src="{{ $staff->photo }}" alt="{{ $staff->name }}" class="w-100px h-100px rounded" style="object-fit: cover;">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control form-control-solid" name="photo" accept="image/*" />
                                    @error('photo')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Permanent Address</label>
                                    <textarea class="form-control form-control-solid" name="permanent_address" rows="3" placeholder="Enter Permanent Address">{{ old('permanent_address', $staff->permanent_address) }}</textarea>
                                    @error('permanent_address')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Present Address</label>
                                    <textarea class="form-control form-control-solid" name="present_address" rows="3" placeholder="Enter Present Address">{{ old('present_address', $staff->present_address) }}</textarea>
                                    @error('present_address')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Mobile Number</label>
                                    <input type="text" class="form-control form-control-solid" name="mobile_number" value="{{ old('mobile_number', $staff->mobile_number) }}" placeholder="Enter Mobile Number" />
                                    @error('mobile_number')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Gender</label>
                                    <select class="form-select form-select-solid" name="gender" data-control="select2" data-placeholder="Select Gender...">
                                        <option value="">Select Gender...</option>
                                        <option value="Male" {{ old('gender', $staff->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender', $staff->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ old('gender', $staff->gender) == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Marital Status</label>
                                    <select class="form-select form-select-solid" name="marital_status" data-control="select2" data-placeholder="Select Marital Status...">
                                        <option value="">Select Marital Status...</option>
                                        <option value="Single" {{ old('marital_status', $staff->marital_status) == 'Single' ? 'selected' : '' }}>Single</option>
                                        <option value="Married" {{ old('marital_status', $staff->marital_status) == 'Married' ? 'selected' : '' }}>Married</option>
                                        <option value="Divorced" {{ old('marital_status', $staff->marital_status) == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                                        <option value="Widowed" {{ old('marital_status', $staff->marital_status) == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                    </select>
                                    @error('marital_status')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Blood Group</label>
                                    <input type="text" class="form-control form-control-solid" name="blood_group" value="{{ old('blood_group', $staff->blood_group) }}" placeholder="Enter Blood Group" />
                                    @error('blood_group')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nominee Information -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-5">
                                <h3 class="mb-3">Nominee Information</h3>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Nominee Name</label>
                                    <input type="text" class="form-control form-control-solid" name="nominee_name" value="{{ old('nominee_name', $staff->nominee_name) }}" placeholder="Enter Nominee Name" />
                                    @error('nominee_name')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Relation of Nominee</label>
                                    <input type="text" class="form-control form-control-solid" name="nominee_relation" value="{{ old('nominee_relation', $staff->nominee_relation) }}" placeholder="Enter Relation" />
                                    @error('nominee_relation')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Document Information -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-5">
                                <h3 class="mb-3">Document Information</h3>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Aadhar No.</label>
                                    <input type="text" class="form-control form-control-solid" name="aadhar_no" value="{{ old('aadhar_no', $staff->aadhar_no) }}" placeholder="Enter Aadhar Number" />
                                    @error('aadhar_no')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">PAN No.</label>
                                    <input type="text" class="form-control form-control-solid" name="pan_no" value="{{ old('pan_no', $staff->pan_no) }}" placeholder="Enter PAN Number" />
                                    @error('pan_no')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">UAN No.</label>
                                    <input type="text" class="form-control form-control-solid" name="uan_no" value="{{ old('uan_no', $staff->uan_no) }}" placeholder="Enter UAN Number" />
                                    @error('uan_no')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">ESIC No.</label>
                                    <input type="text" class="form-control form-control-solid" name="esic_no" value="{{ old('esic_no', $staff->esic_no) }}" placeholder="Enter ESIC Number" />
                                    @error('esic_no')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Bank Information -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-5">
                                <h3 class="mb-3">Bank Information</h3>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Bank Name</label>
                                    <input type="text" class="form-control form-control-solid" name="bank_name" value="{{ old('bank_name', $staff->bank_name) }}" placeholder="Enter Bank Name" />
                                    @error('bank_name')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Bank Account No.</label>
                                    <input type="text" class="form-control form-control-solid" name="bank_account_no" value="{{ old('bank_account_no', $staff->bank_account_no) }}" placeholder="Enter Bank Account Number" />
                                    @error('bank_account_no')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-5">
                                <h3 class="mb-3">Additional Information</h3>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Date of Leaving</label>
                                    <input type="date" class="form-control form-control-solid" name="date_of_leaving" value="{{ old('date_of_leaving', $staff->date_of_leaving ? $staff->date_of_leaving->format('Y-m-d') : '') }}" />
                                    @error('date_of_leaving')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">No. of Years Service</label>
                                    <input type="number" class="form-control form-control-solid" name="no_of_years_service" value="{{ old('no_of_years_service', $staff->no_of_years_service) }}" placeholder="Enter Years" />
                                    @error('no_of_years_service')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-12">
                                    <label class="fs-6 fw-bold form-label mt-3">Remark</label>
                                    <textarea class="form-control form-control-solid" name="remark" rows="3" placeholder="Enter Remark">{{ old('remark', $staff->remark) }}</textarea>
                                    @error('remark')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('staff.index')}}" data-kt-staff-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-staff-form="submit" class="btn btn-primary">
                                    <span class="indicator-label">Update</span>
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

