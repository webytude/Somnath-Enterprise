@section('title','Edit Location')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Edit Location</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            
            <div class="col-xl-6">
                <div class="card card-flush h-lg-100" id="kt_attendance_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_attendance_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('locations.update', $location->id) }}">
                        @csrf
                        @method('PUT')
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Firm Name</label>
                                <select class="form-select form-select-solid" name="firm_id" id="firm_id" data-control="select2" data-placeholder="Select Firm...">
                                    <option value="">Select Firm...</option>
                                    @foreach($firms as $firm)
                                        <option value="{{ $firm->id }}" {{ $firm->id == $location->firm_id ? "selected" : "" }}>{{ $firm->name }}</option>
                                    @endforeach
                                </select>
                                @error('firm_id')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Department</label>
                                <select class="form-select form-select-solid" name="department_id" id="department_id" data-control="select2" data-placeholder="Select Department...">
                                    <option value="">Select Department...</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->id }}" {{ $dept->id == $location->department_id ? "selected" : "" }}>{{ $dept->name }}</option>
                                    @endforeach
                                </select>
                                @error('department_id')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Sub Department</label>
                                <select class="form-select form-select-solid" name="subdepartment_id" id="subdepartment_id" data-control="select2" data-placeholder="Select Sub Department...">
                                    <option value="">Select Sub Department...</option>
                                    @foreach($subdepartments as $subdept)
                                        <option value="{{ $subdept->id }}" {{ $subdept->id == $location->subdepartment_id ? "selected" : "" }}>{{ $subdept->name }}</option>
                                    @endforeach
                                </select>
                                @error('subdepartment_id')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Division</label>
                                <select class="form-select form-select-solid" name="division_id" id="division_id" data-control="select2" data-placeholder="Select Division...">
                                    <option value="">Select Division...</option>
                                    @foreach($divisions as $div)
                                        <option value="{{ $div->id }}" {{ $div->id == $location->division_id ? "selected" : "" }}>{{ $div->name }}</option>
                                    @endforeach
                                </select>
                                @error('division_id')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Sub Division</label>
                                <select class="form-select form-select-solid" name="sub_division_id" id="sub_division_id" data-control="select2" data-placeholder="Select Sub Division...">
                                    <option value="">Select Sub Division...</option>
                                    @foreach($subDivisions as $subDiv)
                                        <option value="{{ $subDiv->id }}" {{ $subDiv->id == $location->sub_division_id ? "selected" : "" }}>{{ $subDiv->name }}</option>
                                    @endforeach
                                </select>
                                @error('sub_division_id')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Name</label>
                                <input type="text" class="form-control form-control-solid" name="name" value="{{ $location->name }}" placeholder="Enter Location name" />
                                @error('name')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Location</label>
                                <textarea class="form-control form-control-solid" name="location" rows="3" placeholder="Enter Location...">{{ $location->location }}</textarea>
                                @error('location')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Remark</label>
                                <textarea class="form-control form-control-solid" name="remark" rows="3" placeholder="Enter Remark...">{{ $location->remark }}</textarea>
                                @error('remark')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('locations.index')}}" data-kt-attendance-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-attendance-form="submit" class="btn btn-primary">
                                    <span class="indicator-label">Save Location</span>
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
        var currentSubdepartmentId = {{ $location->subdepartment_id }};
        var currentDivisionId = {{ $location->division_id }};
        var currentSubDivisionId = {{ $location->sub_division_id ?? 'null' }};
        
        // When department changes, load subdepartments
        $('#department_id').on('change', function() {
            var departmentId = $(this).val();
            var subdepartmentSelect = $('#subdepartment_id');
            var divisionSelect = $('#division_id');
            var subDivisionSelect = $('#sub_division_id');
            
            // Clear subdepartment, division and sub division options
            subdepartmentSelect.empty();
            subdepartmentSelect.append('<option value="">Select Sub Department...</option>');
            divisionSelect.empty();
            divisionSelect.append('<option value="">Select Division...</option>');
            subDivisionSelect.empty();
            subDivisionSelect.append('<option value="">Select Sub Division...</option>');
            
            if (departmentId) {
                $.ajax({
                    url: '{{ route("locations.getSubdepartments") }}',
                    type: 'GET',
                    data: { department_id: departmentId },
                    success: function(data) {
                        $.each(data, function(key, value) {
                            var selected = (value.id == currentSubdepartmentId) ? 'selected' : '';
                            subdepartmentSelect.append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
                        });
                        subdepartmentSelect.trigger('change');
                    }
                });
            }
        });
        
        // When subdepartment changes, load divisions
        $('#subdepartment_id').on('change', function() {
            var subdepartmentId = $(this).val();
            var divisionSelect = $('#division_id');
            var subDivisionSelect = $('#sub_division_id');
            
            // Clear division and sub division options
            divisionSelect.empty();
            divisionSelect.append('<option value="">Select Division...</option>');
            subDivisionSelect.empty();
            subDivisionSelect.append('<option value="">Select Sub Division...</option>');
            
            if (subdepartmentId) {
                $.ajax({
                    url: '{{ route("locations.getDivisions") }}',
                    type: 'GET',
                    data: { subdepartment_id: subdepartmentId },
                    success: function(data) {
                        $.each(data, function(key, value) {
                            var selected = (value.id == currentDivisionId) ? 'selected' : '';
                            divisionSelect.append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
                        });
                        divisionSelect.trigger('change');
                    }
                });
            }
        });
        
        // When division changes, load sub divisions
        $('#division_id').on('change', function() {
            var divisionId = $(this).val();
            var subDivisionSelect = $('#sub_division_id');
            
            // Clear sub division options
            subDivisionSelect.empty();
            subDivisionSelect.append('<option value="">Select Sub Division...</option>');
            
            if (divisionId) {
                $.ajax({
                    url: '{{ route("locations.getSubDivisions") }}',
                    type: 'GET',
                    dataType: 'json',
                    data: { division_id: divisionId },
                    success: function(data) {
                        if (data && data.length > 0) {
                            $.each(data, function(key, value) {
                                var selected = (currentSubDivisionId && value.id == currentSubDivisionId) ? 'selected' : '';
                                subDivisionSelect.append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
                            });
                        }
                        subDivisionSelect.trigger('change');
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', {
                            status: status,
                            error: error,
                            response: xhr.responseText,
                            statusCode: xhr.status
                        });
                    }
                });
            }
        });
    });
</script>
@endsection

