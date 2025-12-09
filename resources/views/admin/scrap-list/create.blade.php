@section('title','Add Scrap List')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Add Scrap List</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-8">
                <div class="card card-flush h-lg-100" id="kt_scrap_list_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_scrap_list_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('scrap-lists.store') }}">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            Feriya
                                        </label>
                                        <input type="text" class="form-control form-control-solid" name="feriya" value="{{ old('feriya') }}" placeholder="Enter Feriya" />
                                        @error('feriya')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Date</span>
                                        </label>
                                        <input type="date" class="form-control form-control-solid" name="date" value="{{ old('date') }}" />
                                        @error('date')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            Material
                                        </label>
                                        <select class="form-select form-select-solid" name="material_id" data-control="select2" data-placeholder="Select Material">
                                            <option value="">Select Material</option>
                                            @foreach($scrapMaterials as $material)
                                                <option value="{{ $material->id }}" {{ old('material_id') == $material->id ? 'selected' : '' }}>{{ $material->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('material_id')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            Unit
                                        </label>
                                        <input type="text" class="form-control form-control-solid" name="unit" value="{{ old('unit') }}" placeholder="Enter Unit" />
                                        @error('unit')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Quantity</span>
                                        </label>
                                        <input type="number" class="form-control form-control-solid" name="quantity" value="{{ old('quantity', 0) }}" step="0.01" min="0" placeholder="Enter Quantity" />
                                        @error('quantity')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            Where Place
                                        </label>
                                        <input type="text" class="form-control form-control-solid" name="where_place" value="{{ old('where_place') }}" placeholder="Enter Where Place" />
                                        @error('where_place')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            Labour of Scrape
                                        </label>
                                        <input type="text" class="form-control form-control-solid" name="labour_of_scrape" value="{{ old('labour_of_scrape') }}" placeholder="Enter Labour of Scrape" />
                                        @error('labour_of_scrape')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    Remark
                                </label>
                                <textarea class="form-control form-control-solid" name="remark" rows="3" placeholder="Enter Remark">{{ old('remark') }}</textarea>
                                @error('remark')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('scrap-lists.index')}}" data-kt-scrap-list-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-scrap-list-form="submit" class="btn btn-primary">
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

