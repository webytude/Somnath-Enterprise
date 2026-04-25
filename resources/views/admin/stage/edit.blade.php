@section('title','Edit Stage')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Edit Stage</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-8">
                <div class="card card-flush h-lg-100" id="kt_stage_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_stage_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('stages.update', $stage->id) }}">
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
                                            <option value="{{ $location->id }}" {{ old('location_id', $stage->location_id) == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('location_id')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Work Name</span>
                                    </label>
                                    <select class="form-select form-select-solid" name="work_id" id="work_id" data-control="select2" data-placeholder="Select Work...">
                                        <option value="">Select Work...</option>
                                        @if($currentWork)
                                            <option value="{{ $currentWork->id }}" selected>{{ $currentWork->name_of_work }}</option>
                                        @endif
                                    </select>
                                    @error('work_id')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <h4 class="mb-0">Stages</h4>
                                    <button type="button" class="btn btn-sm btn-light-primary" id="add-stage-row">Add More Stage</button>
                                </div>
                                <div class="text-muted mt-2">First row updates this stage. Additional rows create new stages.</div>
                            </div>

                            <div id="stage-rows">
                                @php
                                    $oldStages = old('stages', [['name' => $stage->name, 'percentage' => $stage->percentage]]);
                                @endphp
                                @foreach($oldStages as $idx => $row)
                                    <div class="row mb-4 stage-row">
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Stage Name</span>
                                            </label>
                                            <input type="text" class="form-control form-control-solid stage-name" name="stages[{{ $idx }}][name]" value="{{ $row['name'] ?? '' }}" placeholder="Enter Stage Name" />
                                        </div>
                                        <div class="col-md-5">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Site Percentage</span>
                                            </label>
                                            <input type="number" class="form-control form-control-solid stage-percentage" name="stages[{{ $idx }}][percentage]" value="{{ $row['percentage'] ?? '' }}" step="0.01" min="0" max="100" placeholder="Enter Percentage (0-100)" />
                                        </div>
                                        <div class="col-md-1 d-flex align-items-end">
                                            <button type="button" class="btn btn-sm btn-light-danger remove-stage-row" {{ $idx === 0 ? 'style=display:none;' : '' }}>&times;</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mb-4">
                                <span class="badge badge-light-info">Total: <span id="total-percentage">0.00</span>%</span>
                                <span class="text-danger ms-2 d-none" id="percentage-error">Total percentage cannot exceed 100.</span>
                            </div>
                            @error('stages')
                                <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                            @enderror
                            @error('stages.*.name')
                                <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                            @enderror
                            @error('stages.*.percentage')
                                <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                            @enderror
                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('stages.index')}}" data-kt-stage-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-stage-form="submit" class="btn btn-primary">
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
        var currentWorkId = {{ $stage->work_id ?? 'null' }};
        var currentLocationId = {{ $stage->location_id ?? 'null' }};
        let stageIndex = {{ count(old('stages', [['name' => $stage->name, 'percentage' => $stage->percentage]])) }};

        function recalculateTotal() {
            let total = 0;
            $('.stage-percentage').each(function() {
                total += parseFloat($(this).val()) || 0;
            });
            $('#total-percentage').text(total.toFixed(2));
            if (total > 100) {
                $('#percentage-error').removeClass('d-none');
            } else {
                $('#percentage-error').addClass('d-none');
            }
            return total;
        }

        function stageRowTemplate(idx) {
            return `
                <div class="row mb-4 stage-row">
                    <div class="col-md-6">
                        <label class="fs-6 fw-bold form-label mt-3"><span class="required">Stage Name</span></label>
                        <input type="text" class="form-control form-control-solid stage-name" name="stages[${idx}][name]" placeholder="Enter Stage Name" />
                    </div>
                    <div class="col-md-5">
                        <label class="fs-6 fw-bold form-label mt-3"><span class="required">Site Percentage</span></label>
                        <input type="number" class="form-control form-control-solid stage-percentage" name="stages[${idx}][percentage]" step="0.01" min="0" max="100" placeholder="Enter Percentage (0-100)" />
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-light-danger remove-stage-row">&times;</button>
                    </div>
                </div>
            `;
        }

        // Function to load works for a location
        function loadWorksByLocation(locationId, selectedWorkId = null) {
            var workSelect = $('#work_id');

            // Clear work options
            workSelect.empty();
            workSelect.append('<option value="">Select Work...</option>');

            if (locationId) {
                $.ajax({
                    url: '{{ route("site-progress.getWorksByLocation") }}',
                    type: 'GET',
                    data: { location_id: locationId },
                    success: function(data) {
                        if (data && data.length > 0) {
                            $.each(data, function(key, work) {
                                var selected = (selectedWorkId && work.id == selectedWorkId) ? ' selected' : '';
                                workSelect.append('<option value="' + work.id + '"' + selected + '>' + work.name_of_work + '</option>');
                            });

                            // Auto-select if only one work and no work is currently selected
                            if (data.length === 1 && !selectedWorkId) {
                                workSelect.val(data[0].id).trigger('change');
                            }

                            // Trigger select2 update
                            workSelect.trigger('change');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching works:', error);
                    }
                });
            }
        }

        // Load works for current location on page load
        if (currentLocationId) {
            loadWorksByLocation(currentLocationId, currentWorkId);
        }

        // Handle location change - auto-populate work
        $('#location_id').on('change', function() {
            var locationId = $(this).val();
            loadWorksByLocation(locationId);
        });

        $(document).on('input', '.stage-percentage', function() {
            recalculateTotal();
        });

        $('#add-stage-row').on('click', function() {
            $('#stage-rows').append(stageRowTemplate(stageIndex++));
        });

        $(document).on('click', '.remove-stage-row', function() {
            $(this).closest('.stage-row').remove();
            recalculateTotal();
            if ($('.stage-row').length === 1) {
                $('.remove-stage-row').hide();
            } else {
                $('.remove-stage-row').show();
            }
        });

        $('#kt_stage_form').on('submit', function(e) {
            const total = recalculateTotal();
            if (total > 100) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Total site percentage cannot exceed 100.',
                });
            }
        });

        recalculateTotal();
        if ($('.stage-row').length === 1) {
            $('.remove-stage-row').hide();
        }
    });
</script>
@endsection
