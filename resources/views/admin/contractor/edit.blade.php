@section('title','Edit Contractor/Vendor')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Edit Contractor/Vendor</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-10">
                <div class="card card-flush h-lg-100" id="kt_contractor_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_contractor_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('contractors.update', $contractor->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Name</label>
                                <input type="text" class="form-control form-control-solid" name="pedhi" value="{{ old('pedhi', $contractor->pedhi) }}" placeholder="Enter Name" />
                                @error('pedhi')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">GST</label>
                                    <input type="text" class="form-control form-control-solid" name="gst" value="{{ old('gst', $contractor->gst) }}" placeholder="Enter GST Number" />
                                    @error('gst')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">PAN</label>
                                    <input type="text" class="form-control form-control-solid" name="pan" value="{{ old('pan', $contractor->pan) }}" placeholder="Enter PAN Number" />
                                    @error('pan')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label mt-3">Bank Name</label>
                                    <input type="text" class="form-control form-control-solid" name="bank_name" value="{{ old('bank_name', $contractor->bank_name) }}" placeholder="Enter Bank Name" />
                                    @error('bank_name')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label mt-3">IFSC</label>
                                    <input type="text" class="form-control form-control-solid" name="ifsc" value="{{ old('ifsc', $contractor->ifsc) }}" placeholder="Enter IFSC Code" />
                                    @error('ifsc')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label mt-3">Branch Name</label>
                                    <input type="text" class="form-control form-control-solid" name="branch_name" value="{{ old('branch_name', $contractor->branch_name) }}" placeholder="Enter Branch Name" />
                                    @error('branch_name')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label mt-3">Bank A/c. No</label>
                                    <input type="text" class="form-control form-control-solid" name="bank_account_no" value="{{ old('bank_account_no', $contractor->bank_account_no) }}" placeholder="Enter Bank A/c. No" />
                                    @error('bank_account_no')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Address</label>
                                <textarea class="form-control form-control-solid" name="address" rows="3" placeholder="Enter Address">{{ old('address', $contractor->address) }}</textarea>
                                @error('address')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Mobile</label>
                                    <input type="text" class="form-control form-control-solid" name="mobile" value="{{ old('mobile', $contractor->mobile) }}" placeholder="Enter Mobile Number" />
                                    @error('mobile')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Contact Person</label>
                                    <input type="text" class="form-control form-control-solid" name="contact_person" value="{{ old('contact_person', $contractor->contact_person) }}" placeholder="Enter Contact Person Name" />
                                    @error('contact_person')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Contact Person Mobile</label>
                                    <input type="text" class="form-control form-control-solid" name="contact_person_mobile" value="{{ old('contact_person_mobile', $contractor->contact_person_mobile) }}" placeholder="Enter Contact Person Mobile" />
                                    @error('contact_person_mobile')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Ref By</label>
                                    <input type="text" class="form-control form-control-solid" name="ref_by" value="{{ old('ref_by', $contractor->ref_by) }}" placeholder="Enter Reference By" />
                                    @error('ref_by')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Ref. Cont. No.</label>
                                    <input type="text" class="form-control form-control-solid" name="ref_cont_no" value="{{ old('ref_cont_no', $contractor->ref_cont_no) }}" placeholder="Enter Ref. Cont. No." />
                                    @error('ref_cont_no')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
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
                                                $selectedLocationIds = $contractor->locations->pluck('id')->toArray();
                                            @endphp
                                            @foreach($locations as $location)
                                            <div class="col-md-4 mb-3">
                                                <div class="form-check form-check-custom form-check-solid">
                                                    <input class="form-check-input location-checkbox" type="checkbox" name="location_ids[]" value="{{ $location->id }}" id="location_{{ $location->id }}" data-location-id="{{ $location->id }}" {{ in_array($location->id, old('location_ids', $selectedLocationIds)) ? 'checked' : '' }} />
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

                            <!-- List of Works -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-5">
                                <h3 class="mb-3">List of Works</h3>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-12">
                                    <label class="fs-6 fw-bold form-label mt-3 mb-3">Works</label>
                                    <div id="works-container" class="border rounded p-4" style="min-height: 100px; max-height: 300px; overflow-y: auto;">
                                        @php
                                            $selectedWorkIds = $contractor->works->pluck('id')->toArray();
                                        @endphp
                                        @if($selectedLocationIds)
                                            @php
                                                $worksByLocation = \App\Models\Work::whereIn('location_id', $selectedLocationIds)
                                                    ->orderBy('location_id')
                                                    ->orderBy('name_of_work')
                                                    ->get()
                                                    ->groupBy('location_id');
                                            @endphp
                                            @if($worksByLocation->count() > 0)
                                                @foreach($worksByLocation as $locationId => $works)
                                                    @php
                                                        $location = $locations->firstWhere('id', $locationId);
                                                    @endphp
                                                    <div class="row mb-3" data-location-id="{{ $locationId }}">
                                                        <div class="col-12"><strong>{{ $location ? $location->name : 'Unknown Location' }}</strong></div>
                                                        @foreach($works as $work)
                                                            <div class="col-md-4 mb-2">
                                                                <div class="form-check form-check-custom form-check-solid">
                                                                    <input class="form-check-input work-checkbox" type="checkbox" name="work_ids[]" value="{{ $work->id }}" id="work_{{ $work->id }}" {{ in_array($work->id, old('work_ids', $selectedWorkIds)) ? 'checked' : '' }} />
                                                                    <label class="form-check-label" for="work_{{ $work->id }}">
                                                                        {{ $work->name_of_work }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-muted">No works found for selected locations</p>
                                            @endif
                                        @else
                                            <p class="text-muted">Select locations to view works</p>
                                        @endif
                                    </div>
                                    @error('work_ids')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('contractors.index')}}" data-kt-contractor-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-contractor-form="submit" class="btn btn-primary">
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
        var selectedWorkIds = @json($contractor->works->pluck('id')->toArray());
        var selectedLocationIds = [];
        
        // Initialize selectedLocationIds from checked checkboxes
        $('.location-checkbox:checked').each(function() {
            var locationId = $(this).data('location-id');
            if (!selectedLocationIds.includes(locationId)) {
                selectedLocationIds.push(locationId);
            }
        });
        
        // Function to load works
        function loadWorks() {
            var worksContainer = $('#works-container');
            
            if (selectedLocationIds.length > 0) {
                $.ajax({
                    url: '{{ route("contractors.getWorksByLocations") }}',
                    method: 'GET',
                    data: { location_ids: selectedLocationIds },
                    success: function(response) {
                        // Clear existing works
                        worksContainer.empty();
                        
                        // Group works by location
                        var worksByLocation = {};
                        response.forEach(function(work) {
                            if (!worksByLocation[work.location_id]) {
                                worksByLocation[work.location_id] = [];
                            }
                            worksByLocation[work.location_id].push(work);
                        });
                        
                        // Display works grouped by location
                        Object.keys(worksByLocation).forEach(function(locationId) {
                            var locationWorks = worksByLocation[locationId];
                            var locationName = $('.location-checkbox[data-location-id="' + locationId + '"]').closest('.form-check').find('label').text();
                            
                            var worksHtml = '<div class="row mb-3" data-location-id="' + locationId + '">';
                            locationWorks.forEach(function(work) {
                                var isChecked = selectedWorkIds.includes(work.id) ? 'checked' : '';
                                worksHtml += '<div class="col-md-4 mb-2">';
                                worksHtml += '<div class="form-check form-check-custom form-check-solid">';
                                worksHtml += '<input class="form-check-input work-checkbox" type="checkbox" name="work_ids[]" value="' + work.id + '" id="work_' + work.id + '" ' + isChecked + ' />';
                                worksHtml += '<label class="form-check-label" for="work_' + work.id + '">' + work.name_of_work + '</label>';
                                worksHtml += '</div></div>';
                            });
                            worksHtml += '</div>';
                            worksContainer.append(worksHtml);
                        });
                        
                        if (worksContainer.find('.row[data-location-id]').length === 0) {
                            worksContainer.html('<p class="text-muted">No works found for selected locations</p>');
                        }
                    },
                    error: function() {
                        worksContainer.html('<p class="text-danger">Error loading works</p>');
                    }
                });
            } else {
                worksContainer.html('<p class="text-muted">Select locations to view works</p>');
            }
        }
        
        // Handle location checkbox change
        $('.location-checkbox').on('change', function() {
            var locationId = $(this).data('location-id');
            var worksContainer = $('#works-container');
            
            if ($(this).is(':checked')) {
                if (!selectedLocationIds.includes(locationId)) {
                    selectedLocationIds.push(locationId);
                }
            } else {
                selectedLocationIds = selectedLocationIds.filter(id => id !== locationId);
                // Remove works for this location
                worksContainer.find('div[data-location-id="' + locationId + '"]').remove();
            }
            
            // Load works for selected locations
            loadWorks();
        });
        
        // Load works on page load if locations are already selected
        if (selectedLocationIds.length > 0) {
            loadWorks();
        }
    });
</script>
@endsection
