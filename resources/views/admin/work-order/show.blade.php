@extends('admin.layouts.main')
@section('title','View Work Order')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">View Work Order</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <a href="{{ route('work-orders.edit', $workOrder) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('work-orders.index') }}" class="btn btn-sm btn-light">
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
                        <div class="mb-7">
                            <h3 class="text-success mb-4">WORK ORDER</h3>
                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label">W.O. Number</label>
                                    <p class="form-control-plaintext fw-bold fs-5">{{ $workOrder->work_order_number }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label">Date</label>
                                    <p class="form-control-plaintext">{{ $workOrder->order_date ? $workOrder->order_date->format('d-m-Y') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-7">
                            <h3 class="text-success mb-4">VENDOR</h3>
                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label">Vendor Name</label>
                                    <p class="form-control-plaintext">{{ $workOrder->contractor->pedhi ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label">Vendor Address</label>
                                    <p class="form-control-plaintext">{{ $workOrder->contractor->address ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label">Pancard</label>
                                    <p class="form-control-plaintext">{{ $workOrder->contractor->pan ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label">GST</label>
                                    <p class="form-control-plaintext">{{ $workOrder->contractor->gst ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label">Cont. Pers. Name</label>
                                    <p class="form-control-plaintext">{{ $workOrder->contractor->contact_person ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label">Cont. Pers. No.</label>
                                    <p class="form-control-plaintext">{{ $workOrder->contractor->contact_person_mobile ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        @if($workOrder->subject)
                        <div class="mb-7">
                            <h3 class="text-success mb-4">SUBJECT</h3>
                            <p class="form-control-plaintext">{{ $workOrder->subject }}</p>
                        </div>
                        @endif

                        @if($workOrder->condition_text)
                        <div class="mb-7">
                            <h3 class="text-success mb-4">CONDITION</h3>
                            <p class="form-control-plaintext">{{ $workOrder->condition_text }}</p>
                        </div>
                        @endif

                        <div class="mb-7">
                            <h3 class="text-success mb-4">RATE DETAILS</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Sr.</th>
                                            <th>Work Details</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Rate</th>
                                            <th>Amt.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($workOrder->details as $detail)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $detail->work_details }}</td>
                                            <td>{{ number_format($detail->quantity, 4) }}</td>
                                            <td>{{ $detail->unit }}</td>
                                            <td>₹ {{ number_format($detail->rate, 2) }}</td>
                                            <td>₹ {{ number_format($detail->amount, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6 ms-md-auto text-end">
                                    <label class="fs-6 fw-bold form-label">Total Order Value</label>
                                    <p class="form-control-plaintext fs-4 fw-bold text-primary mb-0">₹ {{ number_format($workOrder->total_order_value, 2) }}</p>
                                </div>
                            </div>
                            @php
                                $woPaid = (float) ($workOrder->vendor_paid_total ?? 0);
                                $woRem = max(0, round((float) $workOrder->total_order_value - $woPaid, 2));
                            @endphp
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label">Paid (vendor payments)</label>
                                    <p class="form-control-plaintext fs-5 fw-bold text-success mb-0">₹ {{ number_format($woPaid, 2) }}</p>
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label">Remaining</label>
                                    <p class="form-control-plaintext fs-5 fw-bold text-warning mb-0">₹ {{ number_format($woRem, 2) }}</p>
                                </div>
                            </div>
                        </div>

                        @if($workOrder->time_limit_for_work)
                        <div class="mb-7">
                            <h3 class="text-success mb-4">TIME LIMIT FOR THIS WORK</h3>
                            <p class="form-control-plaintext">{{ $workOrder->time_limit_for_work }}</p>
                        </div>
                        @endif

                        @if($workOrder->payment_condition)
                        <div class="mb-7">
                            <h3 class="text-success mb-4">PAYMENT CONDITION</h3>
                            <p class="form-control-plaintext">{{ $workOrder->payment_condition }}</p>
                        </div>
                        @endif

                        @if($workOrder->vendorPayments->isNotEmpty())
                        <div class="mb-7">
                            <h3 class="text-success mb-4">VENDOR PAYMENTS</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Date</th>
                                            <th>Amt. (Payable)</th>
                                            <th>Paid Amt.</th>
                                            <th>Ref. No.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($workOrder->vendorPayments as $vp)
                                        <tr>
                                            <td>{{ $vp->payment_date ? $vp->payment_date->format('d-m-Y') : '—' }}</td>
                                            <td>₹ {{ number_format($vp->amount_payable, 2) }}</td>
                                            <td>₹ {{ number_format($vp->paid_amount, 2) }}</td>
                                            <td>{{ $vp->ref_number ?? '—' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif

                        <div class="mb-7">
                            <h3 class="text-success mb-4">LOCATION &amp; WORK</h3>
                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label">Location</label>
                                    <p class="form-control-plaintext">{{ $workOrder->location->name ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label">Work</label>
                                    <p class="form-control-plaintext">{{ $workOrder->work->name_of_work ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
