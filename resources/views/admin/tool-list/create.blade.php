@section('title','Add Tool')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Add Tool</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-8">
                <div class="card card-flush h-lg-100" id="kt_tool_list_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_tool_list_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('tool-lists.store') }}">
                            @csrf
                            
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Name</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="name" value="{{ old('name') }}" placeholder="Enter Tool Name" />
                                @error('name')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Quantity</span>
                                    </label>
                                    <input type="number" class="form-control form-control-solid" name="quantity" value="{{ old('quantity', 0) }}" step="0.01" min="0" placeholder="Enter Quantity" />
                                    @error('quantity')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Price</label>
                                    <input type="number" class="form-control form-control-solid" name="price" value="{{ old('price') }}" step="0.01" min="0" placeholder="Enter Price" />
                                    @error('price')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Location</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="location" value="{{ old('location') }}" placeholder="Enter Location" />
                                @error('location')
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
                                <a href="{{route('tool-lists.index')}}" data-kt-tool-list-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-tool-list-form="submit" class="btn btn-primary">
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

