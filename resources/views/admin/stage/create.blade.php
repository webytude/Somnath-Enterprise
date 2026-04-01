@section('title','Add Stage')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Add Stage</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-8">
                <div class="card card-flush h-lg-100" id="kt_stage_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_stage_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('stages.store') }}">
                            @csrf
                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Stage Name</span>
                                    </label>
                                    <input type="text" class="form-control form-control-solid" name="name" value="{{ old('name') }}" placeholder="Enter Stage Name" />
                                    @error('name')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Percentage of Stage</span>
                                    </label>
                                    <input type="number" class="form-control form-control-solid" name="percentage" value="{{ old('percentage') }}" step="0.01" min="0" max="100" placeholder="Enter Percentage (0-100)" />
                                    @error('percentage')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-6">
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
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Work Name</span>
                                    </label>
                                    <select class="form-select form-select-solid" name="work_id" id="work_id" data-control="select2" data-placeholder="Select Work...">
                                        <option value="">Select Work...</option>
                                    </select>
                                    @error('work_id')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('stages.index')}}" data-kt-stage-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-stage-form="submit" class="btn btn-primary">
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
        // Handle location change - auto-populate work
        $('#location_id').on('change', function() {
            var locationId = $(this).val();
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
                                workSelect.append('<option value="' + work.id + '">' + work.name_of_work + '</option>');
                            });

                            // Auto-select if only one work
                            if (data.length === 1) {
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
        });
    });
</script>
@endsection
