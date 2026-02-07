@section('title','Add Contractor/Vendor')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Add Contractor/Vendor</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-10">
                <div class="card card-flush h-lg-100" id="kt_contractor_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_contractor_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('contractors.store') }}">
                            @csrf
                            
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Name</label>
                                <input type="text" class="form-control form-control-solid" name="pedhi" value="{{ old('pedhi') }}" placeholder="Enter Name" />
                                @error('pedhi')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">GST</label>
                                    <input type="text" class="form-control form-control-solid" name="gst" value="{{ old('gst') }}" placeholder="Enter GST Number" />
                                    @error('gst')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">PAN</label>
                                    <input type="text" class="form-control form-control-solid" name="pan" value="{{ old('pan') }}" placeholder="Enter PAN Number" />
                                    @error('pan')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label mt-3">Bank Name</label>
                                    <input type="text" class="form-control form-control-solid" name="bank_name" value="{{ old('bank_name') }}" placeholder="Enter Bank Name" />
                                    @error('bank_name')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label mt-3">IFSC</label>
                                    <input type="text" class="form-control form-control-solid" name="ifsc" value="{{ old('ifsc') }}" placeholder="Enter IFSC Code" />
                                    @error('ifsc')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label mt-3">Branch Name</label>
                                    <input type="text" class="form-control form-control-solid" name="branch_name" value="{{ old('branch_name') }}" placeholder="Enter Branch Name" />
                                    @error('branch_name')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label mt-3">Bank A/c. No</label>
                                    <input type="text" class="form-control form-control-solid" name="bank_account_no" value="{{ old('bank_account_no') }}" placeholder="Enter Bank A/c. No" />
                                    @error('bank_account_no')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Address</label>
                                <textarea class="form-control form-control-solid" name="address" rows="3" placeholder="Enter Address">{{ old('address') }}</textarea>
                                @error('address')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Mobile</label>
                                    <input type="text" class="form-control form-control-solid" name="mobile" value="{{ old('mobile') }}" placeholder="Enter Mobile Number" />
                                    @error('mobile')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Contact Person</label>
                                    <input type="text" class="form-control form-control-solid" name="contact_person" value="{{ old('contact_person') }}" placeholder="Enter Contact Person Name" />
                                    @error('contact_person')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Contact Person Mobile</label>
                                    <input type="text" class="form-control form-control-solid" name="contact_person_mobile" value="{{ old('contact_person_mobile') }}" placeholder="Enter Contact Person Mobile" />
                                    @error('contact_person_mobile')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Ref By</label>
                                    <input type="text" class="form-control form-control-solid" name="ref_by" value="{{ old('ref_by') }}" placeholder="Enter Reference By" />
                                    @error('ref_by')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Ref. Cont. No.</label>
                                    <input type="text" class="form-control form-control-solid" name="ref_cont_no" value="{{ old('ref_cont_no') }}" placeholder="Enter Ref. Cont. No." />
                                    @error('ref_cont_no')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- List of Materials -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-5">
                                <h3 class="mb-3">List of Materials</h3>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-12">
                                    <label class="fs-6 fw-bold form-label mt-3 mb-3">Material Category</label>
                                    <div class="row">
                                        @foreach($materialCategories as $category)
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input material-category-checkbox" type="checkbox" value="{{ $category->id }}" id="category_{{ $category->id }}" data-category-id="{{ $category->id }}" />
                                                <label class="form-check-label" for="category_{{ $category->id }}">
                                                    {{ $category->name }}
                                                </label>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-12">
                                    <label class="fs-6 fw-bold form-label mt-3 mb-3">Materials</label>
                                    <div id="materials-container" class="border rounded p-4" style="min-height: 100px; max-height: 300px; overflow-y: auto;">
                                        <p class="text-muted">Select material categories to view materials</p>
                                    </div>
                                </div>
                            </div>

                            <!-- List of Locations -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-5">
                                <h3 class="mb-3">List of Locations</h3>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-12">
                                    <label class="fs-6 fw-bold form-label mt-3 mb-3">Locations</label>
                                    <div class="border rounded p-4" style="max-height: 300px; overflow-y: auto;">
                                        <div class="row">
                                            @foreach($locations as $location)
                                            <div class="col-md-4 mb-3">
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="location_ids[]" value="{{ $location->id }}" id="location_{{ $location->id }}" {{ in_array($location->id, old('location_ids', [])) ? 'checked' : '' }} />
                                                    <label class="form-check-label" for="location_{{ $location->id }}">
                                                        {{ $location->name }}
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @error('location_ids')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('contractors.index')}}" data-kt-contractor-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-contractor-form="submit" class="btn btn-primary">
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
        var materialCategories = @json($materialCategories->keyBy('id'));
        
        // Handle material category checkbox change
        $('.material-category-checkbox').on('change', function() {
            var categoryId = $(this).data('category-id');
            var category = materialCategories[categoryId];
            var materialsContainer = $('#materials-container');
            
            if ($(this).is(':checked')) {
                // Add materials for this category
                if (category && category.material_lists) {
                    var materialsHtml = '';
                    category.material_lists.forEach(function(material) {
                        materialsHtml += '<div class="col-md-4 mb-3">';
                        materialsHtml += '<div class="form-check form-check-custom form-check-solid">';
                        materialsHtml += '<input class="form-check-input material-checkbox" type="checkbox" name="material_ids[]" value="' + material.id + '" id="material_' + material.id + '" />';
                        materialsHtml += '<label class="form-check-label" for="material_' + material.id + '">' + material.name + '</label>';
                        materialsHtml += '</div></div>';
                    });
                    
                    if (materialsContainer.find('p.text-muted').length > 0) {
                        materialsContainer.empty();
                    }
                    materialsContainer.append('<div class="row" data-category-id="' + categoryId + '">' + materialsHtml + '</div>');
                }
            } else {
                // Remove materials for this category
                materialsContainer.find('div[data-category-id="' + categoryId + '"]').remove();
                
                // If no materials left, show message
                if (materialsContainer.find('.row[data-category-id]').length === 0) {
                    materialsContainer.html('<p class="text-muted">Select material categories to view materials</p>');
                }
            }
        });
    });
</script>
@endsection
