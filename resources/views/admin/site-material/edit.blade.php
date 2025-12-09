@section('title','Edit Site Material')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Edit Site Material</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-8">
                <div class="card card-flush h-lg-100" id="kt_site_material_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_site_material_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('site-materials.update', $siteMaterial->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Location</span>
                                </label>
                                <select class="form-select form-select-solid" name="location_id" id="location_id" data-control="select2" data-placeholder="Select Location...">
                                    <option value="">Select Location...</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}" {{ old('location_id', $siteMaterial->location_id) == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Name</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="name" value="{{ old('name', $siteMaterial->name) }}" placeholder="Enter Material Name" />
                                @error('name')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Photo</label>
                                @if($siteMaterial->photo)
                                    <div class="mb-2">
                                        <img src="{{ $siteMaterial->photo }}" alt="{{ $siteMaterial->name }}" class="w-150px h-150px rounded" style="object-fit: cover;">
                                    </div>
                                @endif
                                <input type="file" class="form-control form-control-solid" name="photo" accept="image/*" />
                                @error('photo')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Quantity</span>
                                </label>
                                <input type="number" class="form-control form-control-solid" name="quantity" value="{{ old('quantity', $siteMaterial->quantity) }}" step="0.01" min="0" placeholder="Enter Quantity" />
                                @error('quantity')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="fv-row mb-7">
                                <div class="form-check form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" name="is_inward" value="1" id="is_inward" {{ old('is_inward', $siteMaterial->is_inward) ? 'checked' : '' }} />
                                    <label class="form-check-label" for="is_inward">
                                        Is Inward
                                    </label>
                                </div>
                                @error('is_inward')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Remark</label>
                                <textarea class="form-control form-control-solid" name="remark" rows="3" placeholder="Enter Remark">{{ old('remark', $siteMaterial->remark) }}</textarea>
                                @error('remark')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('site-materials.index')}}" data-kt-site-material-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-site-material-form="submit" class="btn btn-primary">
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

