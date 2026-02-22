@section('title','Edit Bill Outward')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Edit Bill Outward</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-12">
                <div class="card card-flush h-lg-100" id="kt_bill_outward_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_bill_outward_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('bill-outwards.update', $billOutward->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Section 1: OUR FIRM -->
                            <div class="mb-7">
                                <h3 class="text-success mb-4">OUR FIRM</h3>
                                <div class="row mb-7">
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Firm From List</span>
                                        </label>
                                        <select class="form-select form-select-solid" name="firm_id" id="firm_id" data-control="select2" data-placeholder="Select Firm..." required>
                                            <option value="">Select Firm...</option>
                                            @foreach($firms as $firm)
                                                <option value="{{ $firm->id }}" data-gst="{{ $firm->gst }}" {{ old('firm_id', $billOutward->firm_id) == $firm->id ? 'selected' : '' }}>{{ $firm->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('firm_id')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label mt-3">GST (Auto)</label>
                                        <input type="text" class="form-control form-control-solid" id="firm_gst" name="firm_gst" value="{{ old('firm_gst', $billOutward->firm_gst) }}" placeholder="Auto-filled from Firm" readonly />
                                    </div>
                                </div>
                            </div>

                            <!-- Section 2: ADD BILL DETAILS -->
                            <div class="mb-7">
                                <h3 class="text-success mb-4">ADD BILL DETAILS</h3>
                                <div class="row mb-7">
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">Bill No.</label>
                                        <input type="text" class="form-control form-control-solid" name="bill_number" value="{{ old('bill_number', $billOutward->bill_number) }}" placeholder="Enter Bill Number" />
                                        @error('bill_number')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">Bill Date</label>
                                        <input type="date" class="form-control form-control-solid" name="bill_date" value="{{ old('bill_date', $billOutward->bill_date ? $billOutward->bill_date->format('Y-m-d') : '') }}" />
                                        @error('bill_date')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">Attach Bill</label>
                                        @if($billOutward->bill_attachment)
                                            <div class="mb-2">
                                                <a href="{{ $billOutward->bill_attachment }}" target="_blank" class="btn btn-sm btn-light-primary">
                                                    <i class="fas fa-file"></i> View Current File
                                                </a>
                                            </div>
                                        @endif
                                        <input type="file" class="form-control form-control-solid" name="bill_attachment" accept=".pdf,.jpg,.jpeg,.png" />
                                        @error('bill_attachment')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Section 3: BILL TO PARTY DETAILS -->
                            <div class="mb-7">
                                <h3 class="text-success mb-4">BILL TO PARTY DETAILS</h3>
                                <div class="row mb-7">
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">
                                            <span class="required">Party</span>
                                        </label>
                                        <select class="form-select form-select-solid" name="party_id" id="party_id" data-control="select2" data-placeholder="Select Party..." required>
                                            <option value="">Select Party...</option>
                                            @foreach($parties as $party)
                                                <option value="{{ $party->id }}" data-gst="{{ $party->gst }}" data-address="{{ $party->address }}" {{ old('party_id', $billOutward->party_id) == $party->id ? 'selected' : '' }}>{{ $party->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('party_id')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">Party GST (Auto)</label>
                                        <input type="text" class="form-control form-control-solid" id="party_gst" name="party_gst" value="{{ old('party_gst', $billOutward->party_gst) }}" placeholder="Auto-filled from Party" readonly />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="fs-6 fw-bold form-label mt-3">Party Address (Auto)</label>
                                        <textarea class="form-control form-control-solid" id="party_address" name="party_address" rows="2" placeholder="Auto-filled from Party" readonly>{{ old('party_address', $billOutward->party_address) }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Section 4: MATERIAL/WORK DETAILS -->
                            <div class="mb-7">
                                <h3 class="text-success mb-4">MATERIAL/WORK DETAILS</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="material-details-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Select-Material/Work Name</th>
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
                                                $existingDetails = $billOutward->details;
                                                $detailsToShow = $oldDetails ?? $existingDetails;
                                                $detailIndex = 0;
                                            @endphp
                                            @foreach($detailsToShow as $detail)
                                            <tr class="material-detail-row">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @php
                                                        $isMaterial = is_object($detail) ? $detail->material_id : (isset($detail['material_id']) && !empty($detail['material_id']));
                                                        $isWork = is_object($detail) ? $detail->work_id : (isset($detail['work_id']) && !empty($detail['work_id']));
                                                        $itemType = $isMaterial ? 'material' : ($isWork ? 'work' : '');
                                                        $materialId = is_object($detail) ? $detail->material_id : ($detail['material_id'] ?? '');
                                                        $workId = is_object($detail) ? $detail->work_id : ($detail['work_id'] ?? '');
                                                    @endphp
                                                    <select class="form-select form-select-solid item-type-select" name="details[{{ $detailIndex }}][item_type]" data-row-index="{{ $detailIndex }}" required>
                                                        <option value="">Select Type</option>
                                                        <option value="material" {{ $itemType == 'material' ? 'selected' : '' }}>Material</option>
                                                        <option value="work" {{ $itemType == 'work' ? 'selected' : '' }}>Work</option>
                                                    </select>
                                                    <select class="form-select form-select-solid material-select mt-2" name="details[{{ $detailIndex }}][material_id]" data-row-index="{{ $detailIndex }}" style="display: {{ $itemType == 'material' ? 'block' : 'none' }};">
                                                        <option value="">Select from List</option>
                                                        @foreach($currentPartyMaterials as $material)
                                                            <option value="{{ $material->id }}" data-unit="{{ $material->unit }}" {{ $materialId == $material->id ? 'selected' : '' }}>{{ $material->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <select class="form-select form-select-solid work-select mt-2" name="details[{{ $detailIndex }}][work_id]" data-row-index="{{ $detailIndex }}" style="display: {{ $itemType == 'work' ? 'block' : 'none' }};">
                                                        <option value="">Select from List</option>
                                                        @foreach($currentPartyWorks as $work)
                                                            <option value="{{ $work->id }}" {{ (int)$workId == (int)$work->id ? 'selected' : '' }}>{{ $work->name_of_work }}</option>
                                                        @endforeach
                                                    </select>
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
                                            <label class="fs-6 fw-bold form-label">Add Bhadu/Labour</label>
                                            <input type="number" class="form-control form-control-solid" name="add_bhadu_labour" id="add_bhadu_labour" step="0.01" min="0" value="{{ old('add_bhadu_labour', $billOutward->add_bhadu_labour) }}" placeholder="0.00" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-bold form-label">(B)</label>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label class="fs-6 fw-bold form-label">Total Bill Amt.</label>
                                            <input type="number" class="form-control form-control-solid" name="total_bill_amount" id="total_bill_amount" step="0.01" min="0" value="{{ old('total_bill_amount', $billOutward->total_bill_amount) }}" placeholder="A+B" readonly />
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
                                <textarea class="form-control form-control-solid" name="remarks" rows="3" placeholder="Enter Remarks">{{ old('remarks', $billOutward->remarks) }}</textarea>
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
                                            <option value="Pending" {{ old('payment_status', $billOutward->payment_status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Received" {{ old('payment_status', $billOutward->payment_status) == 'Received' ? 'selected' : '' }}>Received</option>
                                        </select>
                                        @error('payment_status')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-7" id="payment-details-section" style="display: {{ old('payment_status', $billOutward->payment_status) == 'Received' ? 'block' : 'none' }};">
                                    <div class="col-12 mb-3">
                                        <label class="fs-6 fw-bold form-label">If Received - Fill Deduction Details</label>
                                        <p class="text-muted small">S.D., TDS, GST, L.C., T.C. % of Bill Amt.</p>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="fs-6 fw-bold form-label mt-3">S.D. %</label>
                                        <input type="number" class="form-control form-control-solid deduction-percentage" name="sd_percentage" id="sd_percentage" step="0.01" min="0" max="100" value="{{ old('sd_percentage', $billOutward->sd_percentage ?? 0) }}" placeholder="0.00" />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="fs-6 fw-bold form-label mt-3">TDS %</label>
                                        <input type="number" class="form-control form-control-solid deduction-percentage" name="tds_percentage" id="tds_percentage" step="0.01" min="0" max="100" value="{{ old('tds_percentage', $billOutward->tds_percentage ?? 0) }}" placeholder="0.00" />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="fs-6 fw-bold form-label mt-3">GST %</label>
                                        <input type="number" class="form-control form-control-solid deduction-percentage" name="gst_deduction_percentage" id="gst_deduction_percentage" step="0.01" min="0" max="100" value="{{ old('gst_deduction_percentage', $billOutward->gst_deduction_percentage ?? 0) }}" placeholder="0.00" />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="fs-6 fw-bold form-label mt-3">L.C. %</label>
                                        <input type="number" class="form-control form-control-solid deduction-percentage" name="lc_percentage" id="lc_percentage" step="0.01" min="0" max="100" value="{{ old('lc_percentage', $billOutward->lc_percentage ?? 0) }}" placeholder="0.00" />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="fs-6 fw-bold form-label mt-3">T.C. %</label>
                                        <input type="number" class="form-control form-control-solid deduction-percentage" name="tc_percentage" id="tc_percentage" step="0.01" min="0" max="100" value="{{ old('tc_percentage', $billOutward->tc_percentage ?? 0) }}" placeholder="0.00" />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="fs-6 fw-bold form-label mt-3">Total Deduction</label>
                                        <input type="number" class="form-control form-control-solid" name="total_deduction" id="total_deduction" step="0.01" min="0" value="{{ old('total_deduction', $billOutward->total_deduction ?? 0) }}" placeholder="0.00" readonly />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="fs-6 fw-bold form-label mt-3">Net Received Amt.</label>
                                        <input type="number" class="form-control form-control-solid" name="net_received_amount" id="net_received_amount" step="0.01" min="0" value="{{ old('net_received_amount', $billOutward->net_received_amount ?? 0) }}" placeholder="0.00" readonly />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="fs-6 fw-bold form-label mt-3">Ref. No.</label>
                                        <input type="text" class="form-control form-control-solid" name="payment_ref_number" id="payment_ref_number" value="{{ old('payment_ref_number', $billOutward->payment_ref_number) }}" placeholder="Enter Reference Number" />
                                        @error('payment_ref_number')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-3">
                                        <label class="fs-6 fw-bold form-label mt-3">Date</label>
                                        <input type="date" class="form-control form-control-solid" name="payment_date" id="payment_date" value="{{ old('payment_date', $billOutward->payment_date ? $billOutward->payment_date->format('Y-m-d') : '') }}" />
                                        @error('payment_date')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label class="fs-6 fw-bold form-label mt-3">Remarks</label>
                                        <textarea class="form-control form-control-solid" name="payment_remarks" id="payment_remarks" rows="2" placeholder="Enter Payment Remarks">{{ old('payment_remarks', $billOutward->payment_remarks) }}</textarea>
                                        @error('payment_remarks')
                                            <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('bill-outwards.index')}}" data-kt-bill-outward-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-bill-outward-form="submit" class="btn btn-primary">
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
        var currentPartyId = {{ $billOutward->party_id ?? 'null' }};

        // Auto-fill Firm GST
        $('#firm_id').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            $('#firm_gst').val(selectedOption.data('gst') || '');
        });

        // Handle party change - auto-fill GST/Address and load materials/works
        $('#party_id').on('change', function() {
            var partyId = $(this).val();
            var selectedOption = $(this).find('option:selected');
            
            // Auto-fill Party GST and Address
            $('#party_gst').val(selectedOption.data('gst') || '');
            $('#party_address').val(selectedOption.data('address') || '');
            
            // Load materials and works for this party
            loadMaterialsByParty(partyId);
            loadWorksByParty(partyId);
        });

        // Function to load materials by party
        function loadMaterialsByParty(partyId) {
            if (!partyId) {
                $('.material-select').each(function() {
                    $(this).html('<option value="">Select from List</option>');
                });
                return;
            }

            $.ajax({
                url: '{{ route("bill-outwards.getMaterialsByParty") }}',
                type: 'GET',
                data: { party_id: partyId },
                success: function(data) {
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

        // Function to load works by party
        function loadWorksByParty(partyId) {
            if (!partyId) {
                $('.work-select').each(function() {
                    var currentValue = $(this).val();
                    $(this).html('<option value="">Select from List</option>');
                    if (currentValue) {
                        // Try to preserve the current value by finding it in existing options
                        var existingOption = $(this).data('original-options');
                        if (existingOption && existingOption.length > 0) {
                            $.each(existingOption, function(key, work) {
                                if (work.id == currentValue) {
                                    $(this).append('<option value="' + work.id + '" selected>' + work.name_of_work + '</option>');
                                }
                            }.bind(this));
                        }
                    }
                });
                return;
            }

            $.ajax({
                url: '{{ route("bill-outwards.getWorksByParty") }}',
                type: 'GET',
                data: { party_id: partyId },
                success: function(data) {
                    $('.work-select').each(function() {
                        var currentValue = $(this).val();
                        $(this).html('<option value="">Select from List</option>');
                        
                        if (data && data.length > 0) {
                            $.each(data, function(key, work) {
                                var selected = '';
                                if (currentValue) {
                                    // Compare as integers to avoid type mismatch
                                    if (parseInt(currentValue) == parseInt(work.id)) {
                                        selected = ' selected';
                                    }
                                }
                                $(this).append('<option value="' + work.id + '"' + selected + '>' + work.name_of_work + '</option>');
                            }.bind(this));
                        }
                        
                        // If currentValue exists but wasn't found in the new options, try to preserve it
                        if (currentValue && $(this).find('option[value="' + currentValue + '"]').length === 0) {
                            // The work might not be in party locations, but we should still show it
                            // This is handled by the controller including existing works
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching works:', error);
                }
            });
        }

        // Don't reload works on page load - they're already populated from the controller
        // Only reload when party changes
        // The controller already includes existing works in $currentPartyWorks

        // Show/hide payment details based on status
        $('#payment_status').on('change', function() {
            if ($(this).val() === 'Received') {
                $('#payment-details-section').show();
                $('#payment_ref_number, #payment_date').prop('required', true);
            } else {
                $('#payment-details-section').hide();
                $('#payment_ref_number, #payment_date').prop('required', false);
            }
        });

        // Handle item type selection (Material/Work)
        $(document).on('change', '.item-type-select', function() {
            var row = $(this).closest('tr');
            var rowIndex = $(this).data('row-index');
            var itemType = $(this).val();
            var materialSelect = row.find('.material-select');
            var workSelect = row.find('.work-select');
            
            if (itemType === 'material') {
                materialSelect.show().prop('required', true);
                workSelect.hide().prop('required', false).val('');
            } else if (itemType === 'work') {
                workSelect.show().prop('required', true);
                materialSelect.hide().prop('required', false).val('');
            } else {
                materialSelect.hide().prop('required', false).val('');
                workSelect.hide().prop('required', false).val('');
            }
        });

        // Auto-fill unit when material is selected
        $(document).on('change', '.material-select', function() {
            var selectedOption = $(this).find('option:selected');
            var unit = selectedOption.data('unit') || '';
            $(this).closest('tr').find('.material-unit').val(unit);
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
            var addBhadu = parseFloat($('#add_bhadu_labour').val()) || 0;
            var total = totalSubTotal + addBhadu;
            $('#total_bill_amount').val(total.toFixed(2));
            calculateDeductions();
        }

        // Calculate total when Bhadu changes
        $('#add_bhadu_labour').on('input', function() {
            calculateTotal();
        });

        // Calculate deductions
        function calculateDeductions() {
            if ($('#payment_status').val() !== 'Received') {
                return;
            }
            
            var totalBillAmount = parseFloat($('#total_bill_amount').val()) || 0;
            var totalDeduction = 0;
            
            $('.deduction-percentage').each(function() {
                var percentage = parseFloat($(this).val()) || 0;
                if (percentage > 0) {
                    totalDeduction += (totalBillAmount * percentage) / 100;
                }
            });
            
            $('#total_deduction').val(totalDeduction.toFixed(2));
            var netReceived = totalBillAmount - totalDeduction;
            $('#net_received_amount').val(netReceived.toFixed(2));
        }

        // Calculate deductions when percentage changes or total bill amount changes
        $(document).on('input', '.deduction-percentage', function() {
            calculateDeductions();
        });

        $('#total_bill_amount').on('input', function() {
            calculateDeductions();
        });

        // Add new material/work row
        $('#add-detail-row').on('click', function() {
            var currentPartyId = $('#party_id').val();
            var materialOptions = '<option value="">Select from List</option>';
            var workOptions = '<option value="">Select from List</option>';
            
            // If party is selected, load materials and works via AJAX
            if (currentPartyId) {
                $.ajax({
                    url: '{{ route("bill-outwards.getMaterialsByParty") }}',
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
                
                $.ajax({
                    url: '{{ route("bill-outwards.getWorksByParty") }}',
                    type: 'GET',
                    data: { party_id: currentPartyId },
                    async: false,
                    success: function(data) {
                        if (data && data.length > 0) {
                            $.each(data, function(key, work) {
                                workOptions += '<option value="' + work.id + '">' + work.name_of_work + '</option>';
                            });
                        }
                    }
                });
            }
            
            var newRow = `
                <tr class="material-detail-row">
                    <td>${detailRowIndex + 1}</td>
                    <td>
                        <select class="form-select form-select-solid item-type-select" name="details[${detailRowIndex}][item_type]" data-row-index="${detailRowIndex}" required>
                            <option value="">Select Type</option>
                            <option value="material">Material</option>
                            <option value="work">Work</option>
                        </select>
                        <select class="form-select form-select-solid material-select mt-2" name="details[${detailRowIndex}][material_id]" data-row-index="${detailRowIndex}" style="display: none;">
                            ${materialOptions}
                        </select>
                        <select class="form-select form-select-solid work-select mt-2" name="details[${detailRowIndex}][work_id]" data-row-index="${detailRowIndex}" style="display: none;">
                            ${workOptions}
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

        // Remove material/work row
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
        
        // Trigger firm/party change if already selected
        if ($('#firm_id').val()) {
            $('#firm_id').trigger('change');
        }
        if ($('#party_id').val()) {
            $('#party_id').trigger('change');
        }
    });
</script>
@endsection
