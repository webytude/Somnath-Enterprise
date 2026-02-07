@section('title','Edit Party')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Edit Party</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-8">
                <div class="card card-flush h-lg-100" id="kt_party_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_party_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('parties.update', $party->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Name</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="name" value="{{ old('name', $party->name) }}" placeholder="Enter Party Name" />
                                @error('name')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Firm</span>
                                </label>
                                <select class="form-select form-select-solid" name="firm_id" id="firm_id" data-control="select2" data-placeholder="Select Firm...">
                                    <option value="">Select Firm...</option>
                                    @foreach($firms as $firm)
                                        <option value="{{ $firm->id }}" {{ old('firm_id', $party->firm_id) == $firm->id ? 'selected' : '' }}>{{ $firm->name }}</option>
                                    @endforeach
                                </select>
                                @error('firm_id')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">GST</label>
                                    <input type="text" class="form-control form-control-solid" name="gst" value="{{ old('gst', $party->gst) }}" placeholder="Enter GST Number" />
                                    @error('gst')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Pancard</label>
                                    <input type="text" class="form-control form-control-solid" name="pancard" value="{{ old('pancard', $party->pancard) }}" placeholder="Enter Pancard Number" />
                                    @error('pancard')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Mobile</label>
                                    <input type="text" class="form-control form-control-solid" name="mobile" value="{{ old('mobile', $party->mobile) }}" placeholder="Enter Mobile Number" />
                                    @error('mobile')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Address</label>
                                <textarea class="form-control form-control-solid" name="address" rows="3" placeholder="Enter Address">{{ old('address', $party->address) }}</textarea>
                                @error('address')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Contact Person Name</label>
                                    <input type="text" class="form-control form-control-solid" name="contact_person_name" value="{{ old('contact_person_name', $party->contact_person_name) }}" placeholder="Enter Contact Person Name" />
                                    @error('contact_person_name')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Contact Person Mobile</label>
                                    <input type="text" class="form-control form-control-solid" name="contact_person_mobile" value="{{ old('contact_person_mobile', $party->contact_person_mobile) }}" placeholder="Enter Contact Person Mobile" />
                                    @error('contact_person_mobile')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Remark</label>
                                <textarea class="form-control form-control-solid" name="remark" rows="3" placeholder="Enter Remark">{{ old('remark', $party->remark) }}</textarea>
                                @error('remark')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Bank Information -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-5">
                                <h3 class="mb-3">Bank Information</h3>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">A/c. Holder Name</label>
                                    <input type="text" class="form-control form-control-solid" name="bank_account_holder_name" value="{{ old('bank_account_holder_name', $party->bank_account_holder_name) }}" placeholder="Enter Account Holder Name" />
                                    @error('bank_account_holder_name')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Bank Name/Branch</label>
                                    <input type="text" class="form-control form-control-solid" name="bank_name_branch" value="{{ old('bank_name_branch', $party->bank_name_branch) }}" placeholder="Enter Bank Name/Branch" />
                                    @error('bank_name_branch')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Bank A/c. No.</label>
                                    <input type="text" class="form-control form-control-solid" name="bank_account_no" value="{{ old('bank_account_no', $party->bank_account_no) }}" placeholder="Enter Bank Account Number" />
                                    @error('bank_account_no')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">IFSC Code</label>
                                    <input type="text" class="form-control form-control-solid" name="ifsc_code" value="{{ old('ifsc_code', $party->ifsc_code) }}" placeholder="Enter IFSC Code" />
                                    @error('ifsc_code')
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
                                        @php
                                            $selectedMaterialIds = $party->materials->pluck('id')->toArray();
                                            $selectedCategoryIds = $party->materials->pluck('material_category_id')->unique()->toArray();
                                        @endphp
                                        @foreach($materialCategories as $category)
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check form-check-custom form-check-solid">
                                                <input class="form-check-input material-category-checkbox" type="checkbox" value="{{ $category->id }}" id="category_{{ $category->id }}" data-category-id="{{ $category->id }}" {{ in_array($category->id, $selectedCategoryIds) ? 'checked' : '' }} />
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
                                        @php
                                            $displayedMaterials = [];
                                        @endphp
                                        @foreach($materialCategories as $category)
                                            @if(in_array($category->id, $selectedCategoryIds))
                                                <div class="row" data-category-id="{{ $category->id }}">
                                                    @foreach($category->materialLists as $material)
                                                        <div class="col-md-4 mb-3">
                                                            <div class="form-check form-check-custom form-check-solid">
                                                                <input class="form-check-input material-checkbox" type="checkbox" name="material_ids[]" value="{{ $material->id }}" id="material_{{ $material->id }}" {{ in_array($material->id, $selectedMaterialIds) ? 'checked' : '' }} />
                                                                <label class="form-check-label" for="material_{{ $material->id }}">
                                                                    {{ $material->name }}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        @endforeach
                                        @if(empty($selectedCategoryIds))
                                            <p class="text-muted">Select material categories to view materials</p>
                                        @endif
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
                                            @php
                                                $selectedLocationIds = $party->locations->pluck('id')->toArray();
                                            @endphp
                                            @foreach($locations as $location)
                                            <div class="col-md-4 mb-3">
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input" type="checkbox" name="location_ids[]" value="{{ $location->id }}" id="location_{{ $location->id }}" {{ in_array($location->id, old('location_ids', $selectedLocationIds)) ? 'checked' : '' }} />
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
                                <a href="{{route('parties.index')}}" data-kt-party-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-party-form="submit" class="btn btn-primary">
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

@section('custom_scripts')
<script>
    $(document).ready(function() {
        var materialCategories = @json($materialCategories->keyBy('id'));
        var selectedMaterialIds = @json($party->materials->pluck('id')->toArray());
        
        // Handle material category checkbox change
        $('.material-category-checkbox').on('change', function() {
            var categoryId = $(this).data('category-id');
            var category = materialCategories[categoryId];
            var materialsContainer = $('#materials-container');
            
            if ($(this).is(':checked')) {
                // Check if materials for this category are already displayed
                if (materialsContainer.find('div[data-category-id="' + categoryId + '"]').length > 0) {
                    return; // Already displayed, don't add again
                }
                
                // Add materials for this category
                if (category && category.material_lists) {
                    var materialsHtml = '';
                    category.material_lists.forEach(function(material) {
                        var isChecked = selectedMaterialIds.includes(material.id) ? 'checked' : '';
                        materialsHtml += '<div class="col-md-4 mb-3">';
                        materialsHtml += '<div class="form-check form-check-custom form-check-solid">';
                        materialsHtml += '<input class="form-check-input material-checkbox" type="checkbox" name="material_ids[]" value="' + material.id + '" id="material_' + material.id + '" ' + isChecked + ' />';
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
