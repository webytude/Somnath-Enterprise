@section('title','View Bill Outward')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">View Bill Outward</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <a href="{{ route('bill-outwards.edit', $billOutward) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('bill-outwards.index') }}" class="btn btn-sm btn-light">
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
                        <!-- Section 1: OUR FIRM -->
                        <div class="mb-7">
                            <h3 class="text-success mb-4">OUR FIRM</h3>
                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label">Firm</label>
                                    <p class="form-control-plaintext">{{ $billOutward->firm->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label">GST</label>
                                    <p class="form-control-plaintext">{{ $billOutward->firm_gst ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: BILL DETAILS -->
                        <div class="mb-7">
                            <h3 class="text-success mb-4">BILL DETAILS</h3>
                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label">Bill No.</label>
                                    <p class="form-control-plaintext">{{ $billOutward->bill_number ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label">Bill Date</label>
                                    <p class="form-control-plaintext">{{ $billOutward->bill_date ? $billOutward->bill_date->format('d-m-Y') : 'N/A' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label">Bill Attachment</label>
                                    @if($billOutward->bill_attachment)
                                        <p class="form-control-plaintext">
                                            <a href="{{ $billOutward->bill_attachment }}" target="_blank" class="btn btn-sm btn-primary">
                                                <i class="fas fa-file"></i> View Attachment
                                            </a>
                                        </p>
                                    @else
                                        <p class="form-control-plaintext">N/A</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: BILL TO PARTY DETAILS -->
                        <div class="mb-7">
                            <h3 class="text-success mb-4">BILL TO PARTY DETAILS</h3>
                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label">Party</label>
                                    <p class="form-control-plaintext">{{ $billOutward->party->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label">Party GST</label>
                                    <p class="form-control-plaintext">{{ $billOutward->party_gst ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label">Party Address</label>
                                    <p class="form-control-plaintext">{{ $billOutward->party_address ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Section 4: MATERIAL/WORK DETAILS -->
                        <div class="mb-7">
                            <h3 class="text-success mb-4">MATERIAL/WORK DETAILS</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Material/Work Name</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Rate</th>
                                            <th>Amount</th>
                                            <th>GST %</th>
                                            <th>Sub Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($billOutward->details as $index => $detail)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                @if($detail->material_id)
                                                    {{ $detail->material->name ?? 'N/A' }}
                                                @elseif($detail->work_id)
                                                    {{ $detail->work->name_of_work ?? 'N/A' }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
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
                                        <label class="fs-6 fw-bold form-label">Add Bhadu/Labour (B)</label>
                                        <p class="form-control-plaintext">₹ {{ number_format($billOutward->add_bhadu_labour, 2) }}</p>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">Total Bill Amount (A+B)</label>
                                        <p class="form-control-plaintext fs-4 fw-bold text-primary">₹ {{ number_format($billOutward->total_bill_amount, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Remarks -->
                        @if($billOutward->remarks)
                        <div class="mb-7">
                            <label class="fs-6 fw-bold form-label">Remarks</label>
                            <p class="form-control-plaintext">{{ $billOutward->remarks }}</p>
                        </div>
                        @endif

                        <!-- Section 5: PAYMENT INFORMATION -->
                        <div class="mb-7">
                            <h3 class="text-success mb-4">PAYMENT INFORMATION</h3>
                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label">Status</label>
                                    <p class="form-control-plaintext">
                                        @if($billOutward->payment_status == 'Received')
                                            <span class="badge badge-success">Received</span>
                                        @else
                                            <span class="badge badge-warning">Pending</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            @if($billOutward->payment_status == 'Received')
                            <div class="row mb-7">
                                <div class="col-12 mb-3">
                                    <label class="fs-6 fw-bold form-label">Deduction Details</label>
                                    <p class="text-muted small">S.D., TDS, GST, L.C., T.C. % of Bill Amt.</p>
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label">S.D. %</label>
                                    <p class="form-control-plaintext">{{ number_format($billOutward->sd_percentage ?? 0, 2) }}%</p>
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label">TDS %</label>
                                    <p class="form-control-plaintext">{{ number_format($billOutward->tds_percentage ?? 0, 2) }}%</p>
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label">GST %</label>
                                    <p class="form-control-plaintext">{{ number_format($billOutward->gst_deduction_percentage ?? 0, 2) }}%</p>
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label">L.C. %</label>
                                    <p class="form-control-plaintext">{{ number_format($billOutward->lc_percentage ?? 0, 2) }}%</p>
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label">T.C. %</label>
                                    <p class="form-control-plaintext">{{ number_format($billOutward->tc_percentage ?? 0, 2) }}%</p>
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label">Total Deduction</label>
                                    <p class="form-control-plaintext">₹ {{ number_format($billOutward->total_deduction, 2) }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label">Net Received Amount</label>
                                    <p class="form-control-plaintext fs-4 fw-bold text-success">₹ {{ number_format($billOutward->net_received_amount, 2) }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label">Ref. No.</label>
                                    <p class="form-control-plaintext">{{ $billOutward->payment_ref_number ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label">Date</label>
                                    <p class="form-control-plaintext">{{ $billOutward->payment_date ? $billOutward->payment_date->format('d-m-Y') : 'N/A' }}</p>
                                </div>
                                @if($billOutward->payment_remarks)
                                <div class="col-md-12">
                                    <label class="fs-6 fw-bold form-label">Remarks</label>
                                    <p class="form-control-plaintext">{{ $billOutward->payment_remarks }}</p>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
