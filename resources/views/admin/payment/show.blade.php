@section('title','View Payment')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">View Payment</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <a href="{{ route('payments.edit', $payment) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('payments.index') }}" class="btn btn-sm btn-light">
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
                        <!-- Payment Type -->
                        <div class="mb-7">
                            <h3 class="text-primary mb-4">PAYMENT TYPE</h3>
                            <div class="row mb-7">
                                <div class="col-md-12">
                                    <label class="fs-6 fw-bold form-label">Payment Type</label>
                                    <p class="form-control-plaintext">
                                        <span class="badge badge-{{ $payment->payment_type == 'staff' ? 'primary' : ($payment->payment_type == 'party' ? 'success' : 'warning') }}">
                                            {{ ucfirst($payment->payment_type) }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if($payment->payment_type == 'staff')
                        <!-- Payment of Staff -->
                        <div class="mb-7">
                            <h3 class="text-success mb-4">PAYMENT OF STAFF</h3>
                            
                            <div class="mb-7">
                                <h4 class="text-success mb-3">OUR STAFF LIST</h4>
                                <div class="row mb-7">
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">Staff Name</label>
                                        <p class="form-control-plaintext">{{ $payment->staff->full_name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label">List of Salary - Amt. (Payable)</label>
                                        <p class="form-control-plaintext">₹ {{ number_format($payment->salary_payable, 2) }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label">List of Expense - Amt. (Payable)</label>
                                        <p class="form-control-plaintext">₹ {{ number_format($payment->expense_payable, 2) }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label">Total Payable - Amt.</label>
                                        <p class="form-control-plaintext">₹ {{ number_format($payment->total_payable, 2) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-7">
                                <h4 class="text-success mb-3">PAYMENT INFORMATION</h4>
                                <div class="row mb-7">
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">Reason of Payment</label>
                                        <p class="form-control-plaintext">{{ $payment->reason_of_payment ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">Amt.</label>
                                        <p class="form-control-plaintext">₹ {{ number_format($payment->amount_payable, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($payment->payment_type == 'party')
                        <!-- Payment of Party -->
                        <div class="mb-7">
                            <h3 class="text-success mb-4">PAYMENT OF PARTY</h3>
                            
                            <div class="mb-7">
                                <h4 class="text-success mb-3">OUR PARTY</h4>
                                <div class="row mb-7">
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">PARTY</label>
                                        <p class="form-control-plaintext">{{ $payment->party->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">List of Bill - Amt. (Payable)</label>
                                        <p class="form-control-plaintext">₹ {{ number_format($payment->bill_payable, 2) }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">Remarks</label>
                                        <p class="form-control-plaintext">{{ $payment->remarks ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-7">
                                <h4 class="text-success mb-3">PAYMENT INFORMATION</h4>
                                <div class="row mb-7">
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label">Reson/Bill No.</label>
                                        <p class="form-control-plaintext">{{ $payment->reason_bill_no ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label">Paid Amt.</label>
                                        <p class="form-control-plaintext">₹ {{ number_format($payment->paid_amount, 2) }}</p>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label">Amt. (Payable)</label>
                                        <p class="form-control-plaintext">₹ {{ number_format($payment->amount_payable, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($payment->payment_type == 'vendor')
                        <!-- Payment of Vendor -->
                        <div class="mb-7">
                            <h3 class="text-success mb-4">PAYMENT OF VENDOR</h3>
                            
                            <div class="mb-7">
                                <h4 class="text-success mb-3">OUR VENDOR</h4>
                                <div class="row mb-7">
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">VENDOR</label>
                                        <p class="form-control-plaintext">{{ $payment->vendor->pedhi ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">List of Bill - Amt. (Payable)</label>
                                        <p class="form-control-plaintext">₹ {{ number_format($payment->bill_payable, 2) }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label">Remarks</label>
                                        <p class="form-control-plaintext">{{ $payment->remarks ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-7">
                                <h4 class="text-success mb-3">PAYMENT INFORMATION</h4>
                                <div class="row mb-7">
                                    <div class="col-md-3">
                                        <label class="fs-6 fw-bold form-label">Reson/Bill No.</label>
                                        <p class="form-control-plaintext">{{ $payment->reason_bill_no ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="fs-6 fw-bold form-label">Amt. (Payable)</label>
                                        <p class="form-control-plaintext">₹ {{ number_format($payment->amount_payable, 2) }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="fs-6 fw-bold form-label">Fill Deduction</label>
                                        <p class="form-control-plaintext">{{ number_format($payment->tds_percentage, 2) }}%</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="fs-6 fw-bold form-label">TDS % of Bill Amt.</label>
                                        <p class="form-control-plaintext">₹ {{ number_format(($payment->amount_payable * $payment->tds_percentage) / 100, 2) }}</p>
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <div class="col-md-3">
                                        <label class="fs-6 fw-bold form-label">Total Deduction</label>
                                        <p class="form-control-plaintext">₹ {{ number_format($payment->total_deduction, 2) }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="fs-6 fw-bold form-label">Paid Amt.</label>
                                        <p class="form-control-plaintext">₹ {{ number_format($payment->paid_amount, 2) }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="fs-6 fw-bold form-label">Ref. No.</label>
                                        <p class="form-control-plaintext">{{ $payment->ref_number ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="fs-6 fw-bold form-label">Date</label>
                                        <p class="form-control-plaintext">{{ $payment->payment_date ? $payment->payment_date->format('d-m-Y') : 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <div class="col-md-12">
                                        <label class="fs-6 fw-bold form-label">Remarks</label>
                                        <p class="form-control-plaintext">{{ $payment->remarks ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Common Payment Information (for Staff) -->
                        @if($payment->payment_type == 'staff')
                        <div class="mb-7">
                            <h4 class="text-success mb-3">PAYMENT INFORMATION</h4>
                            <div class="row mb-7">
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label">Ref. No.</label>
                                    <p class="form-control-plaintext">{{ $payment->ref_number ?? 'N/A' }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label">Date</label>
                                    <p class="form-control-plaintext">{{ $payment->payment_date ? $payment->payment_date->format('d-m-Y') : 'N/A' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label">Remarks</label>
                                    <p class="form-control-plaintext">{{ $payment->remarks ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
