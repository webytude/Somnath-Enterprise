@section('title','View Staff')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">View Staff</h1>
        </div>
    </div>
</div>

<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="card">
            <div class="card-body pt-6">
                <div class="d-flex flex-column flex-md-row align-items-md-center mb-8">
                    <div class="me-6 mb-4 mb-md-0">
                        @if($staff->photo)
                            <img src="{{ $staff->photo }}" alt="{{ $staff->full_name }}" class="w-150px h-150px rounded" style="object-fit: cover;">
                        @else
                            <div class="symbol symbol-150px">
                                <div class="symbol-label fs-1 fw-bolder text-success bg-light-success">
                                    {{ strtoupper(substr($staff->first_name ?? 'S', 0, 1)) }}
                                </div>
                            </div>
                        @endif
                    </div>
                    <div>
                        <h2 class="mb-2">{{ $staff->full_name }}</h2>
                        <div class="text-muted mb-2">Code: {{ $staff->code ?? 'N/A' }}</div>
                        <div class="text-muted">Designation: {{ $staff->designation ?? 'N/A' }}</div>
                    </div>
                </div>

                <div class="separator separator-dashed my-5"></div>

                <div class="row mb-7">
                    <div class="col-md-4 mb-5">
                        <label class="fw-bold text-gray-700">Date of Birth</label>
                        <div>{{ $staff->dob ? $staff->dob->format('d/m/Y') : 'N/A' }}</div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <label class="fw-bold text-gray-700">Date of Joining</label>
                        <div>{{ $staff->doj ? $staff->doj->format('d/m/Y') : 'N/A' }}</div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <label class="fw-bold text-gray-700">Mobile Number</label>
                        <div>{{ $staff->mobile_number ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <label class="fw-bold text-gray-700">Other Contact Number</label>
                        <div>{{ $staff->other_contact_number ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <label class="fw-bold text-gray-700">Gender</label>
                        <div>{{ $staff->gender ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <label class="fw-bold text-gray-700">Marital Status</label>
                        <div>{{ $staff->marital_status ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <label class="fw-bold text-gray-700">Blood Group</label>
                        <div>{{ $staff->blood_group ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <label class="fw-bold text-gray-700">Father Name</label>
                        <div>{{ $staff->second_name ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <label class="fw-bold text-gray-700">Relative Name</label>
                        <div>{{ $staff->relative_name ?? 'N/A' }}</div>
                    </div>
                </div>

                <div class="row mb-7">
                    <div class="col-md-6 mb-5">
                        <label class="fw-bold text-gray-700">Permanent Address</label>
                        <div>{{ $staff->permanent_address ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-6 mb-5">
                        <label class="fw-bold text-gray-700">Present Address</label>
                        <div>{{ $staff->present_address ?? 'N/A' }}</div>
                    </div>
                </div>

                <div class="row mb-7">
                    <div class="col-md-4 mb-5">
                        <label class="fw-bold text-gray-700">Aadhar No.</label>
                        <div>{{ $staff->aadhar_no ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <label class="fw-bold text-gray-700">PAN No.</label>
                        <div>{{ $staff->pan_no ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <label class="fw-bold text-gray-700">UAN No.</label>
                        <div>{{ $staff->uan_no ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <label class="fw-bold text-gray-700">ESIC No.</label>
                        <div>{{ $staff->esic_no ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <label class="fw-bold text-gray-700">Bank Name</label>
                        <div>{{ $staff->bank_name ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <label class="fw-bold text-gray-700">Bank Account No.</label>
                        <div>{{ $staff->bank_account_no ?? 'N/A' }}</div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <label class="fw-bold text-gray-700">IFSC Code</label>
                        <div>{{ $staff->ifsc_code ?? 'N/A' }}</div>
                    </div>
                </div>

                <div class="row mb-7">
                    <div class="col-md-4 mb-5">
                        <label class="fw-bold text-gray-700">Rate / Day</label>
                        <div>{{ $staff->rate_per_day !== null ? number_format($staff->rate_per_day, 2) : 'N/A' }}</div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <label class="fw-bold text-gray-700">Rate / Month</label>
                        <div>{{ $staff->rate_per_month !== null ? number_format($staff->rate_per_month, 2) : 'N/A' }}</div>
                    </div>
                    <div class="col-md-4 mb-5">
                        <label class="fw-bold text-gray-700">Salary Date</label>
                        <div>{{ $staff->salary_date ? $staff->salary_date->format('d/m/Y') : 'N/A' }}</div>
                    </div>
                </div>

                <div class="mb-7">
                    <label class="fw-bold text-gray-700">Assigned Locations</label>
                    <div class="mt-2">
                        @forelse($staff->locations as $location)
                            <span class="badge badge-light-primary me-2 mb-2">{{ $location->name }}</span>
                        @empty
                            <span class="text-muted">No locations assigned.</span>
                        @endforelse
                    </div>
                </div>

                <div class="mb-7">
                    <label class="fw-bold text-gray-700">Remark</label>
                    <div>{{ $staff->remark ?? 'N/A' }}</div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('staff.index') }}" class="btn btn-light me-3">Back</a>
                    <a href="{{ route('staff.edit', $staff) }}" class="btn btn-primary">Edit Staff</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
