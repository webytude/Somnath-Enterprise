@section('title','Manage Staff')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="card mb-5 mb-xl-12">
            <div class="card-header border-0 pt-6">
                <div class="card-title">
                    <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Manage Staff</h1>
                </div>
                <div class="card-toolbar">
                    <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                        <a href="{{ route('staff.create') }}" type="button" class="btn btn-primary">
                            <span class="svg-icon svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                    <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                </svg>
                            </span>
                            Add Staff
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body py-4">
                @include('global.show_session')
                
                <!-- Tabs -->
                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x border-transparent fs-4 fw-bold mb-5">
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 active" data-bs-toggle="tab" href="#kt_tab_staff_list">
                            <span class="svg-icon svg-icon-2 me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M20 14H18V10H20C20.6 10 21 10.4 21 11V13C21 13.6 20.6 14 20 14Z" fill="currentColor" opacity="0.3"/>
                                    <path d="M17 21H13V17H17C17.6 17 18 17.4 18 18V20C18 20.6 17.6 21 17 21Z" fill="currentColor" opacity="0.3"/>
                                    <path d="M20 7H18V9H20C20.6 9 21 8.6 21 8V6C21 5.4 20.6 5 20 5H18V7H20Z" fill="currentColor" opacity="0.3"/>
                                    <path d="M17 3H13V7H17C17.6 7 18 6.6 18 6V4C18 3.4 17.6 3 17 3Z" fill="currentColor" opacity="0.3"/>
                                    <path d="M7 3H11V7H7C6.4 7 6 6.6 6 6V4C6 3.4 6.4 3 7 3Z" fill="currentColor" opacity="0.3"/>
                                    <path d="M4 10H6V14H4C3.4 14 3 13.6 3 13V11C3 10.4 3.4 10 4 10Z" fill="currentColor" opacity="0.3"/>
                                    <path d="M7 21H11V17H7C6.4 17 6 17.4 6 18V20C6 20.6 6.4 21 7 21Z" fill="currentColor" opacity="0.3"/>
                                    <path d="M4 14H6V10H4C3.4 10 3 10.4 3 11V13C3 13.6 3.4 14 4 14Z" fill="currentColor" opacity="0.3"/>
                                    <path d="M11 21H13V17H11V21Z" fill="currentColor" opacity="0.3"/>
                                    <path d="M11 7H13V3H11V7Z" fill="currentColor" opacity="0.3"/>
                                    <path d="M17 13H20C20.6 13 21 12.6 21 12V11C21 10.4 20.6 10 20 10H17V13Z" fill="currentColor"/>
                                    <path d="M7 13H4C3.4 13 3 12.6 3 12V11C3 10.4 3.4 10 4 10H7V13Z" fill="currentColor"/>
                                    <path d="M13 18H11V21H13C13.6 21 14 20.6 14 20V18C14 17.4 13.6 17 13 17V18Z" fill="currentColor"/>
                                    <path d="M13 7H11V3H13C13.6 3 14 3.4 14 4V6C14 6.6 13.6 7 13 7Z" fill="currentColor"/>
                                </svg>
                            </span>
                            List of Staff
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10" data-bs-toggle="tab" href="#kt_tab_attendance">
                            <span class="svg-icon svg-icon-2 me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect x="2" y="3" width="20" height="18" rx="2" fill="currentColor" opacity="0.3"/>
                                    <path d="M7 8L12 12L17 8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            Attendance
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10" data-bs-toggle="tab" href="#kt_tab_daily_payment">
                            <span class="svg-icon svg-icon-2 me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M14 18V16H10V18L9 20H15L14 18Z" fill="currentColor"/>
                                    <path opacity="0.3" d="M20 4H4C2.9 4 2 4.9 2 6V18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6C22 4.9 21.1 4 20 4ZM20 17C20 17.6 19.6 18 19 18H5C4.4 18 4 17.6 4 17V7C4 6.4 4.4 6 5 6H19C19.6 6 20 6.4 20 7V17Z" fill="currentColor"/>
                                </svg>
                            </span>
                            Daily Payment
                        </a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content" id="kt_tab_content">
                    <!-- List of Staff Tab -->
                    <div class="tab-pane fade show active" id="kt_tab_staff_list" role="tabpanel">
                        <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_staff">
                            <thead>
                                <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                    <th class="min-w-100px">Code</th>
                                    <th class="min-w-100px">Photo</th>
                                    <th class="min-w-125px">Name</th>
                                    <th class="min-w-125px">Father Name</th>
                                    <th class="min-w-100px">Designation</th>
                                    <th class="min-w-100px">Mobile</th>
                                    <th class="min-w-100px">DOJ</th>
                                    <th class="text-end min-w-100px">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600 fw-bold">
                                @forelse($staff as $s)
                                <tr>
                                    <td>{{ $s->code ?? 'N/A' }}</td>
                                    <td>
                                        @if($s->photo)
                                            <img src="{{ $s->photo }}" alt="{{ $s->name }}" class="w-50px h-50px rounded" style="object-fit: cover;">
                                        @else
                                            <div class="symbol symbol-50px">
                                                <div class="symbol-label fs-2 fw-semibold text-success bg-light-success">{{ substr($s->name, 0, 1) }}</div>
                                            </div>
                                        @endif
                                    </td>
                                    <td>{{ $s->name }}</td>
                                    <td>{{ $s->father_name ?? 'N/A' }}</td>
                                    <td>{{ $s->designation ?? 'N/A' }}</td>
                                    <td>{{ $s->mobile_number ?? 'N/A' }}</td>
                                    <td>{{ $s->doj ? $s->doj->format('d/m/Y') : 'N/A' }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('staff.edit', $s) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                                            <span class="svg-icon svg-icon-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </a>
                                        <form action="{{ route('staff.destroy', $s) }}" method="POST" style="display:inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" onclick="return confirm('Are you sure you want to delete this staff?')">
                                                <span class="svg-icon svg-icon-3">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                                        <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No staff found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        </div>
                    </div>

                    <!-- Attendance Tab -->
                    <div class="tab-pane fade" id="kt_tab_attendance" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="mb-0">Staff Attendance - {{ $today->format('d M Y') }}</h3>
                                </div>
                                <div class="card-toolbar">
                                    <div class="d-flex align-items-center gap-5 gap-col-d">
                                        <div class="badge badge-success fs-6 px-4 py-3">
                                            <i class="fas fa-users me-2"></i>
                                            <strong>Present Today: {{ $presentCount }}</strong> / {{ $staff->count() }}
                                        </div>
                                        <div class="alert alert-info mb-0 alert-sm">
                                            <i class="fas fa-info-circle"></i> Only today's date can be marked/unmarked. Past dates are view-only.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @include('global.show_session')
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_attendance">
                                        <thead>
                                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-50px">S.No</th>
                                                <th class="min-w-100px">Photo</th>
                                                <th class="min-w-150px">Staff Name</th>
                                                <th class="min-w-100px">Code</th>
                                                <th class="min-w-100px">Designation</th>
                                                <th class="min-w-100px text-center">Attendance<br><small>(Today: {{ $today->format('d/m/Y') }})</small></th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-600 fw-bold">
                                            @forelse($staff as $index => $s)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    @if($s->photo)
                                                        <img src="{{ $s->photo }}" alt="{{ $s->name }}" class="w-50px h-50px rounded" style="object-fit: cover;">
                                                    @else
                                                        <div class="symbol symbol-50px">
                                                            <div class="symbol-label fs-2 fw-semibold text-success bg-light-success">{{ substr($s->name, 0, 1) }}</div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{ $s->name }}</td>
                                                <td>{{ $s->code ?? 'N/A' }}</td>
                                                <td>{{ $s->designation ?? 'N/A' }}</td>
                                                <td class="text-center">
                                                    <div class="form-check form-check-custom form-check-solid">
                                                        @php
                                                            $isToday = $today->isToday();
                                                            $isChecked = isset($attendances[$s->id]) && $attendances[$s->id];
                                                        @endphp
                                                        <input 
                                                            class="form-check-input attendance-checkbox" 
                                                            type="checkbox" 
                                                            value="1" 
                                                            data-staff-id="{{ $s->id }}"
                                                            data-date="{{ $today->format('Y-m-d') }}"
                                                            id="attendance_{{ $s->id }}"
                                                            {{ $isChecked ? 'checked' : '' }}
                                                            @if(!$isToday) disabled @endif
                                                        />
                                                        <label class="form-check-label" for="attendance_{{ $s->id }}">
                                                            <span class="badge {{ $isChecked ? 'badge-success' : 'badge-danger' }}">
                                                                {{ $isChecked ? 'Present' : 'Absent' }}
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No staff found.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Daily Payment Tab -->
                    <div class="tab-pane fade" id="kt_tab_daily_payment" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <h3 class="mb-0">Daily Payment - {{ $today->format('d M Y') }}</h3>
                                </div>
                                <div class="card-toolbar">
                                    <div class="badge badge-primary fs-6 px-4 py-3">
                                        <i class="fas fa-rupee-sign me-2 white-color"></i>
                                        <strong>Total Paid Today: ₹<span id="total_paid_today">0.00</span></strong>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @include('global.show_session')
                                <div class="alert alert-info mb-5">
                                    <i class="fas fa-info-circle"></i> You can only make payments for employees who are <strong>present today</strong>. Only today's date payments are allowed.
                                </div>
                                
                                @if($presentStaff->count() > 0)
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_payment">
                                        <thead>
                                            <tr class="text-start text-muted fw-bolder fs-7 text-uppercase gs-0">
                                                <th class="min-w-50px">S.No</th>
                                                <th class="min-w-100px">Photo</th>
                                                <th class="min-w-150px">Staff Name</th>
                                                <th class="min-w-100px">Code</th>
                                                <th class="min-w-100px">Designation</th>
                                                <th class="min-w-150px">Amount (₹)</th>
                                                <th class="min-w-120px">Payment Method</th>
                                                <th class="min-w-100px">Status</th>
                                                <th class="min-w-100px text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-600 fw-bold">
                                            @foreach($presentStaff as $index => $s)
                                            @php
                                                $payment = $payments->get($s->id);
                                                $hasPayment = $payment !== null;
                                            @endphp
                                            <tr data-staff-id="{{ $s->id }}">
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    @if($s->photo)
                                                        <img src="{{ $s->photo }}" alt="{{ $s->name }}" class="w-50px h-50px rounded" style="object-fit: cover;">
                                                    @else
                                                        <div class="symbol symbol-50px">
                                                            <div class="symbol-label fs-2 fw-semibold text-success bg-light-success">{{ substr($s->name, 0, 1) }}</div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>{{ $s->name }}</td>
                                                <td>{{ $s->code ?? 'N/A' }}</td>
                                                <td>{{ $s->designation ?? 'N/A' }}</td>
                                                <td>
                                                    @if($hasPayment)
                                                        <div class="payment-display-{{ $s->id }}">
                                                            <strong class="text-success">₹{{ number_format($payment->amount, 2) }}</strong>
                                                        </div>
                                                        <div class="payment-form-{{ $s->id }}" style="display: none;">
                                                            <input type="number" 
                                                                class="form-control form-control-solid payment-amount" 
                                                                step="0.01" 
                                                                min="0" 
                                                                value="{{ $payment->amount }}"
                                                                data-staff-id="{{ $s->id }}"
                                                                placeholder="Enter Amount">
                                                        </div>
                                                    @else
                                                        <div class="payment-display-{{ $s->id }}" style="display: none;">
                                                            <strong class="text-success">₹<span class="amount-display-{{ $s->id }}">0.00</span></strong>
                                                        </div>
                                                        <div class="payment-form-{{ $s->id }}">
                                                            <input type="number" 
                                                                class="form-control form-control-solid payment-amount" 
                                                                step="0.01" 
                                                                min="0" 
                                                                value=""
                                                                data-staff-id="{{ $s->id }}"
                                                                placeholder="Enter Amount">
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($hasPayment)
                                                        <div class="payment-method-display-{{ $s->id }}">
                                                            {{ $payment->payment_method ?? 'N/A' }}
                                                        </div>
                                                        <div class="payment-method-form-{{ $s->id }}" style="display: none;">
                                                            <select class="form-select form-select-solid payment-method" data-staff-id="{{ $s->id }}">
                                                                <option value="">Select Method</option>
                                                                <option value="Cash" {{ $payment->payment_method == 'Cash' ? 'selected' : '' }}>Cash</option>
                                                                <option value="Bank Transfer" {{ $payment->payment_method == 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                                                <option value="UPI" {{ $payment->payment_method == 'UPI' ? 'selected' : '' }}>UPI</option>
                                                                <option value="Cheque" {{ $payment->payment_method == 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                                            </select>
                                                        </div>
                                                    @else
                                                        <div class="payment-method-display-{{ $s->id }}" style="display: none;">
                                                            <span class="method-display-{{ $s->id }}">N/A</span>
                                                        </div>
                                                        <div class="payment-method-form-{{ $s->id }}">
                                                            <select class="form-select form-select-solid payment-method" data-staff-id="{{ $s->id }}">
                                                                <option value="">Select Method</option>
                                                                <option value="Cash">Cash</option>
                                                                <option value="Bank Transfer">Bank Transfer</option>
                                                                <option value="UPI">UPI</option>
                                                                <option value="Cheque">Cheque</option>
                                                            </select>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($hasPayment)
                                                        <span class="badge badge-success">Paid</span>
                                                    @else
                                                        <span class="badge badge-warning">Pending</span>
                                                    @endif
                                                </td>
                                                <td class="text-end">
                                                    @if($hasPayment)
                                                        <button type="button" 
                                                            class="btn btn-sm btn-light-primary edit-payment-btn" 
                                                            data-staff-id="{{ $s->id }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </button>
                                                        <button type="button" 
                                                            class="btn btn-sm btn-light-success save-payment-btn" 
                                                            data-staff-id="{{ $s->id }}"
                                                            data-payment-id="{{ $payment->id }}"
                                                            style="display: none;">
                                                            <i class="fas fa-save"></i> Save
                                                        </button>
                                                        <button type="button" 
                                                            class="btn btn-sm btn-light-danger delete-payment-btn" 
                                                            data-staff-id="{{ $s->id }}"
                                                            data-payment-id="{{ $payment->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @else
                                                        <button type="button" 
                                                            class="btn btn-sm btn-light-success save-payment-btn" 
                                                            data-staff-id="{{ $s->id }}">
                                                            <i class="fas fa-save"></i> Save
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i> No employees are present today. Please mark attendance first.
                                </div>
                                @endif
                            </div>
                        </div>
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
        // Handle attendance checkbox change
        $('.attendance-checkbox').on('change', function() {
            const checkbox = $(this);
            const staffId = checkbox.data('staff-id');
            const date = checkbox.data('date');
            const isPresent = checkbox.is(':checked') ? 1 : 0;
            const today = new Date().toISOString().split('T')[0];
            
            // Only allow changes for today's date
            if (date !== today) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Not Allowed',
                    text: 'You can only mark attendance for today\'s date.',
                    confirmButtonText: 'OK'
                });
                checkbox.prop('checked', !checkbox.is(':checked')); // Revert checkbox
                return;
            }
            
            // Disable checkbox during request
            checkbox.prop('disabled', true);
            
            $.ajax({
                url: '{{ route("attendance.update") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    staff_id: staffId,
                    date: date,
                    is_present: isPresent
                },
                success: function(response) {
                    if (response.success) {
                        // Update badge
                        const label = checkbox.next('label');
                        const badge = label.find('.badge');
                        
                        if (isPresent) {
                            badge.removeClass('badge-danger').addClass('badge-success').text('Present');
                            // Update present count
                            const countBadge = $('.badge-success strong');
                            const currentText = countBadge.text();
                            const match = currentText.match(/(\d+)\s*\/\s*(\d+)/);
                            if (match) {
                                const current = parseInt(match[1]) + 1;
                                const total = match[2];
                                countBadge.text('Present Today: ' + current + ' / ' + total);
                            }
                        } else {
                            badge.removeClass('badge-success').addClass('badge-danger').text('Absent');
                            // Update present count
                            const countBadge = $('.badge-success strong');
                            const currentText = countBadge.text();
                            const match = currentText.match(/(\d+)\s*\/\s*(\d+)/);
                            if (match) {
                                const current = Math.max(0, parseInt(match[1]) - 1);
                                const total = match[2];
                                countBadge.text('Present Today: ' + current + ' / ' + total);
                            }
                        }
                        
                        // Show success message
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || 'Failed to update attendance.',
                            confirmButtonText: 'OK'
                        });
                        checkbox.prop('checked', !checkbox.is(':checked')); // Revert checkbox
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Failed to update attendance.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                        confirmButtonText: 'OK'
                    });
                    checkbox.prop('checked', !checkbox.is(':checked')); // Revert checkbox
                },
                complete: function() {
                    // Re-enable checkbox
                    checkbox.prop('disabled', false);
                }
            });
        });

        // Calculate and display total paid today
        function updateTotalPaid() {
            let total = 0;
            // Get all payment amounts from display
            $('.payment-display strong.text-success').each(function() {
                const text = $(this).text();
                const amount = parseFloat(text.replace('₹', '').replace(/,/g, '')) || 0;
                total += amount;
            });
            // Also check amount-display spans
            $('.amount-display').each(function() {
                const amount = parseFloat($(this).text()) || 0;
                total += amount;
            });
            $('#total_paid_today').text(total.toFixed(2));
        }

        // Initialize total on page load
        $(document).ready(function() {
            updateTotalPaid();
        });

        // Handle edit payment button
        $(document).on('click', '.edit-payment-btn', function() {
            const staffId = $(this).data('staff-id');
            $('.payment-display-' + staffId).hide();
            $('.payment-form-' + staffId).show();
            $('.payment-method-display-' + staffId).hide();
            $('.payment-method-form-' + staffId).show();
            $(this).hide();
            $('.save-payment-btn[data-staff-id="' + staffId + '"]').show();
        });

        // Handle save payment button
        $(document).on('click', '.save-payment-btn', function() {
            const staffId = $(this).data('staff-id');
            const paymentId = $(this).data('payment-id');
            const amount = $('.payment-amount[data-staff-id="' + staffId + '"]').val();
            const paymentMethod = $('.payment-method[data-staff-id="' + staffId + '"]').val();
            const today = new Date().toISOString().split('T')[0];

            if (!amount || parseFloat(amount) <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Amount',
                    text: 'Please enter a valid amount greater than 0.',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Disable button during request
            $(this).prop('disabled', true);

            $.ajax({
                url: '{{ route("daily-payment.store") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    staff_id: staffId,
                    payment_date: today,
                    amount: amount,
                    payment_method: paymentMethod,
                    payment_id: paymentId
                },
                success: function(response) {
                    if (response.success) {
                        // Update display
                        $('.payment-display-' + staffId).show();
                        $('.payment-form-' + staffId).hide();
                        $('.payment-method-display-' + staffId).show();
                        $('.payment-method-form-' + staffId).hide();
                        
                        // Update amount display
                        const amountDisplay = $('.payment-display-' + staffId + ' strong');
                        if (amountDisplay.length) {
                            amountDisplay.text('₹' + parseFloat(amount).toFixed(2));
                        } else {
                            $('.payment-display-' + staffId).html('<strong class="text-success">₹' + parseFloat(amount).toFixed(2) + '</strong>');
                        }
                        
                        // Update method display
                        $('.method-display-' + staffId).text(paymentMethod || 'N/A');
                        
                        // Update status badge
                        const row = $('tr[data-staff-id="' + staffId + '"]');
                        row.find('td:eq(6)').html('<span class="badge badge-success">Paid</span>');
                        
                        // Update buttons
                        $('.edit-payment-btn[data-staff-id="' + staffId + '"]').show();
                        $('.save-payment-btn[data-staff-id="' + staffId + '"]').hide();
                        if (paymentId) {
                            $('.save-payment-btn[data-staff-id="' + staffId + '"]').attr('data-payment-id', response.payment.id);
                        } else {
                            $('.save-payment-btn[data-staff-id="' + staffId + '"]').attr('data-payment-id', response.payment.id);
                            // Add delete button if it doesn't exist
                            if (!$('.delete-payment-btn[data-staff-id="' + staffId + '"]').length) {
                                const deleteBtn = '<button type="button" class="btn btn-sm btn-light-danger delete-payment-btn" data-staff-id="' + staffId + '" data-payment-id="' + response.payment.id + '"><i class="fas fa-trash"></i></button>';
                                row.find('td:last').append(deleteBtn);
                            }
                        }
                        
                        updateTotalPaid();
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Failed to save payment.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: errorMessage,
                        confirmButtonText: 'OK'
                    });
                },
                complete: function() {
                    $('.save-payment-btn[data-staff-id="' + staffId + '"]').prop('disabled', false);
                }
            });
        });

        // Handle delete payment button
        $(document).on('click', '.delete-payment-btn', function() {
            const btn = $(this);
            const paymentId = btn.data('payment-id');
            const staffId = btn.data('staff-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this payment?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url("daily-payment") }}/' + paymentId,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                // Reset to initial state
                                const row = $('tr[data-staff-id="' + staffId + '"]');
                                row.find('td:eq(5)').html(
                                    '<div class="payment-display-' + staffId + '" style="display: none;">' +
                                    '<strong class="text-success">₹<span class="amount-display-' + staffId + '">0.00</span></strong>' +
                                    '</div>' +
                                    '<div class="payment-form-' + staffId + '">' +
                                    '<input type="number" class="form-control form-control-solid payment-amount" step="0.01" min="0" value="" data-staff-id="' + staffId + '" placeholder="Enter Amount">' +
                                    '</div>'
                                );
                                row.find('td:eq(6)').html(
                                    '<div class="payment-method-display-' + staffId + '" style="display: none;">' +
                                    '<span class="method-display-' + staffId + '">N/A</span>' +
                                    '</div>' +
                                    '<div class="payment-method-form-' + staffId + '">' +
                                    '<select class="form-select form-select-solid payment-method" data-staff-id="' + staffId + '">' +
                                    '<option value="">Select Method</option>' +
                                    '<option value="Cash">Cash</option>' +
                                    '<option value="Bank Transfer">Bank Transfer</option>' +
                                    '<option value="UPI">UPI</option>' +
                                    '<option value="Cheque">Cheque</option>' +
                                    '</select>' +
                                    '</div>'
                                );
                                row.find('td:eq(7)').html('<span class="badge badge-warning">Pending</span>');
                                row.find('td:eq(8)').html(
                                    '<button type="button" class="btn btn-sm btn-light-success save-payment-btn" data-staff-id="' + staffId + '">' +
                                    '<i class="fas fa-save"></i> Save' +
                                    '</button>'
                                );
                                
                                updateTotalPaid();
                                
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message,
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                            }
                        },
                        error: function(xhr) {
                            let errorMessage = 'Failed to delete payment.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }
                            
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: errorMessage,
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
