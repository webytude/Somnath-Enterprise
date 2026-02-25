@section('title', isset($payment) ? 'Edit Payment' : 'Add Payment')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">{{ isset($payment) ? 'Edit Payment' : 'Add Payment' }}</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-12">
                <div class="card card-flush h-lg-100" id="kt_payment_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_payment_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ isset($payment) ? route('payments.update', $payment->id) : route('payments.store') }}">
                            @csrf
                            @if(isset($payment))
                                @method('PUT')
                            @endif
                            
                            <!-- Payment Type Selection -->
                            <div class="mb-7">
                                <h3 class="text-primary mb-4">SELECT PAYMENT TYPE</h3>
                                <div class="row mb-7">
                                    <div class="col-md-12">
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Payment Type</span>
                                        </label>
                                        <select class="form-select form-select-solid" name="payment_type" id="payment_type" data-control="select2" data-placeholder="Select Payment Type..." required>
                                            <option value="">Select Payment Type...</option>
                                            <option value="staff" {{ old('payment_type', isset($payment) ? $payment->payment_type : '') == 'staff' ? 'selected' : '' }}>Payment of Staff</option>
                                            <option value="party" {{ old('payment_type', isset($payment) ? $payment->payment_type : '') == 'party' ? 'selected' : '' }}>Payment of Party</option>
                                            <option value="vendor" {{ old('payment_type', isset($payment) ? $payment->payment_type : '') == 'vendor' ? 'selected' : '' }}>Payment of Vendor</option>
                                        </select>
                                        @error('payment_type')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Payment of Staff Section -->
                            <div class="mb-7" id="staff-payment-section" style="display: none;">
                                <h3 class="text-success mb-4">PAYMENT OF STAFF</h3>
                                
                                <!-- OUR STAFF LIST -->
                                <div class="mb-7">
                                    <h4 class="text-success mb-3">OUR STAFF LIST</h4>
                                    <div class="row mb-7">
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Staff Name From List</span>
                                            </label>
                                            <select class="form-select form-select-solid" name="staff_id" id="staff_id" data-control="select2" data-placeholder="Select Staff...">
                                                <option value="">Select Staff...</option>
                                                @foreach($staff as $s)
                                                    <option value="{{ $s->id }}" {{ old('staff_id', isset($payment) ? $payment->staff_id : '') == $s->id ? 'selected' : '' }}>{{ $s->full_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('staff_id')
                                                <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-7">
                                        <div class="col-md-4">
                                            <label class="fs-6 fw-bold form-label mt-3">List of Salary - Amt. (Payable)</label>
                                            <input type="number" class="form-control form-control-solid" name="salary_payable" id="salary_payable" step="0.01" min="0" value="{{ old('salary_payable', isset($payment) ? $payment->salary_payable : 0) }}" placeholder="0.00" readonly />
                                        </div>
                                        <div class="col-md-4">
                                            <label class="fs-6 fw-bold form-label mt-3">List of Expense - Amt. (Payable)</label>
                                            <input type="number" class="form-control form-control-solid" name="expense_payable" id="expense_payable" step="0.01" min="0" value="{{ old('expense_payable', isset($payment) ? $payment->expense_payable : 0) }}" placeholder="0.00" readonly />
                                        </div>
                                        <div class="col-md-4">
                                            <label class="fs-6 fw-bold form-label mt-3">Total Payable - Amt.</label>
                                            <input type="number" class="form-control form-control-solid" name="total_payable" id="total_payable" step="0.01" min="0" value="{{ old('total_payable', isset($payment) ? $payment->total_payable : 0) }}" placeholder="0.00" readonly />
                                        </div>
                                    </div>
                                </div>

                                <!-- PAYMENT INFORMATION -->
                                <div class="mb-7">
                                    <h4 class="text-success mb-3">PAYMENT INFORMATION</h4>
                                    <div class="row mb-7">
                                        <div class="col-md-4">
                                            <label class="fs-6 fw-bold form-label mt-3">Reason of Payment</label>
                                            <input type="text" class="form-control form-control-solid" name="reason_of_payment" id="reason_of_payment" value="{{ old('reason_of_payment', isset($payment) ? $payment->reason_of_payment : '') }}" placeholder="Enter Reason" />
                                            @error('reason_of_payment')
                                                <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Amt. (Payable)</span>
                                            </label>
                                            <input type="number" class="form-control form-control-solid" name="amount_payable" id="amount_payable_staff" step="0.01" min="0" value="{{ old('amount_payable', isset($payment) ? $payment->amount_payable : 0) }}" placeholder="0.00" required />
                                            @error('amount_payable')
                                                <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Paid Amt.</span>
                                            </label>
                                            <input type="number" class="form-control form-control-solid" name="paid_amount" id="paid_amount_staff" step="0.01" min="0" value="{{ old('paid_amount', isset($payment) ? $payment->paid_amount : 0) }}" placeholder="0.00" required />
                                            @error('paid_amount')
                                                <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment of Party Section -->
                            <div class="mb-7" id="party-payment-section" style="display: none;">
                                <h3 class="text-success mb-4">PAYMENT OF PARTY</h3>
                                
                                <!-- OUR PARTY -->
                                <div class="mb-7">
                                    <h4 class="text-success mb-3">OUR PARTY</h4>
                                    <div class="row mb-7">
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">PARTY From List</span>
                                            </label>
                                            <select class="form-select form-select-solid" name="party_id" id="party_id" data-control="select2" data-placeholder="Select Party...">
                                                <option value="">Select Party...</option>
                                                @foreach($parties as $party)
                                                    <option value="{{ $party->id }}" {{ old('party_id', isset($payment) ? $payment->party_id : '') == $party->id ? 'selected' : '' }}>{{ $party->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('party_id')
                                                <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-7">
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-bold form-label mt-3">List of Bill - Amt. (Payable)</label>
                                            <input type="number" class="form-control form-control-solid" name="bill_payable" id="bill_payable_party" step="0.01" min="0" value="{{ old('bill_payable', isset($payment) ? $payment->bill_payable : 0) }}" placeholder="0.00" readonly />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-bold form-label mt-3">Remarks</label>
                                            <textarea class="form-control form-control-solid" name="remarks" rows="2" placeholder="Enter Remarks">{{ old('remarks', isset($payment) ? $payment->remarks : '') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- PAYMENT INFORMATION -->
                                <div class="mb-7">
                                    <h4 class="text-success mb-3">PAYMENT INFORMATION</h4>
                                    <div class="row mb-7">
                                        <div class="col-md-4">
                                            <label class="fs-6 fw-bold form-label mt-3">Reson/Bill No.</label>
                                            <input type="text" class="form-control form-control-solid" name="reason_bill_no" id="reason_bill_no_party" value="{{ old('reason_bill_no', isset($payment) ? $payment->reason_bill_no : '') }}" placeholder="Enter Reason/Bill No." />
                                            @error('reason_bill_no')
                                                <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Paid Amt.</span>
                                            </label>
                                            <input type="number" class="form-control form-control-solid" name="paid_amount" id="paid_amount_party" step="0.01" min="0" value="{{ old('paid_amount', isset($payment) ? $payment->paid_amount : 0) }}" placeholder="0.00" required />
                                            @error('paid_amount')
                                                <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Amt. (Payable)</span>
                                            </label>
                                            <input type="number" class="form-control form-control-solid" name="amount_payable" id="amount_payable_party" step="0.01" min="0" value="{{ old('amount_payable', isset($payment) ? $payment->amount_payable : 0) }}" placeholder="0.00" required />
                                            @error('amount_payable')
                                                <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment of Vendor Section -->
                            <div class="mb-7" id="vendor-payment-section" style="display: none;">
                                <h3 class="text-success mb-4">PAYMENT OF VENDOR</h3>
                                
                                <!-- OUR VENDOR -->
                                <div class="mb-7">
                                    <h4 class="text-success mb-3">OUR VENDOR</h4>
                                    <div class="row mb-7">
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">VENDOR From List</span>
                                            </label>
                                            <select class="form-select form-select-solid" name="vendor_id" id="vendor_id" data-control="select2" data-placeholder="Select Vendor...">
                                                <option value="">Select Vendor...</option>
                                                @foreach($vendors as $vendor)
                                                    <option value="{{ $vendor->id }}" {{ old('vendor_id', isset($payment) ? $payment->vendor_id : '') == $vendor->id ? 'selected' : '' }}>{{ $vendor->pedhi }}</option>
                                                @endforeach
                                            </select>
                                            @error('vendor_id')
                                                <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-7">
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-bold form-label mt-3">List of Bill - Amt. (Payable)</label>
                                            <input type="number" class="form-control form-control-solid" name="bill_payable" id="bill_payable_vendor" step="0.01" min="0" value="{{ old('bill_payable', isset($payment) ? $payment->bill_payable : 0) }}" placeholder="0.00" readonly />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-bold form-label mt-3">Remarks</label>
                                            <textarea class="form-control form-control-solid" name="remarks" rows="2" placeholder="Enter Remarks">{{ old('remarks', isset($payment) ? $payment->remarks : '') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- PAYMENT INFORMATION -->
                                <div class="mb-7">
                                    <h4 class="text-success mb-3">PAYMENT INFORMATION</h4>
                                    <div class="row mb-7">
                                        <div class="col-md-3">
                                            <label class="fs-6 fw-bold form-label mt-3">Reson/Bill No.</label>
                                            <input type="text" class="form-control form-control-solid" name="reason_bill_no" id="reason_bill_no_vendor" value="{{ old('reason_bill_no', isset($payment) ? $payment->reason_bill_no : '') }}" placeholder="Enter Reason/Bill No." />
                                            @error('reason_bill_no')
                                                <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Amt. (Payable)</span>
                                            </label>
                                            <input type="number" class="form-control form-control-solid" name="amount_payable" id="amount_payable_vendor" step="0.01" min="0" value="{{ old('amount_payable', isset($payment) ? $payment->amount_payable : 0) }}" placeholder="0.00" required />
                                            @error('amount_payable')
                                                <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="fs-6 fw-bold form-label mt-3">Fill Deduction</label>
                                            <input type="number" class="form-control form-control-solid" name="tds_percentage" id="tds_percentage" step="0.01" min="0" max="100" value="{{ old('tds_percentage', isset($payment) ? $payment->tds_percentage : 0) }}" placeholder="TDS %" />
                                            @error('tds_percentage')
                                                <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="fs-6 fw-bold form-label mt-3">TDS % of Bill Amt.</label>
                                            <input type="text" class="form-control form-control-solid" id="tds_amount_display" placeholder="0.00" readonly />
                                        </div>
                                    </div>
                                    <div class="row mb-7">
                                        <div class="col-md-3">
                                            <label class="fs-6 fw-bold form-label mt-3">Total Deduction</label>
                                            <input type="number" class="form-control form-control-solid" name="total_deduction" id="total_deduction" step="0.01" min="0" value="{{ old('total_deduction', isset($payment) ? $payment->total_deduction : 0) }}" placeholder="0.00" readonly />
                                            @error('total_deduction')
                                                <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Paid Amt.</span>
                                            </label>
                                            <input type="number" class="form-control form-control-solid" name="paid_amount" id="paid_amount_vendor" step="0.01" min="0" value="{{ old('paid_amount', isset($payment) ? $payment->paid_amount : 0) }}" placeholder="0.00" required readonly />
                                            @error('paid_amount')
                                                <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="fs-6 fw-bold form-label mt-3">Ref. No.</label>
                                            <input type="text" class="form-control form-control-solid" name="ref_number" id="ref_number" value="{{ old('ref_number', isset($payment) ? $payment->ref_number : '') }}" placeholder="Enter Ref. No." />
                                            @error('ref_number')
                                                <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-3">
                                            <label class="fs-6 fw-bold form-label mt-3">
                                                <span class="required">Date</span>
                                            </label>
                                            <input type="date" class="form-control form-control-solid" name="payment_date" id="payment_date" value="{{ old('payment_date', isset($payment) && $payment->payment_date ? $payment->payment_date->format('Y-m-d') : date('Y-m-d')) }}" required />
                                            @error('payment_date')
                                                <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-7">
                                        <div class="col-md-12">
                                            <label class="fs-6 fw-bold form-label mt-3">Remarks</label>
                                            <textarea class="form-control form-control-solid" name="remarks" rows="2" placeholder="Enter Remarks">{{ old('remarks', isset($payment) ? $payment->remarks : '') }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Common Payment Information (for Staff and Party) -->
                            <div class="mb-7" id="common-payment-section" style="display: none;">
                                <h4 class="text-success mb-3">PAYMENT INFORMATION</h4>
                                <div class="row mb-7">
                                    <div class="col-md-3">
                                        <label class="fs-6 fw-bold form-label mt-3">Ref. No.</label>
                                        <input type="text" class="form-control form-control-solid" name="ref_number" id="ref_number_common" value="{{ old('ref_number', isset($payment) ? $payment->ref_number : '') }}" placeholder="Enter Ref. No." />
                                        @error('ref_number')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Date</span>
                                        </label>
                                        <input type="date" class="form-control form-control-solid" name="payment_date" id="payment_date_common" value="{{ old('payment_date', isset($payment) && $payment->payment_date ? $payment->payment_date->format('Y-m-d') : date('Y-m-d')) }}" required />
                                        @error('payment_date')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label mt-3">Remarks</label>
                                        <textarea class="form-control form-control-solid" name="remarks" id="remarks_common" rows="2" placeholder="Enter Remarks">{{ old('remarks', isset($payment) ? $payment->remarks : '') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('payments.index')}}" data-kt-payment-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-payment-form="submit" class="btn btn-primary">
                                    <span class="indicator-label">{{ isset($payment) ? 'Update' : 'Save' }}</span>
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
        // Function to disable all fields in a section
        function disableSectionFields(sectionId) {
            $(sectionId + ' input, ' + sectionId + ' select, ' + sectionId + ' textarea').each(function() {
                if ($(this).attr('name')) {
                    $(this).prop('disabled', true);
                }
            });
        }
        
        // Function to enable all fields in a section
        function enableSectionFields(sectionId) {
            $(sectionId + ' input, ' + sectionId + ' select, ' + sectionId + ' textarea').each(function() {
                if ($(this).attr('name')) {
                    $(this).prop('disabled', false);
                }
            });
        }
        
        // Handle payment type change
        $('#payment_type').on('change', function() {
            var paymentType = $(this).val();
            
            // Disable all sections first
            disableSectionFields('#staff-payment-section');
            disableSectionFields('#party-payment-section');
            disableSectionFields('#vendor-payment-section');
            disableSectionFields('#common-payment-section');
            
            // Hide all sections
            $('#staff-payment-section').hide();
            $('#party-payment-section').hide();
            $('#vendor-payment-section').hide();
            $('#common-payment-section').hide();
            
            // Show and enable relevant section
            if (paymentType === 'staff') {
                // Staff + common (date, ref no, remarks)
                $('#staff-payment-section').show();
                $('#common-payment-section').show();
                enableSectionFields('#staff-payment-section');
                enableSectionFields('#common-payment-section');
            } else if (paymentType === 'party') {
                // Party + common (party payments को भी date चाहिए)
                $('#party-payment-section').show();
                $('#common-payment-section').show();
                enableSectionFields('#party-payment-section');
                enableSectionFields('#common-payment-section');
            } else if (paymentType === 'vendor') {
                // Vendor section only (vendor के लिए अलग layout)
                $('#vendor-payment-section').show();
                enableSectionFields('#vendor-payment-section');
            }
        });

        // Trigger on page load if already selected
        if ($('#payment_type').val()) {
            // Small delay to ensure DOM is ready
            setTimeout(function() {
                $('#payment_type').trigger('change');
            }, 100);
        } else {
            // On initial load, disable all sections if no payment type is selected
            disableSectionFields('#staff-payment-section');
            disableSectionFields('#party-payment-section');
            disableSectionFields('#vendor-payment-section');
            disableSectionFields('#common-payment-section');
        }
        
        // Initialize vendor payment calculation if editing
        @if(isset($payment) && $payment->payment_type == 'vendor')
            calculateVendorPayment();
        @endif

        // Staff payment - Get salary and expense payable
        $('#staff_id').on('change', function() {
            var staffId = $(this).val();
            if (!staffId) {
                $('#salary_payable, #expense_payable, #total_payable, #amount_payable_staff, #paid_amount_staff').val('0.00');
                return;
            }

            $.ajax({
                url: '{{ route("payments.getStaffPayable") }}',
                type: 'GET',
                data: { staff_id: staffId },
                success: function(data) {
                    $('#salary_payable').val(data.salary_payable);
                    $('#expense_payable').val(data.expense_payable);
                    $('#total_payable').val(data.total_payable);
                    // Auto-fill amount payable - ensure it's a number, not string
                    var totalPayable = parseFloat(data.total_payable) || 0;
                    $('#amount_payable_staff').val(totalPayable.toFixed(2));
                    // Auto-fill paid amount same as payable (user can change it)
                    $('#paid_amount_staff').val(totalPayable.toFixed(2));
                    
                    // Trigger input event to ensure form recognizes the change
                    $('#amount_payable_staff, #paid_amount_staff').trigger('input');
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching staff payable:', error);
                }
            });
        });

        // Party payment - Get bills payable
        $('#party_id').on('change', function() {
            var partyId = $(this).val();
            if (!partyId) {
                $('#bill_payable_party, #amount_payable_party').val('0.00');
                return;
            }

            $.ajax({
                url: '{{ route("payments.getPartyBills") }}',
                type: 'GET',
                data: { party_id: partyId },
                success: function(data) {
                    $('#bill_payable_party').val(data.total_payable);
                    $('#amount_payable_party').val(data.total_payable);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching party bills:', error);
                }
            });
        });

        // Vendor payment - Get bills payable
        $('#vendor_id').on('change', function() {
            var vendorId = $(this).val();
            if (!vendorId) {
                $('#bill_payable_vendor, #amount_payable_vendor').val('0.00');
                return;
            }

            $.ajax({
                url: '{{ route("payments.getVendorBills") }}',
                type: 'GET',
                data: { vendor_id: vendorId },
                success: function(data) {
                    $('#bill_payable_vendor').val(data.total_payable);
                    $('#amount_payable_vendor').val(data.total_payable);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching vendor bills:', error);
                }
            });
        });

        // Vendor payment - Calculate deductions
        function calculateVendorPayment() {
            var amountPayable = parseFloat($('#amount_payable_vendor').val()) || 0;
            var tdsPercentage = parseFloat($('#tds_percentage').val()) || 0;
            
            // Calculate TDS Amount
            var tdsAmount = (amountPayable * tdsPercentage) / 100;
            $('#tds_amount_display').val(tdsAmount.toFixed(2));
            
            // Total Deduction = TDS
            var totalDeduction = tdsAmount;
            $('#total_deduction').val(totalDeduction.toFixed(2));
            
            // Paid Amount = Payable - Deduction
            var paidAmount = amountPayable - totalDeduction;
            $('#paid_amount_vendor').val(paidAmount.toFixed(2));
        }

        // Calculate when amount payable or TDS percentage changes
        $('#amount_payable_vendor, #tds_percentage').on('input', function() {
            calculateVendorPayment();
        });

        // Staff payment - Sync paid amount with amount payable (user can change it)
        $('#amount_payable_staff').on('input', function() {
            var amountPayable = parseFloat($(this).val()) || 0;
            // Only auto-fill if paid_amount is empty or same as previous payable
            var currentPaidAmount = parseFloat($('#paid_amount_staff').val()) || 0;
            var previousPayable = parseFloat($('#amount_payable_staff').data('previous-value')) || 0;
            if (currentPaidAmount === previousPayable || currentPaidAmount === 0) {
                $('#paid_amount_staff').val(amountPayable.toFixed(2));
            }
            $('#amount_payable_staff').data('previous-value', amountPayable);
        });

        // Party payment - Sync paid amount with amount payable
        $('#amount_payable_party').on('input', function() {
            var amountPayable = parseFloat($(this).val()) || 0;
            $('#paid_amount_party').val(amountPayable.toFixed(2));
        });
        
        // Form submit handler - ensure disabled fields are removed from submission
        $('#kt_payment_form').on('submit', function(e) {
            var paymentType = $('#payment_type').val();
            
            // Debug: Log values before submission
            if (paymentType === 'staff') {
                console.log('Staff Payment - Amount Payable:', $('#amount_payable_staff').val());
                console.log('Staff Payment - Paid Amount:', $('#paid_amount_staff').val());
                
                // Ensure values are set
                if (!$('#amount_payable_staff').val() || $('#amount_payable_staff').val() == '0') {
                    var totalPayable = $('#total_payable').val();
                    if (totalPayable) {
                        $('#amount_payable_staff').val(totalPayable);
                    }
                }
                if (!$('#paid_amount_staff').val() || $('#paid_amount_staff').val() == '0') {
                    var amountPayable = $('#amount_payable_staff').val();
                    if (amountPayable) {
                        $('#paid_amount_staff').val(amountPayable);
                    }
                }
            }
            
            // Remove disabled fields from form submission (they won't be submitted anyway, but this is cleaner)
            $(this).find('input:disabled, select:disabled, textarea:disabled').each(function() {
                $(this).prop('disabled', false).remove();
            });
        });
    });
</script>
@endsection
