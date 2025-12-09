@section('title','Edit GST Bill')
@extends('admin.layouts.main')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">Edit GST Bill</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-10">
                <div class="card card-flush h-lg-100" id="kt_gst_bill_list_form_main">
                    <div class="card-body pt-5">
                        <form method="POST" id="kt_gst_bill_list_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" action="{{ route('gst-bill-lists.update', $gstBillList->id) }}">
                            @csrf
                            @method('PUT')
                            
                            <!-- Party Information -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-5">
                                <h3 class="mb-3">Party Information</h3>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Party Name</span>
                                    </label>
                                    <input type="text" class="form-control form-control-solid" name="party_name" value="{{ old('party_name', $gstBillList->party_name) }}" placeholder="Enter Party Name" />
                                    @error('party_name')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label mt-3">GST</label>
                                    <input type="text" class="form-control form-control-solid" name="gst" value="{{ old('gst', $gstBillList->gst) }}" placeholder="Enter GST Number" />
                                    @error('gst')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-3">
                                    <label class="fs-6 fw-bold form-label mt-3">Mobile</label>
                                    <input type="text" class="form-control form-control-solid" name="mobile" value="{{ old('mobile', $gstBillList->mobile) }}" placeholder="Enter Mobile Number" />
                                    @error('mobile')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Inward/Outward</span>
                                    </label>
                                    <select class="form-select form-select-solid" name="is_inward_outward" data-control="select2" data-placeholder="Select Type...">
                                        <option value="">Select Type...</option>
                                        <option value="Inward" {{ old('is_inward_outward', $gstBillList->is_inward_outward) == 'Inward' ? 'selected' : '' }}>Inward</option>
                                        <option value="Outward" {{ old('is_inward_outward', $gstBillList->is_inward_outward) == 'Outward' ? 'selected' : '' }}>Outward</option>
                                    </select>
                                    @error('is_inward_outward')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">GST Slab</span>
                                    </label>
                                    <select class="form-select form-select-solid" name="gst_slab" data-control="select2" data-placeholder="Select GST Slab...">
                                        <option value="">Select GST Slab...</option>
                                        <option value="5" {{ old('gst_slab', $gstBillList->gst_slab) == '5' ? 'selected' : '' }}>5%</option>
                                        <option value="18" {{ old('gst_slab', $gstBillList->gst_slab) == '18' ? 'selected' : '' }}>18%</option>
                                    </select>
                                    @error('gst_slab')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Invoice Information -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-5">
                                <h3 class="mb-3">Invoice Information</h3>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Invoice Number</label>
                                    <input type="text" class="form-control form-control-solid" name="invoice_number" value="{{ old('invoice_number', $gstBillList->invoice_number) }}" placeholder="Enter Invoice Number" />
                                    @error('invoice_number')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Invoice Date</label>
                                    <input type="date" class="form-control form-control-solid" name="invoice_date" value="{{ old('invoice_date', $gstBillList->invoice_date ? $gstBillList->invoice_date->format('Y-m-d') : '') }}" />
                                    @error('invoice_date')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Amount Information -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-5">
                                <h3 class="mb-3">Amount Information</h3>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Basic Amount</span>
                                    </label>
                                    <input type="number" class="form-control form-control-solid" name="basic_amount" id="basic_amount" value="{{ old('basic_amount', $gstBillList->basic_amount) }}" step="0.01" min="0" placeholder="Enter Basic Amount" />
                                    @error('basic_amount')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">GST Amount</label>
                                    <input type="number" class="form-control form-control-solid" name="gst_amount" id="gst_amount" value="{{ old('gst_amount', $gstBillList->gst_amount) }}" step="0.01" min="0" placeholder="Enter GST Amount" />
                                    @error('gst_amount')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Total Bill Amount</span>
                                    </label>
                                    <input type="number" class="form-control form-control-solid" name="total_bill_amount" id="total_bill_amount" value="{{ old('total_bill_amount', $gstBillList->total_bill_amount) }}" step="0.01" min="0" placeholder="Enter Total Bill Amount" />
                                    @error('total_bill_amount')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Payment Information -->
                            <div class="separator separator-dashed my-5"></div>
                            <div class="mb-5">
                                <h3 class="mb-3">Payment Information</h3>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">
                                        <span class="required">Status</span>
                                    </label>
                                    <select class="form-select form-select-solid" name="status" data-control="select2" data-placeholder="Select Status...">
                                        <option value="">Select Status...</option>
                                        <option value="Pending" {{ old('status', $gstBillList->status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Paid" {{ old('status', $gstBillList->status) == 'Paid' ? 'selected' : '' }}>Paid</option>
                                    </select>
                                    @error('status')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Ref Number</label>
                                    <input type="text" class="form-control form-control-solid" name="ref_number" value="{{ old('ref_number', $gstBillList->ref_number) }}" placeholder="Enter Reference Number" />
                                    @error('ref_number')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <label class="fs-6 fw-bold form-label mt-3">Payment Date</label>
                                    <input type="date" class="form-control form-control-solid" name="payment_date" value="{{ old('payment_date', $gstBillList->payment_date ? $gstBillList->payment_date->format('Y-m-d') : '') }}" />
                                    @error('payment_date')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="fs-6 fw-bold form-label mt-3">Debit From</label>
                                    <input type="text" class="form-control form-control-solid" name="debit_from" value="{{ old('debit_from', $gstBillList->debit_from) }}" placeholder="Enter Debit From" />
                                    @error('debit_from')
                                        <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-bold form-label mt-3">Remark</label>
                                <textarea class="form-control form-control-solid" name="remark" rows="3" placeholder="Enter Remark">{{ old('remark', $gstBillList->remark) }}</textarea>
                                @error('remark')
                                    <span id="error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="separator mb-6"></div>
                            <div class="d-flex justify-content-end">
                                <a href="{{route('gst-bill-lists.index')}}" data-kt-gst-bill-list-form="cancel" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" data-kt-gst-bill-list-form="submit" class="btn btn-primary">
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
        // Auto-calculate total bill amount
        $('#basic_amount, #gst_amount').on('input', function() {
            const basicAmount = parseFloat($('#basic_amount').val()) || 0;
            const gstAmount = parseFloat($('#gst_amount').val()) || 0;
            const total = basicAmount + gstAmount;
            $('#total_bill_amount').val(total.toFixed(2));
        });

        // Auto-calculate GST amount based on basic amount and GST slab
        $('#basic_amount, select[name="gst_slab"]').on('input change', function() {
            const basicAmount = parseFloat($('#basic_amount').val()) || 0;
            const gstSlab = parseFloat($('select[name="gst_slab"]').val()) || 0;
            if (gstSlab > 0 && basicAmount > 0) {
                const gstAmount = (basicAmount * gstSlab) / 100;
                $('#gst_amount').val(gstAmount.toFixed(2));
                const total = basicAmount + gstAmount;
                $('#total_bill_amount').val(total.toFixed(2));
            }
        });
    });
</script>
@endsection

