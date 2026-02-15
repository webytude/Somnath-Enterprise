@section('title','Edit Site Material Requirement')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Edit Site Material Requirement</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-12">
                <div class="card card-flush h-lg-100" id="kt_site_material_requirement_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_site_material_requirement_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('site-material-requirements.update', $siteMaterialRequirement->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Location</span>
                                    </label>
                                    <select class="form-select form-select-solid" name="location_id" id="location_id" data-control="select2" data-placeholder="Select Location...">
                                        <option value="">Select Location...</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}" {{ old('location_id', $siteMaterialRequirement->location_id) == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('location_id')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        Work
                                    </label>
                                    <select class="form-select form-select-solid" name="work_id" id="work_id" data-control="select2" data-placeholder="Select Work...">
                                        <option value="">Select Work...</option>
                                        @foreach($works as $work)
                                            <option value="{{ $work->id }}" {{ old('work_id', $siteMaterialRequirement->work_id) == $work->id ? 'selected' : '' }}>{{ $work->name_of_work }}</option>
                                        @endforeach
                                    </select>
                                    @error('work_id')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Material Details</span>
                                </label>
                                <div id="material-details-container">
                                    @php
                                        $oldDetails = old('details');
                                        $existingDetails = $siteMaterialRequirement->details;
                                        $detailsToShow = $oldDetails ?? $existingDetails;
                                    @endphp
                                    @if($detailsToShow && count($detailsToShow) > 0)
                                        @foreach($detailsToShow as $index => $detail)
                                            @php
                                                $isOld = is_array($detail);
                                                $materialId = $isOld ? ($detail['material_id'] ?? '') : ($detail->material_id ?? '');
                                                $materialCategoryId = $isOld ? ($detail['material_category_id'] ?? '') : ($detail->material ? $detail->material->material_category_id : '');
                                                $unit = $isOld ? ($detail['unit'] ?? '') : $detail->unit;
                                                $quantity = $isOld ? ($detail['quantity'] ?? '') : $detail->quantity;
                                                $date = $isOld ? ($detail['date'] ?? '') : ($detail->date ? $detail->date->format('Y-m-d') : '');
                                                $timeWithinDays = $isOld ? ($detail['time_within_days'] ?? '') : $detail->time_within_days;
                                                $remark = $isOld ? ($detail['remark'] ?? '') : $detail->remark;
                                                
                                                // Get materials for the selected category
                                                $categoryMaterials = $materialCategoryId ? \App\Models\MaterialList::where('material_category_id', $materialCategoryId)->orderBy('name')->get() : collect();
                                            @endphp
                                            <div class="material-detail-row mb-3 p-4 border rounded">
                                                <div class="row g-3">
                                                    <div class="col-md-2">
                                                        <label class="form-label">Material Category <span class="text-danger">*</span></label>
                                                        <select class="form-select form-select-solid material-category" name="details[{{ $index }}][material_category_id]" data-row-index="{{ $index }}" required>
                                                            <option value="">Select Category</option>
                                                            @foreach($materialCategories as $category)
                                                                <option value="{{ $category->id }}" {{ old("details.$index.material_category_id", $materialCategoryId) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Material <span class="text-danger">*</span></label>
                                                        <select class="form-select form-select-solid material-select" name="details[{{ $index }}][material_id]" data-row-index="{{ $index }}" required>
                                                            <option value="">Select Material</option>
                                                            @foreach($categoryMaterials as $material)
                                                                <option value="{{ $material->id }}" data-unit="{{ $material->unit }}" {{ old("details.$index.material_id", $materialId) == $material->id ? 'selected' : '' }}>{{ $material->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Unit <span class="text-danger">*</span></label>
                                                        <select class="form-select form-select-solid material-unit" name="details[{{ $index }}][unit]" data-current-unit="{{ old("details.$index.unit", $unit) }}" required>
                                                            <option value="">Select Unit</option>
                                                            @if($materialCategoryId)
                                                                @php
                                                                    $categoryUnits = \App\Models\MaterialList::where('material_category_id', $materialCategoryId)
                                                                        ->distinct()
                                                                        ->pluck('unit')
                                                                        ->filter()
                                                                        ->sort()
                                                                        ->values();
                                                                @endphp
                                                                @foreach($categoryUnits as $unitOption)
                                                                    <option value="{{ $unitOption }}" {{ old("details.$index.unit", $unit) == $unitOption ? 'selected' : '' }}>{{ $unitOption }}</option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                                        <input type="number" class="form-control form-control-solid material-quantity" name="details[{{ $index }}][quantity]" value="{{ old("details.$index.quantity", $quantity) }}" step="0.01" min="0" placeholder="Quantity" required />
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Date <span class="text-danger">*</span></label>
                                                        <input type="date" class="form-control form-control-solid material-date" name="details[{{ $index }}][date]" value="{{ old("details.$index.date", $date) }}" required />
                                                    </div>
                                                    <div class="col-md-1">
                                                        <label class="form-label">Time Within</label>
                                                        <input type="number" class="form-control form-control-solid material-time-within" name="details[{{ $index }}][time_within_days]" value="{{ old("details.$index.time_within_days", $timeWithinDays) }}" min="0" placeholder="Days" />
                                                    </div>
                                                    <div class="col-md-1 d-flex align-items-end">
                                                        <button type="button" class="btn btn-sm btn-danger remove-detail-row">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                    <div class="col-12">
                                                        <label class="form-label">Remark</label>
                                                        <textarea class="form-control form-control-solid material-remark" name="details[{{ $index }}][remark]" rows="2" placeholder="Enter Remark">{{ old("details.$index.remark", $remark) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="material-detail-row mb-3 p-4 border rounded">
                                            <div class="row g-3">
                                                <div class="col-md-2">
                                                    <label class="form-label">Material Category <span class="text-danger">*</span></label>
                                                    <select class="form-select form-select-solid material-category" name="details[0][material_category_id]" data-row-index="0" required>
                                                        <option value="">Select Category</option>
                                                        @foreach($materialCategories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Material <span class="text-danger">*</span></label>
                                                    <select class="form-select form-select-solid material-select" name="details[0][material_id]" data-row-index="0" required>
                                                        <option value="">Select Material</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Unit <span class="text-danger">*</span></label>
                                                    <select class="form-select form-select-solid material-unit" name="details[0][unit]" required>
                                                        <option value="">Select Unit</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control form-control-solid material-quantity" name="details[0][quantity]" step="0.01" min="0" placeholder="Quantity" required />
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="form-label">Date <span class="text-danger">*</span></label>
                                                    <input type="date" class="form-control form-control-solid material-date" name="details[0][date]" required />
                                                </div>
                                                <div class="col-md-1">
                                                    <label class="form-label">Time Within</label>
                                                    <input type="number" class="form-control form-control-solid material-time-within" name="details[0][time_within_days]" min="0" placeholder="Days" />
                                                </div>
                                                <div class="col-md-1 d-flex align-items-end">
                                                    <button type="button" class="btn btn-sm btn-danger remove-detail-row" style="display: none;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Remark</label>
                                                    <textarea class="form-control form-control-solid material-remark" name="details[0][remark]" rows="2" placeholder="Enter Remark"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" class="btn btn-sm btn-primary" id="add-detail-row">
                                    <i class="fas fa-plus"></i> Add More Material
                                </button>
                                @error('details')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('site-material-requirements.index')}}" data-kt-site-material-requirement-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-site-material-requirement-form="submit" class="btn btn-primary">
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
        let detailRowIndex = {{ old('details') ? count(old('details')) : ($siteMaterialRequirement->details->count() > 0 ? $siteMaterialRequirement->details->count() : 1) }};
        var materialCategories = @json($materialCategories->keyBy('id'));

        function updateRemoveButtons() {
            const rows = $('.material-detail-row');
            rows.each(function() {
                const removeBtn = $(this).find('.remove-detail-row');
                if (rows.length > 1) {
                    removeBtn.show();
                } else {
                    removeBtn.hide();
                }
            });
        }

        // Handle material category change
        $(document).on('change', '.material-category', function() {
            var rowIndex = $(this).data('row-index');
            var categoryId = $(this).val();
            var materialSelect = $(this).closest('.material-detail-row').find('.material-select[data-row-index="' + rowIndex + '"]');
            var unitSelect = $(this).closest('.material-detail-row').find('.material-unit');
            var currentUnit = unitSelect.data('current-unit') || unitSelect.val();
            
            // Clear material and unit
            materialSelect.html('<option value="">Select Material</option>');
            unitSelect.html('<option value="">Select Unit</option>');
            
            if (categoryId) {
                var category = materialCategories[categoryId];
                if (category && category.material_lists) {
                    var uniqueUnits = [];
                    var unitsMap = {};
                    
                    // Populate materials and collect unique units
                    category.material_lists.forEach(function(material) {
                        materialSelect.append('<option value="' + material.id + '" data-unit="' + material.unit + '">' + material.name + '</option>');
                        
                        // Collect unique units
                        if (material.unit && !unitsMap[material.unit]) {
                            unitsMap[material.unit] = true;
                            uniqueUnits.push(material.unit);
                        }
                    });
                    
                    // Populate unit dropdown with unique units from category materials
                    uniqueUnits.sort().forEach(function(unit) {
                        var selected = (currentUnit == unit) ? ' selected' : '';
                        unitSelect.append('<option value="' + unit + '"' + selected + '>' + unit + '</option>');
                    });
                }
            }
        });

        // Handle material select change
        $(document).on('change', '.material-select', function() {
            var rowIndex = $(this).data('row-index');
            var selectedOption = $(this).find('option:selected');
            var unitSelect = $(this).closest('.material-detail-row').find('.material-unit');
            
            if (selectedOption.val()) {
                var materialUnit = selectedOption.data('unit') || '';
                // Auto-select the unit from material, but user can manually change it
                if (materialUnit) {
                    unitSelect.val(materialUnit);
                }
            }
        });

        // Initialize unit dropdowns for existing rows on page load
        $('.material-category').each(function() {
            var categoryId = $(this).val();
            if (categoryId) {
                var rowIndex = $(this).data('row-index');
                var unitSelect = $(this).closest('.material-detail-row').find('.material-unit');
                var currentUnit = unitSelect.data('current-unit') || unitSelect.val();
                var category = materialCategories[categoryId];
                
                if (category && category.material_lists) {
                    var uniqueUnits = [];
                    var unitsMap = {};
                    
                    // Collect unique units from category materials
                    category.material_lists.forEach(function(material) {
                        if (material.unit && !unitsMap[material.unit]) {
                            unitsMap[material.unit] = true;
                            uniqueUnits.push(material.unit);
                        }
                    });
                    
                    // Populate unit dropdown
                    unitSelect.html('<option value="">Select Unit</option>');
                    uniqueUnits.sort().forEach(function(unit) {
                        var selected = (currentUnit == unit) ? ' selected' : '';
                        unitSelect.append('<option value="' + unit + '"' + selected + '>' + unit + '</option>');
                    });
                }
            }
        });

        $('#add-detail-row').on('click', function() {
            const container = $('#material-details-container');
            const newRow = $(`
                <div class="material-detail-row mb-3 p-4 border rounded">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <label class="form-label">Material Category <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid material-category" name="details[${detailRowIndex}][material_category_id]" data-row-index="${detailRowIndex}" required>
                                <option value="">Select Category</option>
                                @foreach($materialCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Material <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid material-select" name="details[${detailRowIndex}][material_id]" data-row-index="${detailRowIndex}" required>
                                <option value="">Select Material</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Unit <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid material-unit" name="details[${detailRowIndex}][unit]" required>
                                <option value="">Select Unit</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-solid material-quantity" name="details[${detailRowIndex}][quantity]" step="0.01" min="0" placeholder="Quantity" required />
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-solid material-date" name="details[${detailRowIndex}][date]" required />
                        </div>
                        <div class="col-md-1">
                            <label class="form-label">Time Within</label>
                            <input type="number" class="form-control form-control-solid material-time-within" name="details[${detailRowIndex}][time_within_days]" min="0" placeholder="Days" />
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-sm btn-danger remove-detail-row">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Remark</label>
                            <textarea class="form-control form-control-solid material-remark" name="details[${detailRowIndex}][remark]" rows="2" placeholder="Enter Remark"></textarea>
                        </div>
                    </div>
                </div>
            `);
            container.append(newRow);
            detailRowIndex++;
            updateRemoveButtons();
        });

        $(document).on('click', '.remove-detail-row', function() {
            $(this).closest('.material-detail-row').remove();
            updateRemoveButtons();
            // Update row numbers after removal
            $('#material-details-container').find('.material-detail-row').each(function(index) {
                $(this).find('h6').text('Material Detail #' + (index + 1));
            });
        });

        // Initialize remove buttons visibility on page load
        updateRemoveButtons();
    });
</script>
@endsection
