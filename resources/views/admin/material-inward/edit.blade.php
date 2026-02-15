@section('title','Edit Material Inward')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Edit Material Inward</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-12">
                <div class="card card-flush h-lg-100" id="kt_material_inward_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_material_inward_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('material-inwards.update', $materialInward->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Section 1: ADD INWARD MATERIAL -->
                            <div class="mb-7">
                                <h3 class="text-success mb-4">ADD INWARD MATERIAL</h3>
                                <div class="row mb-7">
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Location</span>
                                        </label>
                                        <select class="form-select form-select-solid" name="location_id" id="location_id" data-control="select2" data-placeholder="Select Location..." required>
                                            <option value="">Select Location...</option>
                                            @foreach($locations as $location)
                                                <option value="{{ $location->id }}" {{ old('location_id', $materialInward->location_id) == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('location_id')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            Name of Work <span class="text-muted">(OPTIONAL)</span>
                                        </label>
                                        <select class="form-select form-select-solid" name="work_id" id="work_id" data-control="select2" data-placeholder="Select Work...">
                                            <option value="">Select Work...</option>
                                            @foreach($works as $work)
                                                <option value="{{ $work->id }}" {{ old('work_id', $materialInward->work_id) == $work->id ? 'selected' : '' }}>{{ $work->name_of_work }}</option>
                                            @endforeach
                                        </select>
                                        @error('work_id')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Party</span>
                                        </label>
                                        <select class="form-select form-select-solid" name="party_id" id="party_id" data-control="select2" data-placeholder="Select Party..." required>
                                            <option value="">Select Party...</option>
                                            @foreach($parties as $party)
                                                <option value="{{ $party->id }}" data-gst="{{ $party->gst }}" data-pan="{{ $party->pancard }}" {{ old('party_id', $materialInward->party_id) == $party->id ? 'selected' : '' }}>{{ $party->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('party_id')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label mt-3">Party GST (Auto)</label>
                                        <input type="text" class="form-control form-control-solid" id="party_gst" name="party_gst" value="{{ old('party_gst', $materialInward->party_gst) }}" placeholder="Auto-filled from Party" readonly />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label mt-3">Party Pan (Auto)</label>
                                        <input type="text" class="form-control form-control-solid" id="party_pan" name="party_pan" value="{{ old('party_pan', $materialInward->party_pan) }}" placeholder="Auto-filled from Party" readonly />
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2: ADD BILL/VOUCHER DETAILS -->
                            <div class="mb-7">
                                <h3 class="text-success mb-4">ADD BILL/VOUCHER DETAILS</h3>
                                <div class="row mb-7">
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">Bill/Voucher Type</label>
                                        <select class="form-select form-select-solid" name="bill_voucher_type" id="bill_voucher_type">
                                            <option value="">Select Type...</option>
                                            <option value="Bill" {{ old('bill_voucher_type', $materialInward->bill_voucher_type) == 'Bill' ? 'selected' : '' }}>Bill</option>
                                            <option value="Voucher" {{ old('bill_voucher_type', $materialInward->bill_voucher_type) == 'Voucher' ? 'selected' : '' }}>Voucher</option>
                                        </select>
                                        @error('bill_voucher_type')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">Bill/Vhcr No.</label>
                                        <input type="text" class="form-control form-control-solid" name="bill_voucher_number" value="{{ old('bill_voucher_number', $materialInward->bill_voucher_number) }}" placeholder="Enter Bill/Voucher Number" />
                                        @error('bill_voucher_number')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">Bill/Voucher Date</label>
                                        <input type="date" class="form-control form-control-solid" name="bill_voucher_date" value="{{ old('bill_voucher_date', $materialInward->bill_voucher_date ? $materialInward->bill_voucher_date->format('Y-m-d') : '') }}" />
                                        @error('bill_voucher_date')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-7">
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label mt-3">Material Inward At Site Date</label>
                                        <input type="date" class="form-control form-control-solid" name="material_inward_at_site_date" value="{{ old('material_inward_at_site_date', $materialInward->material_inward_at_site_date ? $materialInward->material_inward_at_site_date->format('Y-m-d') : '') }}" />
                                        @error('material_inward_at_site_date')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label mt-3">Attach Bill/Voucher</label>
                                        @if($materialInward->bill_voucher_attachment)
                                            <div class="mb-2">
                                                <a href="{{ $materialInward->bill_voucher_attachment }}" target="_blank" class="btn btn-sm btn-light">View Current File</a>
                                            </div>
                                        @endif
                                        <input type="file" class="form-control form-control-solid" name="bill_voucher_attachment" accept=".pdf,.jpg,.jpeg,.png" />
                                        @error('bill_voucher_attachment')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3: MATERIAL DETAILS -->
                            <div class="mb-7">
                                <h3 class="text-success mb-4">MATERIAL DETAILS</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="material-details-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Material Name</th>
                                                <th>Make</th>
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
                                            @php
                                                $oldDetails = old('details');
                                                $existingDetails = $materialInward->details;
                                                $detailsToShow = $oldDetails ?? $existingDetails;
                                                $detailIndex = 0;
                                            @endphp
                                            @foreach($detailsToShow as $detail)
                                            <tr class="material-detail-row">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <select class="form-select form-select-solid material-select" name="details[{{ $detailIndex }}][material_id]" required>
                                                        <option value="">Select from List</option>
                                                        @foreach($materials as $material)
                                                            <option value="{{ $material->id }}" data-unit="{{ $material->unit }}" {{ (is_object($detail) ? $detail->material_id : ($detail['material_id'] ?? '')) == $material->id ? 'selected' : '' }}>{{ $material->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-solid" name="details[{{ $detailIndex }}][make]" value="{{ is_object($detail) ? $detail->make : ($detail['make'] ?? '') }}" placeholder="Make" />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-solid material-quantity" name="details[{{ $detailIndex }}][quantity]" step="0.01" min="0" value="{{ is_object($detail) ? $detail->quantity : ($detail['quantity'] ?? '') }}" placeholder="Qty" required />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-solid material-unit" name="details[{{ $detailIndex }}][unit]" value="{{ is_object($detail) ? $detail->unit : ($detail['unit'] ?? '') }}" placeholder="Unit" required />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-solid material-rate" name="details[{{ $detailIndex }}][rate]" step="0.01" min="0" value="{{ is_object($detail) ? $detail->rate : ($detail['rate'] ?? '') }}" placeholder="Rate" required />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-solid material-amount" name="details[{{ $detailIndex }}][amount]" step="0.01" min="0" value="{{ is_object($detail) ? $detail->amount : ($detail['amount'] ?? '') }}" placeholder="Amount" readonly />
                                                </td>
                                                <td>
                                                    <select class="form-select form-select-solid material-gst" name="details[{{ $detailIndex }}][gst_percentage]">
                                                        <option value="0" {{ (is_object($detail) ? $detail->gst_percentage : ($detail['gst_percentage'] ?? 0)) == 0 ? 'selected' : '' }}>0%</option>
                                                        <option value="5" {{ (is_object($detail) ? $detail->gst_percentage : ($detail['gst_percentage'] ?? 0)) == 5 ? 'selected' : '' }}>5%</option>
                                                        <option value="18" {{ (is_object($detail) ? $detail->gst_percentage : ($detail['gst_percentage'] ?? 0)) == 18 ? 'selected' : '' }}>18%</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-solid material-subtotal" name="details[{{ $detailIndex }}][sub_total]" step="0.01" min="0" value="{{ is_object($detail) ? $detail->sub_total : ($detail['sub_total'] ?? '') }}" placeholder="Sub Total" readonly />
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger remove-detail-row">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            @php $detailIndex++; @endphp
                                            @endforeach
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
                                            <label class="fs-6 fw-bold form-label">Add Bhadu</label>
                                            <input type="number" class="form-control form-control-solid" name="add_bhadu" id="add_bhadu" step="0.01" min="0" value="{{ old('add_bhadu', $materialInward->add_bhadu) }}" placeholder="0.00" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-bold form-label">(B)</label>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-bold form-label">Total Bill/Voucher Amt.</label>
                                            <input type="number" class="form-control form-control-solid" name="total_bill_voucher_amount" id="total_bill_voucher_amount" step="0.01" min="0" value="{{ old('total_bill_voucher_amount', $materialInward->total_bill_voucher_amount) }}" placeholder="A+B" readonly />
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
                                <textarea class="form-control form-control-solid" name="remarks" rows="3" placeholder="Enter Remarks">{{ old('remarks', $materialInward->remarks) }}</textarea>
                                @error('remarks')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('material-inwards.index')}}" data-kt-material-inward-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-material-inward-form="submit" class="btn btn-primary">
                                    <span class="indicator-label">Update</span>
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
        let detailRowIndex = {{ $detailIndex }};

        // Auto-fill Party GST and PAN
        $('#party_id').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            $('#party_gst').val(selectedOption.data('gst') || '');
            $('#party_pan').val(selectedOption.data('pan') || '');
        });

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
            var addBhadu = parseFloat($('#add_bhadu').val()) || 0;
            var total = totalSubTotal + addBhadu;
            $('#total_bill_voucher_amount').val(total.toFixed(2));
        }

        // Calculate total when Bhadu changes
        $('#add_bhadu').on('input', function() {
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
            var newRow = `
                <tr class="material-detail-row">
                    <td>${detailRowIndex + 1}</td>
                    <td>
                        <select class="form-select form-select-solid material-select" name="details[${detailRowIndex}][material_id]" required>
                            <option value="">Select from List</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}" data-unit="{{ $material->unit }}">{{ $material->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-solid" name="details[${detailRowIndex}][make]" placeholder="Make" />
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

        // Initialize calculations for existing rows
        $('.material-detail-row').each(function() {
            var quantity = parseFloat($(this).find('.material-quantity').val()) || 0;
            var rate = parseFloat($(this).find('.material-rate').val()) || 0;
            var amount = quantity * rate;
            $(this).find('.material-amount').val(amount.toFixed(2));
            calculateSubTotal($(this));
        });
        
        calculateTotal();
        updateRemoveButtons();
        
        // Trigger party change if already selected
        if ($('#party_id').val()) {
            $('#party_id').trigger('change');
        }
    });
</script>
@endsection
