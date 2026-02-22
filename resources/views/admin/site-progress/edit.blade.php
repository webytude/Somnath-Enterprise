@section('title','Edit Site Progress')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Edit Site Progress</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-12">
                <div class="card card-flush h-lg-100" id="kt_site_progress_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_site_progress_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('site-progress.update', $siteProgress->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <!-- EDIT SITE PROGRESS Section -->
                            <div class="mb-7">
                                <h3 class="text-success mb-4">EDIT SITE PROGRESS</h3>
                                <div class="row mb-7">
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Location</span>
                                        </label>
                                        <select class="form-select form-select-solid" name="location_id" id="location_id" data-control="select2" data-placeholder="Select Location..." required>
                                            <option value="">Select Location...</option>
                                            @foreach($locations as $location)
                                                <option value="{{ $location->id }}" {{ old('location_id', $siteProgress->location_id) == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('location_id')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
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
                            </div>

                            <!-- DETAILS OF WORK STAGE Section -->
                            <div class="mb-7">
                                <h3 class="text-success mb-4">DETAILS OF WORK STAGE</h3>
                                <div class="row mb-7">
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">Work Stage</label>
                                        <select class="form-select form-select-solid" name="stage_id" id="stage_id" data-control="select2" data-placeholder="Select Work Stage...">
                                            <option value="">Select Work Stage...</option>
                                            @foreach($stages as $stage)
                                                <option value="{{ $stage->id }}" data-percentage="{{ $stage->percentage }}" {{ old('stage_id', $siteProgress->stage_id) == $stage->id ? 'selected' : '' }}>{{ $stage->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('stage_id')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">Stage %</label>
                                        <input type="number" class="form-control form-control-solid" name="stage_percentage" id="stage_percentage" value="{{ old('stage_percentage', $siteProgress->stage_percentage) }}" step="0.01" min="0" max="100" placeholder="Stage Percentage" readonly />
                                        @error('stage_percentage')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Fields -->
                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Photo URL</label>
                                    @if($siteProgress->photo_url)
                                        <div class="mb-2">
                                            <a href="{{ $siteProgress->photo_url }}" target="_blank" class="btn btn-sm btn-light-primary">
                                                <i class="fas fa-image"></i> View Current Photo
                                            </a>
                                        </div>
                                    @endif
                                    <input type="url" class="form-control form-control-solid" name="photo_url" value="{{ old('photo_url', $siteProgress->photo_url) }}" placeholder="Enter Photo URL (optional)" />
                                    @error('photo_url')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Date</span>
                                    </label>
                                    <input type="date" class="form-control form-control-solid" name="date" value="{{ old('date', $siteProgress->date ? $siteProgress->date->format('Y-m-d') : '') }}" />
                                    @error('date')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-8">
                                    <label class="fs-6 fw-bold form-label mt-3">Remarks</label>
                                    <textarea class="form-control form-control-solid" name="remark" rows="3" placeholder="Enter Remark">{{ old('remark', $siteProgress->remark) }}</textarea>
                                    @error('remark')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Hidden fields for backward compatibility -->
                            <input type="hidden" name="work_name" id="work_name" value="{{ old('work_name', $siteProgress->work_name) }}" />
                            <input type="hidden" name="work_site" id="work_site" value="{{ old('work_site', $siteProgress->work_site) }}" />
                            <input type="hidden" name="work_stage" id="work_stage" value="{{ old('work_stage', $siteProgress->work_stage) }}" />

                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('site-progress.index')}}" data-kt-site-progress-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-site-progress-form="submit" class="btn btn-primary">
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
        var currentWorkId = {{ $siteProgress->work_id ?? 'null' }};
        var currentLocationId = {{ $siteProgress->location_id ?? 'null' }};
        var currentStageId = {{ $siteProgress->stage_id ?? 'null' }};

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

        // Handle work selection - update hidden work_name field
        $('#work_id').on('change', function() {
            var selectedText = $(this).find('option:selected').text();
            $('#work_name').val(selectedText);
            $('#work_site').val(selectedText); // Set work_site same as work_name for backward compatibility
        });

        // Handle stage selection - auto-fill stage percentage
        $('#stage_id').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var percentage = selectedOption.data('percentage') || '';
            var stageName = selectedOption.text();
            
            $('#stage_percentage').val(percentage);
            $('#work_stage').val(stageName); // Set work_stage for backward compatibility
        });

        // Initialize stage percentage if stage is already selected
        if (currentStageId) {
            var selectedStage = $('#stage_id').find('option:selected');
            if (selectedStage.length) {
                var percentage = selectedStage.data('percentage') || '';
                $('#stage_percentage').val(percentage);
            }
        }
    });
</script>
@endsection
