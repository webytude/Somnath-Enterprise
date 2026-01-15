@section('title','Add Site Material Requirement')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Add Site Material Requirement</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-8">
                <div class="card card-flush h-lg-100" id="kt_site_material_requirement_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_site_material_requirement_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('site-material-requirements.store') }}">
                            @csrf
                            
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Location</span>
                                </label>
                                <select class="form-select form-select-solid" name="location_id" id="location_id" data-control="select2" data-placeholder="Select Location...">
                                    <option value="">Select Location...</option>
                                    @foreach($locations as $location)
                                        <option value="{{ $location->id }}" {{ old('location_id') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">
                                    <span class="required">Material Details</span>
                                </label>
                                <div id="material-details-container">
                                    <div class="material-detail-row mb-3 p-4 border rounded">
                                        <div class="row g-3">
                                            <div class="col-md-3">
                                                <label class="form-label">Material Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-solid material-name" name="details[0][material_name]" placeholder="Enter Material Name" required />
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Unit <span class="text-danger">*</span></label>
                                                <select class="form-select form-select-solid material-unit" name="details[0][unit]" required>
                                                    <option value="">Select Unit</option>
                                                    <option value="KG">KG</option>
                                                    <option value="Bags">Bags</option>
                                                    <option value="Pieces">Pieces</option>
                                                    <option value="Ton">Ton</option>
                                                    <option value="Quintal">Quintal</option>
                                                    <option value="Meter">Meter</option>
                                                    <option value="Liter">Liter</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Rate <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control form-control-solid material-rate" name="details[0][rate]" step="0.01" min="0" placeholder="Rate" required />
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                                <input type="number" class="form-control form-control-solid material-quantity" name="details[0][quantity]" step="0.01" min="0" placeholder="Quantity" required />
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Date <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control form-control-solid material-date" name="details[0][date]" required />
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
        let detailRowIndex = 1;

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

        $('#add-detail-row').on('click', function() {
            const container = $('#material-details-container');
            const newRow = $(`
                <div class="material-detail-row mb-3 p-4 border rounded">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Material Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-solid material-name" name="details[${detailRowIndex}][material_name]" placeholder="Enter Material Name" required />
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Unit <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid material-unit" name="details[${detailRowIndex}][unit]" required>
                                <option value="">Select Unit</option>
                                <option value="KG">KG</option>
                                <option value="Bags">Bags</option>
                                <option value="Pieces">Pieces</option>
                                <option value="Ton">Ton</option>
                                <option value="Quintal">Quintal</option>
                                <option value="Meter">Meter</option>
                                <option value="Liter">Liter</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Rate <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-solid material-rate" name="details[${detailRowIndex}][rate]" step="0.01" min="0" placeholder="Rate" required />
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-solid material-quantity" name="details[${detailRowIndex}][quantity]" step="0.01" min="0" placeholder="Quantity" required />
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control form-control-solid material-date" name="details[${detailRowIndex}][date]" required />
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
        });

        // Initialize remove buttons visibility on page load
        updateRemoveButtons();
    });
</script>
@endsection
