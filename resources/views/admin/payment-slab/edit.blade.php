@section('title','Edit Payment Slab')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Edit Payment Slab</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-6">
                <div class="card card-flush h-lg-100" id="kt_payment_slab_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_payment_slab_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('payment-slabs.update', $paymentSlab->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Name</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="name" value="{{ old('name', $paymentSlab->name) }}" placeholder="Enter Payment Slab name" />
                                @error('name')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('payment-slabs.index')}}" data-kt-payment-slab-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-payment-slab-form="submit" class="btn btn-primary">
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

