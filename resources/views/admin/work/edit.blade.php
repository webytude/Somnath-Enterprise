@section('title','Edit Work')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Edit Work</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-12">
                <div class="card card-flush h-lg-100" id="kt_work_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_work_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('works.update', $work->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <!-- Organization Information -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-5">
                                <h3 class="mb-3">Organization Information</h3>
                            </div>
                            
                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Firm</span>
                                    </label>
                                    <select class="form-select form-select-solid" name="firm_id" id="firm_id" data-control="select2" data-placeholder="Select Firm...">
                                        <option value="">Select Firm...</option>
                                        @foreach($firms as $firm)
                                            <option value="{{ $firm->id }}" {{ old('firm_id', $work->firm_id) == $firm->id ? 'selected' : '' }}>{{ $firm->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('firm_id')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Department</span>
                                    </label>
                                    <select class="form-select form-select-solid" name="department_id" id="department_id" data-control="select2" data-placeholder="Select Department...">
                                        <option value="">Select Department...</option>
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->id }}" {{ old('department_id', $work->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('department_id')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Sub-Department</span>
                                    </label>
                                    <select class="form-select form-select-solid" name="subdepartment_id" id="subdepartment_id" data-control="select2" data-placeholder="Select Sub-Department...">
                                        <option value="">Select Sub-Department...</option>
                                        @foreach($subdepartments as $subdept)
                                            <option value="{{ $subdept->id }}" {{ old('subdepartment_id', $work->subdepartment_id) == $subdept->id ? 'selected' : '' }}>{{ $subdept->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('subdepartment_id')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Division</span>
                                    </label>
                                    <select class="form-select form-select-solid" name="division_id" id="division_id" data-control="select2" data-placeholder="Select Division...">
                                        <option value="">Select Division...</option>
                                        @foreach($divisions as $div)
                                            <option value="{{ $div->id }}" {{ old('division_id', $work->division_id) == $div->id ? 'selected' : '' }}>{{ $div->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('division_id')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Sub-Division</label>
                                    <select class="form-select form-select-solid" name="sub_division_id" id="sub_division_id" data-control="select2" data-placeholder="Select Sub-Division...">
                                        <option value="">Select Sub-Division...</option>
                                        @foreach($subDivisions as $subDiv)
                                            <option value="{{ $subDiv->id }}" {{ old('sub_division_id', $work->sub_division_id) == $subDiv->id ? 'selected' : '' }}>{{ $subDiv->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('sub_division_id')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Location</span>
                                    </label>
                                    <select class="form-select form-select-solid" name="location_id" id="location_id" data-control="select2" data-placeholder="Select Location...">
                                        <option value="">Select Location...</option>
                                        @foreach($locations as $loc)
                                            <option value="{{ $loc->id }}" {{ old('location_id', $work->location_id) == $loc->id ? 'selected' : '' }}>{{ $loc->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('location_id')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Work Information -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-5">
                                <h3 class="mb-3">Work Information</h3>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Name Of Work</span>
                                    </label>
                                    <input type="text" class="form-control form-control-solid" name="name_of_work" value="{{ old('name_of_work', $work->name_of_work) }}" placeholder="Enter Name Of Work" />
                                    @error('name_of_work')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Tender ID</label>
                                    <input type="text" class="form-control form-control-solid" name="tender_id" value="{{ old('tender_id', $work->tender_id) }}" placeholder="Enter Tender ID" />
                                    @error('tender_id')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-12">
                                    <label class="fs-6 fw-bold form-label mt-3">Description of Work</label>
                                    <textarea class="form-control form-control-solid" name="description_of_work" rows="3" placeholder="Enter Description of Work">{{ old('description_of_work', $work->description_of_work) }}</textarea>
                                    @error('description_of_work')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Financial Information -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-5">
                                <h3 class="mb-3">Financial Information</h3>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Estimate Cost</label>
                                    <input type="number" step="0.01" class="form-control form-control-solid" name="estimate_cost" id="estimate_cost" value="{{ old('estimate_cost', $work->estimate_cost) }}" placeholder="Enter Estimate Cost" />
                                    @error('estimate_cost')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Equal(0)/Above(+)/Below(-) on Estimate</label>
                                    <select class="form-select form-select-solid" name="equal_above_below_on_estimate" id="equal_above_below_on_estimate">
                                        <option value="">Select...</option>
                                        <option value="0" {{ old('equal_above_below_on_estimate', $work->equal_above_below_on_estimate) == '0' ? 'selected' : '' }}>Equal (0)</option>
                                        <option value="+" {{ old('equal_above_below_on_estimate', $work->equal_above_below_on_estimate) == '+' ? 'selected' : '' }}>Above (+)</option>
                                        <option value="-" {{ old('equal_above_below_on_estimate', $work->equal_above_below_on_estimate) == '-' ? 'selected' : '' }}>Below (-)</option>
                                    </select>
                                    @error('equal_above_below_on_estimate')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">(A) Final Amt. of Work</label>
                                    <input type="number" step="0.01" class="form-control form-control-solid" name="final_amt_of_work" id="final_amt_of_work" value="{{ old('final_amt_of_work', $work->final_amt_of_work) }}" placeholder="Enter Final Amount" />
                                    @error('final_amt_of_work')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Add 18% GST on (A)</label>
                                    <input type="number" step="0.01" class="form-control form-control-solid" name="add_18_percent_gst" id="add_18_percent_gst" value="{{ old('add_18_percent_gst', $work->add_18_percent_gst) }}" placeholder="Enter 18% GST" />
                                    @error('add_18_percent_gst')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Our Final Work Amt.</label>
                                    <input type="number" step="0.01" class="form-control form-control-solid" name="our_final_work_amt" id="our_final_work_amt" value="{{ old('our_final_work_amt', $work->our_final_work_amt) }}" placeholder="Enter Our Final Work Amount" />
                                    @error('our_final_work_amt')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Time Limit(Y-M)</label>
                                    <input type="text" class="form-control form-control-solid" name="time_limit_years_months" value="{{ old('time_limit_years_months', $work->time_limit_years_months) }}" placeholder="e.g., 2-6 (2 years 6 months)" />
                                    @error('time_limit_years_months')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Work Order Information -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-5">
                                <h3 class="mb-3">Work Order Information</h3>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Work Order No.</label>
                                    <input type="text" class="form-control form-control-solid" name="work_order_no" value="{{ old('work_order_no', $work->work_order_no) }}" placeholder="Enter Work Order No." />
                                    @error('work_order_no')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">W.O. Date</label>
                                    <input type="date" class="form-control form-control-solid" name="wo_date" value="{{ old('wo_date', $work->wo_date ? $work->wo_date->format('Y-m-d') : '') }}" />
                                    @error('wo_date')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Work Start Date</label>
                                    <input type="date" class="form-control form-control-solid" name="work_start_date" value="{{ old('work_start_date', $work->work_start_date ? $work->work_start_date->format('Y-m-d') : '') }}" />
                                    @error('work_start_date')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">End Date Of Work</label>
                                    <input type="date" class="form-control form-control-solid" name="end_date_of_work" value="{{ old('end_date_of_work', $work->end_date_of_work ? $work->end_date_of_work->format('Y-m-d') : '') }}" />
                                    @error('end_date_of_work')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">If Extend Date</label>
                                    <div class="form-check form-switch form-check-custom form-check-solid mt-3">
                                        <input class="form-check-input" type="checkbox" name="if_extend_date" id="if_extend_date" value="1" {{ old('if_extend_date', $work->if_extend_date) ? 'checked' : '' }} />
                                        <label class="form-check-label" for="if_extend_date">Extend Date</label>
                                    </div>
                                    @error('if_extend_date')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Extended Date</label>
                                    <input type="date" class="form-control form-control-solid" name="extended_date" id="extended_date" value="{{ old('extended_date', $work->extended_date ? $work->extended_date->format('Y-m-d') : '') }}" />
                                    @error('extended_date')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('works.index')}}" data-kt-work-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-work-form="submit" class="btn btn-primary">
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
        var currentSubdepartmentId = {{ $work->subdepartment_id }};
        var currentDivisionId = {{ $work->division_id }};
        var currentSubDivisionId = {{ $work->sub_division_id ?? 'null' }};
        var currentLocationId = {{ $work->location_id }};
        
        // When department changes, load subdepartments
        $('#department_id').on('change', function() {
            var departmentId = $(this).val();
            var subdepartmentSelect = $('#subdepartment_id');
            var divisionSelect = $('#division_id');
            var subDivisionSelect = $('#sub_division_id');
            var locationSelect = $('#location_id');
            
            // Clear dependent selects
            subdepartmentSelect.empty().append('<option value="">Select Sub-Department...</option>');
            divisionSelect.empty().append('<option value="">Select Division...</option>');
            subDivisionSelect.empty().append('<option value="">Select Sub-Division...</option>');
            locationSelect.empty().append('<option value="">Select Location...</option>');
            
            if (departmentId) {
                $.ajax({
                    url: '{{ route("works.getSubdepartments") }}',
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
            var locationSelect = $('#location_id');
            
            // Clear dependent selects
            divisionSelect.empty().append('<option value="">Select Division...</option>');
            subDivisionSelect.empty().append('<option value="">Select Sub-Division...</option>');
            locationSelect.empty().append('<option value="">Select Location...</option>');
            
            if (subdepartmentId) {
                $.ajax({
                    url: '{{ route("works.getDivisions") }}',
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
        
        // When division changes, load sub divisions and locations
        $('#division_id').on('change', function() {
            var divisionId = $(this).val();
            var subDivisionSelect = $('#sub_division_id');
            var locationSelect = $('#location_id');
            
            // Clear dependent selects
            subDivisionSelect.empty().append('<option value="">Select Sub-Division...</option>');
            locationSelect.empty().append('<option value="">Select Location...</option>');
            
            if (divisionId) {
                // Load sub divisions
                $.ajax({
                    url: '{{ route("works.getSubDivisions") }}',
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
                    }
                });
                
                // Load locations
                loadLocations();
            }
        });
        
        // When sub division changes, load locations
        $('#sub_division_id').on('change', function() {
            loadLocations();
        });
        
        // When firm changes, load locations
        $('#firm_id').on('change', function() {
            loadLocations();
        });
        
        // Function to load locations based on all filters
        function loadLocations() {
            var firmId = $('#firm_id').val();
            var departmentId = $('#department_id').val();
            var subdepartmentId = $('#subdepartment_id').val();
            var divisionId = $('#division_id').val();
            var subDivisionId = $('#sub_division_id').val();
            var locationSelect = $('#location_id');
            
            if (firmId && departmentId && subdepartmentId && divisionId) {
                $.ajax({
                    url: '{{ route("works.getLocations") }}',
                    type: 'GET',
                    data: {
                        firm_id: firmId,
                        department_id: departmentId,
                        subdepartment_id: subdepartmentId,
                        division_id: divisionId,
                        sub_division_id: subDivisionId
                    },
                    success: function(data) {
                        locationSelect.empty().append('<option value="">Select Location...</option>');
                        $.each(data, function(key, value) {
                            var selected = (value.id == currentLocationId) ? 'selected' : '';
                            locationSelect.append('<option value="' + value.id + '" ' + selected + '>' + value.name + '</option>');
                        });
                    }
                });
            }
        }
        
        // Show/hide extended date based on checkbox
        $('#if_extend_date').on('change', function() {
            if ($(this).is(':checked')) {
                $('#extended_date').closest('.col-md-4').show();
            } else {
                $('#extended_date').closest('.col-md-4').hide();
                $('#extended_date').val('');
            }
        });
        
        // Initialize extended date visibility
        if (!$('#if_extend_date').is(':checked')) {
            $('#extended_date').closest('.col-md-4').hide();
        }
        
        // Trigger initial load of dependent dropdowns if values exist
        if ($('#department_id').val()) {
            $('#department_id').trigger('change');
        }
    });
</script>
@endsection
