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
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="payments-table" style="min-width: 1400px;">
                                <thead>
                                    <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                        <th class="min-w-70px">Sr. No.</th>
                                        <th class="min-w-150px">Payment Type</th>
                                        <th class="min-w-220px">Recipient</th>
                                        <th class="min-w-220px">Work Order</th>
                                        <th class="min-w-150px text-end">Amount Payable</th>
                                        <th class="min-w-200px text-end">Paid Amount</th>
                                        <th class="min-w-200px text-end">Remaining Amount</th>
                                        <th class="min-w-140px">Ref. No.</th>
                                        <th class="min-w-150px">Payment Date</th>
                                        <th class="text-end min-w-160px">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600 fw-bold">
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
                                        <td>
                                            @if($payment->payment_type === 'vendor' && $payment->workOrder)
                                                <span class="text-gray-800">{{ \Illuminate\Support\Str::limit($payment->workOrder->paymentSelectLabel(), 48) }}</span>
                                            @else
                                                —
                                            @endif
                                        </td>
                                        <td class="text-end">₹ {{ number_format($payment->amount_payable, 2) }}</td>
                                        <td class="text-end">₹ {{ number_format($payment->paid_amount, 2) }}</td>
                                        <td class="text-end">
                                            @php
                                                $remainingAmount = $payment->amount_payable - $payment->paid_amount;
                                            @endphp
                                            <span class="badge badge-{{ $remainingAmount > 0 ? 'warning' : 'success' }}">
                                                ₹ {{ number_format($remainingAmount, 2) }}
                                            </span>
                                        </td>
                                        <td>{{ $payment->ref_number ?? 'N/A' }}</td>
                                        <td>{{ $payment->payment_date ? $payment->payment_date->format('d-m-Y') : 'N/A' }}</td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end gap-2">
                                                <a href="{{ route('payments.show', $payment) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" title="View">
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3" d="M12 4C7 4 2.73 7.11 1 12C2.73 16.89 7 20 12 20C17 20 21.27 16.89 23 12C21.27 7.11 17 4 12 4Z" fill="currentColor"/>
                                                            <path d="M12 9C10.34 9 9 10.34 9 12C9 13.66 10.34 15 12 15C13.66 15 15 13.66 15 12C15 10.34 13.66 9 12 9Z" fill="currentColor"/>
                                                        </svg>
                                                    </span>
                                                </a>
                                                <a href="{{ route('payments.edit', $payment) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" title="Edit">
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                </a>
                                                <form action="{{ route('payments.destroy', $payment) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this payment?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" title="Delete">
                                                        <span class="svg-icon svg-icon-3">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                                <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                                                <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                                                <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                                                            </svg>
                                                        </span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="text-center">No payments found.</td>
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
