@section('title','Manage Payment')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Manage Payment</h1>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <a href="{{ route('payments.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Add Payment
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
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="payments-table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Payment Type</th>
                                        <th>Recipient</th>
                                        <th>Amount Payable</th>
                                        <th>Paid Amount</th>
                                        <th>Ref. No.</th>
                                        <th>Payment Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($payments as $index => $payment)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <span class="badge badge-{{ $payment->payment_type == 'staff' ? 'primary' : ($payment->payment_type == 'party' ? 'success' : 'warning') }}">
                                                {{ ucfirst($payment->payment_type) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($payment->payment_type == 'staff' && $payment->staff)
                                                {{ $payment->staff->full_name }}
                                            @elseif($payment->payment_type == 'party' && $payment->party)
                                                {{ $payment->party->name }}
                                            @elseif($payment->payment_type == 'vendor' && $payment->vendor)
                                                {{ $payment->vendor->pedhi }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>₹ {{ number_format($payment->amount_payable, 2) }}</td>
                                        <td>₹ {{ number_format($payment->paid_amount, 2) }}</td>
                                        <td>{{ $payment->ref_number ?? 'N/A' }}</td>
                                        <td>{{ $payment->payment_date ? $payment->payment_date->format('d-m-Y') : 'N/A' }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('payments.edit', $payment) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this payment?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No payments found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
