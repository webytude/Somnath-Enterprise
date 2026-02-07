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
                                        <span class="required">First Name</span>
                                    </label>
                                    <input type="text" class="form-control form-control-solid" name="first_name" value="{{ old('first_name', $staff->first_name) }}" placeholder="Enter First Name" />
                                    @error('first_name')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Father Name</label>
                                    <input type="text" class="form-control form-control-solid" name="second_name" value="{{ old('second_name', $staff->second_name) }}" placeholder="Enter Father Name" />
                                    @error('second_name')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Surname</span>
                                    </label>
                                    <input type="text" class="form-control form-control-solid" name="last_name" value="{{ old('last_name', $staff->last_name) }}" placeholder="Enter Last Name" />
                                    @error('last_name')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                               
                            </div>

                            <div class="row mb-7">
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
                                            <img src="{{ $staff->photo }}" alt="{{ $staff->full_name }}" class="w-100px h-100px rounded" style="object-fit: cover;">
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
                                    <label class="fs-6 fw-bold form-label mt-3">Other Contact Number</label>
                                    <input type="text" class="form-control form-control-solid" name="other_contact_number" value="{{ old('other_contact_number', $staff->other_contact_number) }}" placeholder="Enter Other Contact Number" />
                                    @error('other_contact_number')
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
                                    <label class="fs-6 fw-bold form-label mt-3">Relative Name</label>
                                    <input type="text" class="form-control form-control-solid" name="relative_name" value="{{ old('relative_name', $staff->relative_name) }}" placeholder="Enter Relative Name" />
                                    @error('relative_name')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Relation</label>
                                    <select class="form-select form-select-solid" name="relation" data-control="select2" data-placeholder="Select Relation...">
                                        <option value="">Select Relation...</option>
                                        <option value="Father" {{ old('relation', $staff->relation) == 'Father' ? 'selected' : '' }}>Father</option>
                                        <option value="Mother" {{ old('relation', $staff->relation) == 'Mother' ? 'selected' : '' }}>Mother</option>
                                        <option value="Brother" {{ old('relation', $staff->relation) == 'Brother' ? 'selected' : '' }}>Brother</option>
                                        <option value="Sister" {{ old('relation', $staff->relation) == 'Sister' ? 'selected' : '' }}>Sister</option>
                                        <option value="Spouse" {{ old('relation', $staff->relation) == 'Spouse' ? 'selected' : '' }}>Spouse</option>
                                        <option value="Son" {{ old('relation', $staff->relation) == 'Son' ? 'selected' : '' }}>Son</option>
                                        <option value="Daughter" {{ old('relation', $staff->relation) == 'Daughter' ? 'selected' : '' }}>Daughter</option>
                                        <option value="Husband" {{ old('relation', $staff->relation) == 'Husband' ? 'selected' : '' }}>Husband</option>
                                        <option value="Wife" {{ old('relation', $staff->relation) == 'Wife' ? 'selected' : '' }}>Wife</option>
                                        <option value="Uncle" {{ old('relation', $staff->relation) == 'Uncle' ? 'selected' : '' }}>Uncle</option>
                                        <option value="Aunt" {{ old('relation', $staff->relation) == 'Aunt' ? 'selected' : '' }}>Aunt</option>
                                        <option value="Grandfather" {{ old('relation', $staff->relation) == 'Grandfather' ? 'selected' : '' }}>Grandfather</option>
                                        <option value="Grandmother" {{ old('relation', $staff->relation) == 'Grandmother' ? 'selected' : '' }}>Grandmother</option>
                                        <option value="Other" {{ old('relation', $staff->relation) == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('relation')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Relative Mobile No.</label>
                                    <input type="text" class="form-control form-control-solid" name="relative_mobile_no" value="{{ old('relative_mobile_no', $staff->relative_mobile_no) }}" placeholder="Enter Relative Mobile Number" />
                                    @error('relative_mobile_no')
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
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Bank Name</label>
                                    <input type="text" class="form-control form-control-solid" name="bank_name" value="{{ old('bank_name', $staff->bank_name) }}" placeholder="Enter Bank Name" />
                                    @error('bank_name')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Bank Account No.</label>
                                    <input type="text" class="form-control form-control-solid" name="bank_account_no" value="{{ old('bank_account_no', $staff->bank_account_no) }}" placeholder="Enter Bank Account Number" />
                                    @error('bank_account_no')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">IFSC Code</label>
                                    <input type="text" class="form-control form-control-solid" name="ifsc_code" value="{{ old('ifsc_code', $staff->ifsc_code) }}" placeholder="Enter IFSC Code" />
                                    @error('ifsc_code')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Details of Salary -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-5">
                                <h3 class="mb-3">Details of Salary</h3>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Rate/Day</label>
                                    <input type="number" step="0.01" class="form-control form-control-solid" name="rate_per_day" value="{{ old('rate_per_day', $staff->rate_per_day) }}" placeholder="Enter Rate Per Day" />
                                    @error('rate_per_day')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Rate/Month</label>
                                    <input type="number" step="0.01" class="form-control form-control-solid" name="rate_per_month" value="{{ old('rate_per_month', $staff->rate_per_month) }}" placeholder="Enter Rate Per Month" />
                                    @error('rate_per_month')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Date</label>
                                    <input type="date" class="form-control form-control-solid" name="salary_date" value="{{ old('salary_date', $staff->salary_date ? $staff->salary_date->format('Y-m-d') : '') }}" />
                                    @error('salary_date')
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

