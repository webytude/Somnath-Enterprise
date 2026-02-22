@section('title','Add Bill Inward')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Add Bill Inward</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-12">
                <div class="card card-flush h-lg-100" id="kt_bill_inward_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_bill_inward_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('bill-inwards.store') }}" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- Section 1: OUR FIRM -->
                            <div class="mb-7">
                                <h3 class="text-success mb-4">OUR FIRM</h3>
                                <div class="row mb-7">
                                    <div class="col-md-12">
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Firm From List</span>
                                        </label>
                                        <select class="form-select form-select-solid" name="firm_id" id="firm_id" data-control="select2" data-placeholder="Select Firm..." required>
                                            <option value="">Select Firm...</option>
                                            @foreach($firms as $firm)
                                                <option value="{{ $firm->id }}" {{ old('firm_id') == $firm->id ? 'selected' : '' }}>{{ $firm->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('firm_id')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2: PARTY DETAILS -->
                            <div class="mb-7">
                                <h3 class="text-success mb-4">PARTY DETAILS</h3>
                                <div class="row mb-7">
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Party</span>
                                        </label>
                                        <select class="form-select form-select-solid" name="party_id" id="party_id" data-control="select2" data-placeholder="Select Party..." required>
                                            <option value="">Select Party...</option>
                                            @foreach($parties as $party)
                                                <option value="{{ $party->id }}" data-gst="{{ $party->gst }}" data-pan="{{ $party->pancard }}" {{ old('party_id') == $party->id ? 'selected' : '' }}>{{ $party->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('party_id')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">Party GST (Auto)</label>
                                        <input type="text" class="form-control form-control-solid" id="party_gst" name="party_gst" value="{{ old('party_gst') }}" placeholder="Auto-filled from Party" readonly />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">Party Pan (Auto)</label>
                                        <input type="text" class="form-control form-control-solid" id="party_pan" name="party_pan" value="{{ old('party_pan') }}" placeholder="Auto-filled from Party" readonly />
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3: ADD BILL DETAILS -->
                            <div class="mb-7">
                                <h3 class="text-success mb-4">ADD BILL DETAILS</h3>
                                <div class="row mb-7">
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">Bill No.</label>
                                        <input type="text" class="form-control form-control-solid" name="bill_number" value="{{ old('bill_number') }}" placeholder="Enter Bill Number" />
                                        @error('bill_number')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">Bill Date</label>
                                        <input type="date" class="form-control form-control-solid" name="bill_date" value="{{ old('bill_date') }}" />
                                        @error('bill_date')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">Attach Bill</label>
                                        <input type="file" class="form-control form-control-solid" name="bill_attachment" accept=".pdf,.jpg,.jpeg,.png" />
                                        @error('bill_attachment')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Section 4: MATERIAL DETAILS -->
                            <div class="mb-7">
                                <h3 class="text-success mb-4">MATERIAL DETAILS</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="material-details-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Material Name</th>
                                                <th>Quantity</th>
                                                <th>Unit</th>
                                                <th>Rate</th>
                                                <th>Amt.</th>
                                                <th>Add GST</th>
                                                <th>Sub Total(A)</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="material-details-tbody">
                                            <tr class="material-detail-row">
                                                <td>1</td>
                                                <td>
                                                    <select class="form-select form-select-solid material-select" name="details[0][material_id]" required>
                                                        <option value="">Select from List</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-solid material-quantity" name="details[0][quantity]" step="0.01" min="0" placeholder="Qty" required />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-solid material-unit" name="details[0][unit]" placeholder="Unit" required />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-solid material-rate" name="details[0][rate]" step="0.01" min="0" placeholder="Rate" required />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-solid material-amount" name="details[0][amount]" step="0.01" min="0" placeholder="Amount" readonly />
                                                </td>
                                                <td>
                                                    <select class="form-select form-select-solid material-gst" name="details[0][gst_percentage]">
                                                        <option value="0">0%</option>
                                                        <option value="5">5%</option>
                                                        <option value="18">18%</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-solid material-subtotal" name="details[0][sub_total]" step="0.01" min="0" placeholder="Sub Total" readonly />
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger remove-detail-row" style="display: none;">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-primary mt-3" id="add-detail-row">
                                    <i class="fas fa-plus"></i> Add More Materials
                                </button>
                                @error('details')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Summary Calculations -->
                            <div class="row mb-7">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-bold form-label">Add Bhadu/Labour</label>
                                            <input type="number" class="form-control form-control-solid" name="add_bhadu_labour" id="add_bhadu_labour" step="0.01" min="0" value="{{ old('add_bhadu_labour', 0) }}" placeholder="0.00" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-bold form-label">(B)</label>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-bold form-label">Total Bill/Voucher Amt.</label>
                                            <input type="number" class="form-control form-control-solid" name="total_bill_amount" id="total_bill_amount" step="0.01" min="0" value="{{ old('total_bill_amount', 0) }}" placeholder="A+B" readonly />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-bold form-label">A+B</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Remarks -->
                            <div class="mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Remarks</label>
                                <textarea class="form-control form-control-solid" name="remarks" rows="3" placeholder="Enter Remarks">{{ old('remarks') }}</textarea>
                                @error('remarks')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Section 5: PAYMENT INFORMATION -->
                            <div class="mb-7">
                                <h3 class="text-success mb-4">PAYMENT INFORMATION</h3>
                                <div class="row mb-7">
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Status</span>
                                        </label>
                                        <select class="form-select form-select-solid" name="payment_status" id="payment_status" required>
                                            <option value="Pending" {{ old('payment_status', 'Pending') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Paid" {{ old('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                                        </select>
                                        @error('payment_status')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-7" id="payment-details-section" style="display: none;">
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">If Paid - Ref. No.</label>
                                        <input type="text" class="form-control form-control-solid" name="payment_ref_number" id="payment_ref_number" value="{{ old('payment_ref_number') }}" placeholder="Enter Reference Number" />
                                        @error('payment_ref_number')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">If Paid - Date</label>
                                        <input type="date" class="form-control form-control-solid" name="payment_date" id="payment_date" value="{{ old('payment_date') }}" />
                                        @error('payment_date')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">If Paid - Remarks</label>
                                        <textarea class="form-control form-control-solid" name="payment_remarks" id="payment_remarks" rows="2" placeholder="Enter Payment Remarks">{{ old('payment_remarks') }}</textarea>
                                        @error('payment_remarks')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('bill-inwards.index')}}" data-kt-bill-inward-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-bill-inward-form="submit" class="btn btn-primary">
                                    <span class="indicator-label">Save</span>
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
        let detailRowIndex = 1;

        // Handle party change - auto-fill GST/PAN and load materials
        $('#party_id').on('change', function() {
            var partyId = $(this).val();
            var selectedOption = $(this).find('option:selected');
            
            // Auto-fill Party GST and PAN
            $('#party_gst').val(selectedOption.data('gst') || '');
            $('#party_pan').val(selectedOption.data('pan') || '');
            
            // Load materials for this party
            loadMaterialsByParty(partyId);
        });

        // Function to load materials by party
        function loadMaterialsByParty(partyId) {
            if (!partyId) {
                // Clear all material selects
                $('.material-select').each(function() {
                    $(this).html('<option value="">Select from List</option>');
                });
                return;
            }

            $.ajax({
                url: '{{ route("bill-inwards.getMaterialsByParty") }}',
                type: 'GET',
                data: { party_id: partyId },
                success: function(data) {
                    // Update all material select dropdowns
                    $('.material-select').each(function() {
                        var currentValue = $(this).val();
                        $(this).html('<option value="">Select from List</option>');
                        
                        if (data && data.length > 0) {
                            $.each(data, function(key, material) {
                                var selected = (currentValue == material.id) ? ' selected' : '';
                                $(this).append('<option value="' + material.id + '" data-unit="' + material.unit + '"' + selected + '>' + material.name + '</option>');
                            }.bind(this));
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching materials:', error);
                }
            });
        }

        // Show/hide payment details based on status
        $('#payment_status').on('change', function() {
            if ($(this).val() === 'Paid') {
                $('#payment-details-section').show();
                $('#payment_ref_number, #payment_date').prop('required', true);
            } else {
                $('#payment-details-section').hide();
                $('#payment_ref_number, #payment_date').prop('required', false);
            }
        });

        // Trigger on page load if already selected
        if ($('#payment_status').val() === 'Paid') {
            $('#payment-details-section').show();
        }

        // Calculate amount when quantity or rate changes
        $(document).on('input', '.material-quantity, .material-rate', function() {
            var row = $(this).closest('tr');
            var quantity = parseFloat(row.find('.material-quantity').val()) || 0;
            var rate = parseFloat(row.find('.material-rate').val()) || 0;
            var amount = quantity * rate;
            row.find('.material-amount').val(amount.toFixed(2));
            calculateSubTotal(row);
        });

        // Calculate subtotal when GST changes
        $(document).on('change', '.material-gst', function() {
            var row = $(this).closest('tr');
            calculateSubTotal(row);
        });

        function calculateSubTotal(row) {
            var amount = parseFloat(row.find('.material-amount').val()) || 0;
            var gstPercentage = parseFloat(row.find('.material-gst').val()) || 0;
            var gstAmount = (amount * gstPercentage) / 100;
            var subTotal = amount + gstAmount;
            row.find('.material-subtotal').val(subTotal.toFixed(2));
            calculateTotal();
        }

        function calculateTotal() {
            var totalSubTotal = 0;
            $('.material-subtotal').each(function() {
                totalSubTotal += parseFloat($(this).val()) || 0;
            });
            var addBhadu = parseFloat($('#add_bhadu_labour').val()) || 0;
            var total = totalSubTotal + addBhadu;
            $('#total_bill_amount').val(total.toFixed(2));
        }

        // Calculate total when Bhadu changes
        $('#add_bhadu_labour').on('input', function() {
            calculateTotal();
        });

        // Auto-fill unit when material is selected
        $(document).on('change', '.material-select', function() {
            var selectedOption = $(this).find('option:selected');
            var unit = selectedOption.data('unit') || '';
            $(this).closest('tr').find('.material-unit').val(unit);
        });

        // Add new material row
        $('#add-detail-row').on('click', function() {
            var currentPartyId = $('#party_id').val();
            var materialOptions = '<option value="">Select from List</option>';
            
            // If party is selected, load materials via AJAX
            if (currentPartyId) {
                $.ajax({
                    url: '{{ route("bill-inwards.getMaterialsByParty") }}',
                    type: 'GET',
                    data: { party_id: currentPartyId },
                    async: false,
                    success: function(data) {
                        if (data && data.length > 0) {
                            $.each(data, function(key, material) {
                                materialOptions += '<option value="' + material.id + '" data-unit="' + material.unit + '">' + material.name + '</option>';
                            });
                        }
                    }
                });
            }
            
            var newRow = `
                <tr class="material-detail-row">
                    <td>${detailRowIndex + 1}</td>
                    <td>
                        <select class="form-select form-select-solid material-select" name="details[${detailRowIndex}][material_id]" required>
                            ${materialOptions}
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-solid material-quantity" name="details[${detailRowIndex}][quantity]" step="0.01" min="0" placeholder="Qty" required />
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-solid material-unit" name="details[${detailRowIndex}][unit]" placeholder="Unit" required />
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-solid material-rate" name="details[${detailRowIndex}][rate]" step="0.01" min="0" placeholder="Rate" required />
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-solid material-amount" name="details[${detailRowIndex}][amount]" step="0.01" min="0" placeholder="Amount" readonly />
                    </td>
                    <td>
                        <select class="form-select form-select-solid material-gst" name="details[${detailRowIndex}][gst_percentage]">
                            <option value="0">0%</option>
                            <option value="5">5%</option>
                            <option value="18">18%</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control form-control-solid material-subtotal" name="details[${detailRowIndex}][sub_total]" step="0.01" min="0" placeholder="Sub Total" readonly />
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-danger remove-detail-row">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            $('#material-details-tbody').append(newRow);
            detailRowIndex++;
            updateRemoveButtons();
            updateRowNumbers();
        });

        // Remove material row
        $(document).on('click', '.remove-detail-row', function() {
            $(this).closest('tr').remove();
            updateRemoveButtons();
            updateRowNumbers();
            calculateTotal();
        });

        function updateRemoveButtons() {
            const rows = $('.material-detail-row');
            rows.each(function() {
                const removeBtn = $(this).find('.remove-detail-row');
                if (rows.length > 1) {
                    removeBtn.show();
                } else {
                    removeBtn.hide();
                }
            });
        }

        function updateRowNumbers() {
            $('.material-detail-row').each(function(index) {
                $(this).find('td:first').text(index + 1);
            });
        }

        // Initialize
        updateRemoveButtons();
        
        // Trigger party change if already selected
        if ($('#party_id').val()) {
            $('#party_id').trigger('change');
        }
    });
</script>
@endsection
