@section('title','Edit Contractor/Vendor')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Edit Contractor/Vendor</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-10">
                <div class="card card-flush h-lg-100" id="kt_contractor_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_contractor_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('contractors.update', $contractor->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Pedhi</label>
                                <input type="text" class="form-control form-control-solid" name="pedhi" value="{{ old('pedhi', $contractor->pedhi) }}" placeholder="Enter Pedhi" />
                                @error('pedhi')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">GST</label>
                                    <input type="text" class="form-control form-control-solid" name="gst" value="{{ old('gst', $contractor->gst) }}" placeholder="Enter GST Number" />
                                    @error('gst')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">PAN</label>
                                    <input type="text" class="form-control form-control-solid" name="pan" value="{{ old('pan', $contractor->pan) }}" placeholder="Enter PAN Number" />
                                    @error('pan')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Bank Name</label>
                                    <input type="text" class="form-control form-control-solid" name="bank_name" value="{{ old('bank_name', $contractor->bank_name) }}" placeholder="Enter Bank Name" />
                                    @error('bank_name')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">IFSC</label>
                                    <input type="text" class="form-control form-control-solid" name="ifsc" value="{{ old('ifsc', $contractor->ifsc) }}" placeholder="Enter IFSC Code" />
                                    @error('ifsc')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Branch Name</label>
                                    <input type="text" class="form-control form-control-solid" name="branch_name" value="{{ old('branch_name', $contractor->branch_name) }}" placeholder="Enter Branch Name" />
                                    @error('branch_name')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Address</label>
                                <textarea class="form-control form-control-solid" name="address" rows="3" placeholder="Enter Address">{{ old('address', $contractor->address) }}</textarea>
                                @error('address')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Mobile</label>
                                    <input type="text" class="form-control form-control-solid" name="mobile" value="{{ old('mobile', $contractor->mobile) }}" placeholder="Enter Mobile Number" />
                                    @error('mobile')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Contact Person</label>
                                    <input type="text" class="form-control form-control-solid" name="contact_person" value="{{ old('contact_person', $contractor->contact_person) }}" placeholder="Enter Contact Person Name" />
                                    @error('contact_person')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Contact Person Mobile</label>
                                    <input type="text" class="form-control form-control-solid" name="contact_person_mobile" value="{{ old('contact_person_mobile', $contractor->contact_person_mobile) }}" placeholder="Enter Contact Person Mobile" />
                                    @error('contact_person_mobile')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Ref By</label>
                                    <input type="text" class="form-control form-control-solid" name="ref_by" value="{{ old('ref_by', $contractor->ref_by) }}" placeholder="Enter Reference By" />
                                    @error('ref_by')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Payment Term</label>
                                    <input type="text" class="form-control form-control-solid" name="payment_term" value="{{ old('payment_term', $contractor->payment_term) }}" placeholder="Enter Payment Term" />
                                    @error('payment_term')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Amount</label>
                                    <input type="number" class="form-control form-control-solid" name="amount" value="{{ old('amount', $contractor->amount) }}" step="0.01" min="0" placeholder="Enter Amount" />
                                    @error('amount')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Remaining Amount</label>
                                    <input type="number" class="form-control form-control-solid" name="remaining_amount" value="{{ old('remaining_amount', $contractor->remaining_amount) }}" step="0.01" min="0" placeholder="Enter Remaining Amount" />
                                    @error('remaining_amount')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Payment Slab</label>
                                <select class="form-select form-select-solid" name="payment_slab_id" id="payment_slab_id" data-control="select2" data-placeholder="Select Payment Slab...">
                                    <option value="">Select Payment Slab...</option>
                                    @foreach($paymentSlabs as $slab)
                                        <option value="{{ $slab->id }}" {{ old('payment_slab_id', $contractor->payment_slab_id) == $slab->id ? 'selected' : '' }}>{{ $slab->name }}</option>
                                    @endforeach
                                </select>
                                @error('payment_slab_id')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('contractors.index')}}" data-kt-contractor-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-contractor-form="submit" class="btn btn-primary">
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

