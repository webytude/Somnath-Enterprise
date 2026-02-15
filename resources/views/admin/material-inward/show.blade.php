@section('title','View Material Inward')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">View Material Inward</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <a href="{{ route('material-inwards.edit', $materialInward) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('material-inwards.index') }}" class="btn btn-sm btn-light">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-12">
                <div class="card card-flush h-lg-100">
                    <div class="card-body pt-5">
                        <!-- Section 1: INWARD MATERIAL -->
                        <div class="mb-7">
                            <h3 class="text-success mb-4">INWARD MATERIAL</h3>
                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label">Location</label>
                                    <p class="form-control-plaintext">{{ $materialInward->location->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label">Name of Work</label>
                                    <p class="form-control-plaintext">{{ $materialInward->work->name_of_work ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label">Party</label>
                                    <p class="form-control-plaintext">{{ $materialInward->party->name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label">Party GST</label>
                                    <p class="form-control-plaintext">{{ $materialInward->party_gst ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label">Party PAN</label>
                                    <p class="form-control-plaintext">{{ $materialInward->party_pan ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: BILL/VOUCHER DETAILS -->
                        <div class="mb-7">
                            <h3 class="text-success mb-4">BILL/VOUCHER DETAILS</h3>
                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label">Bill/Voucher Type</label>
                                    <p class="form-control-plaintext">{{ $materialInward->bill_voucher_type ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label">Bill/Voucher Number</label>
                                    <p class="form-control-plaintext">{{ $materialInward->bill_voucher_number ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label">Bill/Voucher Date</label>
                                    <p class="form-control-plaintext">{{ $materialInward->bill_voucher_date ? $materialInward->bill_voucher_date->format('d-m-Y') : 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label">Material Inward At Site Date</label>
                                    <p class="form-control-plaintext">{{ $materialInward->material_inward_at_site_date ? $materialInward->material_inward_at_site_date->format('d-m-Y') : 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label">Bill/Voucher Attachment</label>
                                    @if($materialInward->bill_voucher_attachment)
                                        <p class="form-control-plaintext">
                                            <a href="{{ $materialInward->bill_voucher_attachment }}" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="fas fa-file"></i> View Attachment
                                            </a>
                                        </p>
                                    @else
                                        <p class="form-control-plaintext">N/A</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: MATERIAL DETAILS -->
                        <div class="mb-7">
                            <h3 class="text-success mb-4">MATERIAL DETAILS</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Material Name</th>
                                            <th>Make</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Rate</th>
                                            <th>Amount</th>
                                            <th>GST %</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($materialInward->details as $index => $detail)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $detail->material->name ?? 'N/A' }}</td>
                                            <td>{{ $detail->make ?? 'N/A' }}</td>
                                            <td>{{ number_format($detail->quantity, 2) }}</td>
                                            <td>{{ $detail->unit ?? 'N/A' }}</td>
                                            <td>₹ {{ number_format($detail->rate, 2) }}</td>
                                            <td>₹ {{ number_format($detail->amount, 2) }}</td>
                                            <td>{{ number_format($detail->gst_percentage, 2) }}%</td>
                                            <td>₹ {{ number_format($detail->sub_total, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Summary -->
                        <div class="row mb-7">
                            <div class="col-md-6"></div>
                            <div class="col-md-6">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">Add Bhadu (B)</label>
                                        <p class="form-control-plaintext">₹ {{ number_format($materialInward->add_bhadu, 2) }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">Total Bill/Voucher Amount (A+B)</label>
                                        <p class="form-control-plaintext fs-4 fw-bold text-primary">₹ {{ number_format($materialInward->total_bill_voucher_amount, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Remarks -->
                        @if($materialInward->remarks)
                        <div class="mb-7">
                            <label class="fs-6 fw-bold form-label">Remarks</label>
                            <p class="form-control-plaintext">{{ $materialInward->remarks }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
