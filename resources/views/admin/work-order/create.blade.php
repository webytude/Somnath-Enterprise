@php
    $isEdit = isset($workOrder);
    $rows = old('details');
    if ($rows === null && $isEdit) {
        $rows = $workOrder->details->map(function ($d) {
            return [
                'work_details' => $d->work_details,
                'quantity' => $d->quantity,
                'unit' => $d->unit,
                'rate' => $d->rate,
            ];
        })->values()->all();
    }
    if (empty($rows)) {
        $rows = [['work_details' => '', 'quantity' => '', 'unit' => '', 'rate' => '']];
    }
@endphp
@extends('admin.layouts.main')
@section('title', $isEdit ? 'Edit Work Order' : 'New Work Order')
@section('main_contant')
<div class="toolbar bg-transparent pt-6 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-fluid d-flex flex-stack">
        <div data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_content_container', 'lg': '#kt_toolbar_container'}" class="page-title d-flex flex-column align-items-start me-3 mb-5 mb-lg-0">
            <h1 class="d-flex text-dark fw-bolder fs-3 flex-column mb-0">{{ $isEdit ? 'Edit Work Order' : 'New Work Order' }}</h1>
        </div>
    </div>
</div>
<div class="post d-flex flex-column-fluid" id="kt_post">
    <div id="kt_content_container" class="container-fluid">
        <div class="row g-7">
            <div class="col-xl-12">
                <div class="card card-flush h-lg-100">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <h2 class="fw-bolder mb-0">{{ $isEdit ? 'Edit Work Order Details' : 'New Work Order Details' }}</h2>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <form method="POST" id="kt_work_order_form" action="{{ $isEdit ? route('work-orders.update', $workOrder) : route('work-orders.store') }}" class="form fv-plugins-bootstrap5 fv-plugins-framework">
                            @csrf
                            @if($isEdit)
                                @method('PUT')
                            @endif

                            <div class="mb-10">
                                <div class="d-flex align-items-center mb-5">
                                    <span class="bullet bullet-vertical h-40px bg-primary me-4"></span>
                                    <h3 class="text-gray-800 fw-bolder mb-0">WORK ORDER</h3>
                                </div>
                                <div class="row g-5 mb-7">
                                    <div class="col-12 col-lg-6">
                                        <label class="fs-6 fw-bold form-label mt-3">W.O. Number</label>
                                        @if($isEdit)
                                            <input type="text" class="form-control form-control-solid" id="wo_number_display" value="{{ $previewWorkOrderNumber }}" readonly />
                                            <div class="form-text">Number is fixed after creation.</div>
                                        @else
                                            <div class="row g-3">
                                                <div class="col-sm-4">
                                                    <label class="fs-7 text-muted mb-1">Prefix</label>
                                                    <input type="text" class="form-control form-control-solid" name="number_prefix" id="number_prefix" maxlength="20" value="{{ old('number_prefix', $defaultPrefix ?? 'GP') }}" required autocomplete="off" />
                                                    @error('number_prefix')
                                                        <span class="error invalid-feedback d-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-sm-4">
                                                    <label class="fs-7 text-muted mb-1">Financial year</label>
                                                    <input type="text" class="form-control form-control-solid" name="fiscal_year_label" id="fiscal_year_label" placeholder="2026-27" value="{{ old('fiscal_year_label', $defaultFy ?? '') }}" required autocomplete="off" inputmode="numeric" />
                                                    @error('fiscal_year_label')
                                                        <span class="error invalid-feedback d-block">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-sm-12">
                                                    <label class="fs-7 text-muted mb-1">Next number (preview)</label>
                                                    <input type="text" class="form-control form-control-solid" id="wo_number_display" readonly value="{{ $previewWorkOrderNumber }}" />
                                                </div>
                                            </div>
                                            <div class="form-text">Format: PREFIX/###/YYYY-YY — middle number is the next global serial (changing prefix or year only updates the text around it).</div>
                                        @endif
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label class="fs-6 fw-bold form-label mt-3"><span class="required">Date</span></label>
                                        <input type="date" class="form-control form-control-solid" name="order_date" id="order_date" value="{{ old('order_date', $isEdit && $workOrder->order_date ? $workOrder->order_date->format('Y-m-d') : date('Y-m-d')) }}" required />
                                        @error('order_date')
                                            <span class="error invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-10">
                                <div class="d-flex align-items-center mb-5">
                                    <span class="bullet bullet-vertical h-40px bg-primary me-4"></span>
                                    <h3 class="text-gray-800 fw-bolder mb-0">SELECT VENDOR</h3>
                                </div>
                                <div class="row g-5 mb-7">
                                    <div class="col-12">
                                        <label class="fs-6 fw-bold form-label mt-3"><span class="required">Vendor From List</span></label>
                                        <select class="form-select form-select-solid" name="contractor_id" id="contractor_id" data-control="select2" data-placeholder="Select Vendor..." required>
                                            <option value="">Select Vendor...</option>
                                            @foreach($contractors as $c)
                                                <option value="{{ $c->id }}"
                                                    data-pedhi="{{ e($c->pedhi) }}"
                                                    data-address="{{ e($c->address) }}"
                                                    data-pan="{{ e($c->pan) }}"
                                                    data-gst="{{ e($c->gst) }}"
                                                    data-contact-person="{{ e($c->contact_person) }}"
                                                    data-contact-mobile="{{ e($c->contact_person_mobile) }}"
                                                    {{ (string) old('contractor_id', $isEdit ? $workOrder->contractor_id : '') === (string) $c->id ? 'selected' : '' }}>
                                                    {{ $c->pedhi }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('contractor_id')
                                            <span class="error invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row g-5 mb-7">
                                    <div class="col-12 col-lg-6">
                                        <label class="fs-6 fw-bold form-label mt-3">Vendor Name</label>
                                        <input type="text" class="form-control form-control-solid" id="vendor_name_display" readonly />
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <label class="fs-6 fw-bold form-label mt-3">Vendor Address</label>
                                        <textarea class="form-control form-control-solid" id="vendor_address_display" rows="2" readonly></textarea>
                                    </div>
                                </div>
                                <div class="row g-5 mb-7">
                                    <div class="col-12 col-lg-4">
                                        <label class="fs-6 fw-bold form-label mt-3">Pancard</label>
                                        <input type="text" class="form-control form-control-solid" id="vendor_pan_display" readonly />
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label class="fs-6 fw-bold form-label mt-3">GST</label>
                                        <input type="text" class="form-control form-control-solid" id="vendor_gst_display" readonly />
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <label class="fs-6 fw-bold form-label mt-3">Cont. Pers. Name</label>
                                        <input type="text" class="form-control form-control-solid" id="vendor_contact_name_display" readonly />
                                    </div>
                                </div>
                                <div class="row g-5 mb-7">
                                    <div class="col-12 col-lg-6">
                                        <label class="fs-6 fw-bold form-label mt-3">Cont. Pers. No.</label>
                                        <input type="text" class="form-control form-control-solid" id="vendor_contact_mobile_display" readonly />
                                    </div>
                                </div>
                                <div class="separator separator-dashed my-4"></div>
                                <h4 class="fs-6 fw-bold text-gray-700 mb-4">Location &amp; work</h4>
                                <div class="row g-5 mb-7">
                                    <div class="col-12 col-lg-6">
                                        <label class="fs-6 fw-bold form-label mt-3"><span class="required">Select Location</span></label>
                                        <select class="form-select form-select-solid" name="location_id" id="location_id" data-control="select2" data-placeholder="Select Location..." required>
                                            <option value="">Select Location...</option>
                                        </select>
                                        <div class="form-text text-muted" id="location_vendor_hint">Choose a vendor first; locations and works come from the vendor master.</div>
                                        @error('location_id')
                                            <span class="error invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-6 fw-bold form-label mt-3">Select Work</label>
                                        <select class="form-select form-select-solid" name="work_id" id="work_id" data-control="select2" data-placeholder="Select Work...">
                                            <option value="">Select Work...</option>
                                        </select>
                                        @error('work_id')
                                            <span class="error invalid-feedback d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-10">
                                <div class="d-flex align-items-center mb-5">
                                    <span class="bullet bullet-vertical h-40px bg-primary me-4"></span>
                                    <h3 class="text-gray-800 fw-bolder mb-0">SUBJECT</h3>
                                </div>
                                <textarea class="form-control form-control-solid" name="subject" rows="3" placeholder="Subject">{{ old('subject', $isEdit ? $workOrder->subject : '') }}</textarea>
                                @error('subject')
                                    <span class="error invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-10">
                                <div class="d-flex align-items-center mb-5">
                                    <span class="bullet bullet-vertical h-40px bg-primary me-4"></span>
                                    <h3 class="text-gray-800 fw-bolder mb-0">CONDITION</h3>
                                </div>
                                <textarea class="form-control form-control-solid" name="condition_text" rows="3" placeholder="Condition">{{ old('condition_text', $isEdit ? $workOrder->condition_text : '') }}</textarea>
                                @error('condition_text')
                                    <span class="error invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-10">
                                <div class="d-flex align-items-center mb-5">
                                    <span class="bullet bullet-vertical h-40px bg-primary me-4"></span>
                                    <h3 class="text-gray-800 fw-bolder mb-0">RATE DETAILS</h3>
                                </div>
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="wo-details-table" style="min-width: 1000px;">
                                        <thead>
                                            <tr>
                                                <th style="width:50px;">Sr.</th>
                                                <th>Work Details</th>
                                                <th style="width:110px;">Quantity</th>
                                                <th style="width:100px;">Unit</th>
                                                <th style="width:120px;">Rate</th>
                                                <th style="width:120px;">Amt.</th>
                                                <th style="width:60px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="wo-details-tbody">
                                            @foreach($rows as $i => $row)
                                            <tr class="wo-detail-row">
                                                <td class="wo-sr">{{ $i + 1 }}</td>
                                                <td>
                                                    <input type="text" class="form-control form-control-solid" name="details[{{ $i }}][work_details]" value="{{ old('details.'.$i.'.work_details', $row['work_details'] ?? '') }}" required />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-solid wo-qty" name="details[{{ $i }}][quantity]" step="0.0001" min="0" value="{{ old('details.'.$i.'.quantity', $row['quantity'] ?? '') }}" required />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-solid" name="details[{{ $i }}][unit]" value="{{ old('details.'.$i.'.unit', $row['unit'] ?? '') }}" required />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control form-control-solid wo-rate" name="details[{{ $i }}][rate]" step="0.01" min="0" value="{{ old('details.'.$i.'.rate', $row['rate'] ?? '') }}" required />
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control form-control-solid wo-amt" readonly value="" />
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger wo-remove-row" {{ count($rows) < 2 ? 'style=display:none' : '' }}><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <button type="button" class="btn btn-sm btn-primary mt-3" id="wo-add-row"><i class="fas fa-plus"></i> Add More Work Details</button>
                                @error('details')
                                    <span class="error invalid-feedback d-block">{{ $message }}</span>
                                @enderror
                                <div class="row justify-content-end mt-5">
                                    <div class="col-12 col-md-8 col-lg-4">
                                        <label class="fs-6 fw-bold form-label">Total Order Value</label>
                                        <input type="text" class="form-control form-control-solid fw-bold" id="total_order_value_display" readonly value="0.00" />
                                    </div>
                                </div>
                            </div>

                            <div class="mb-10">
                                <div class="d-flex align-items-center mb-5">
                                    <span class="bullet bullet-vertical h-40px bg-primary me-4"></span>
                                    <h3 class="text-gray-800 fw-bolder mb-0">TIME LIMIT FOR THIS WORK</h3>
                                </div>
                                <textarea class="form-control form-control-solid" name="time_limit_for_work" rows="2" placeholder="Time limit">{{ old('time_limit_for_work', $isEdit ? $workOrder->time_limit_for_work : '') }}</textarea>
                            </div>

                            <div class="mb-10">
                                <div class="d-flex align-items-center mb-5">
                                    <span class="bullet bullet-vertical h-40px bg-primary me-4"></span>
                                    <h3 class="text-gray-800 fw-bolder mb-0">PAYMENT CONDITION</h3>
                                </div>
                                <textarea class="form-control form-control-solid" name="payment_condition" rows="2" placeholder="Payment condition">{{ old('payment_condition', $isEdit ? $workOrder->payment_condition : '') }}</textarea>
                            </div>

                            <div class="separator mb-6"></div>
                            <div class="d-flex flex-column flex-sm-row justify-content-end gap-3">
                                <a href="{{ route('work-orders.index') }}" class="btn btn-light">Cancel</a>
                                <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Update' : 'Save' }}</button>
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
(function() {
    var isEdit = @json($isEdit);
    var previewUrl = @json(route('work-orders.previewNumber'));
    var vendorAssignmentsBase = @json(url('work-orders/vendor-assignments'));
    var selectedWorkId = @json(old('work_id', $isEdit && $workOrder->work_id ? (string) $workOrder->work_id : ''));
    var initialLocationId = @json(old('location_id', $isEdit && $workOrder->location_id ? (string) $workOrder->location_id : ''));
    var vendorCache = { locations: [], works: [] };

    function vendorAssignmentsUrl(id) {
        return vendorAssignmentsBase.replace(/\/?$/, '/') + id;
    }

    function fillVendorFromSelect() {
        var opt = $('#contractor_id option:selected');
        $('#vendor_name_display').val(opt.attr('data-pedhi') || '');
        $('#vendor_address_display').val(opt.attr('data-address') || '');
        $('#vendor_pan_display').val(opt.attr('data-pan') || '');
        $('#vendor_gst_display').val(opt.attr('data-gst') || '');
        $('#vendor_contact_name_display').val(opt.attr('data-contact-person') || '');
        $('#vendor_contact_mobile_display').val(opt.attr('data-contact-mobile') || '');
    }

    function loadWorksForLocation(locationId, preserveSelected) {
        var $select = $('#work_id');
        $select.empty().append('<option value="">Select Work...</option>');
        if (!locationId) {
            $select.trigger('change');
            return;
        }
        var list = (vendorCache.works || []).filter(function(w) {
            return String(w.location_id) === String(locationId);
        });
        $.each(list, function(_, w) {
            var sel = preserveSelected && String(preserveSelected) === String(w.id) ? ' selected' : '';
            $select.append('<option value="' + w.id + '"' + sel + '>' + $('<div>').text(w.name_of_work).html() + '</option>');
        });
        $select.trigger('change');
    }

    function loadVendorAssignments(contractorId, opts) {
        opts = opts || {};
        var preserveLocationId = opts.preserveLocationId || '';
        var preserveWorkId = opts.preserveWorkId || '';
        $('#location_vendor_hint').text('Loading...');
        $.get(vendorAssignmentsUrl(contractorId), function(data) {
            vendorCache.locations = data.locations || [];
            vendorCache.works = data.works || [];
            var $loc = $('#location_id');
            $loc.empty().append('<option value="">Select Location...</option>');
            vendorCache.locations.forEach(function(l) {
                var sel = preserveLocationId && String(preserveLocationId) === String(l.id) ? ' selected' : '';
                $loc.append('<option value="' + l.id + '"' + sel + '>' + $('<div>').text(l.name).html() + '</option>');
            });
            if (vendorCache.locations.length === 0) {
                $('#location_vendor_hint').text('This vendor has no locations assigned. Add locations and works in Contractor/Vendor master.');
            } else {
                $('#location_vendor_hint').text('Locations and works reflect what this vendor is assigned in the vendor master.');
            }
            var locId = $loc.val();
            loadWorksForLocation(locId, preserveWorkId);
            selectedWorkId = '';
        }).fail(function() {
            $('#location_vendor_hint').text('Could not load vendor locations.');
        });
    }

    function recalcRow($row) {
        var q = parseFloat($row.find('.wo-qty').val()) || 0;
        var r = parseFloat($row.find('.wo-rate').val()) || 0;
        var amt = (q * r).toFixed(2);
        $row.find('.wo-amt').val(amt);
    }

    function recalcTotal() {
        var total = 0;
        $('#wo-details-tbody .wo-detail-row').each(function() {
            var q = parseFloat($(this).find('.wo-qty').val()) || 0;
            var r = parseFloat($(this).find('.wo-rate').val()) || 0;
            total += q * r;
        });
        $('#total_order_value_display').val(total.toFixed(2));
    }

    function renumberRows() {
        $('#wo-details-tbody .wo-detail-row').each(function(i) {
            $(this).find('.wo-sr').text(i + 1);
            $(this).find('input[name^="details["]').each(function() {
                var name = $(this).attr('name');
                if (!name) return;
                var newName = name.replace(/details\[\d+\]/, 'details[' + i + ']');
                $(this).attr('name', newName);
            });
        });
        var n = $('#wo-details-tbody .wo-detail-row').length;
        $('#wo-details-tbody .wo-remove-row').toggle(n > 1);
    }

    function refreshPreviewWoNumber(syncFyFromDate) {
        if (isEdit) return;
        var d = $('#order_date').val();
        if (!d) return;
        var data = {
            order_date: d,
            number_prefix: ($('#number_prefix').val() || 'GP')
        };
        if (!syncFyFromDate) {
            data.fiscal_year_label = $('#fiscal_year_label').val();
        }
        $.get(previewUrl, data, function(res) {
            $('#wo_number_display').val(res.work_order_number);
            if (syncFyFromDate && res.fiscal_year_label) {
                $('#fiscal_year_label').val(res.fiscal_year_label);
            }
        });
    }

    $(document).ready(function() {
        fillVendorFromSelect();
        $('#wo-details-tbody .wo-detail-row').each(function() {
            recalcRow($(this));
        });
        recalcTotal();

        $('#contractor_id').on('change', function() {
            fillVendorFromSelect();
            selectedWorkId = '';
            var cid = $(this).val();
            if (!cid) {
                vendorCache = { locations: [], works: [] };
                $('#location_id').empty().append('<option value="">Select Location...</option>');
                $('#work_id').empty().append('<option value="">Select Work...</option>');
                $('#location_id, #work_id').trigger('change');
                $('#location_vendor_hint').text('Choose a vendor first; locations and works come from the vendor master.');
                return;
            }
            loadVendorAssignments(cid, {});
        });

        $('#wo-details-tbody').on('input', '.wo-qty, .wo-rate', function() {
            var $row = $(this).closest('.wo-detail-row');
            recalcRow($row);
            recalcTotal();
        });

        $('#wo-add-row').on('click', function() {
            var idx = $('#wo-details-tbody .wo-detail-row').length;
            var html = '<tr class="wo-detail-row">' +
                '<td class="wo-sr">' + (idx + 1) + '</td>' +
                '<td><input type="text" class="form-control form-control-solid" name="details[' + idx + '][work_details]" required /></td>' +
                '<td><input type="number" class="form-control form-control-solid wo-qty" name="details[' + idx + '][quantity]" step="0.0001" min="0" required /></td>' +
                '<td><input type="text" class="form-control form-control-solid" name="details[' + idx + '][unit]" required /></td>' +
                '<td><input type="number" class="form-control form-control-solid wo-rate" name="details[' + idx + '][rate]" step="0.01" min="0" required /></td>' +
                '<td><input type="text" class="form-control form-control-solid wo-amt" readonly value="" /></td>' +
                '<td><button type="button" class="btn btn-sm btn-danger wo-remove-row"><i class="fas fa-trash"></i></button></td>' +
                '</tr>';
            $('#wo-details-tbody').append(html);
            renumberRows();
        });

        $('#wo-details-tbody').on('click', '.wo-remove-row', function() {
            $(this).closest('.wo-detail-row').remove();
            renumberRows();
            recalcTotal();
        });

        $('#location_id').on('change', function() {
            loadWorksForLocation($(this).val(), selectedWorkId);
            selectedWorkId = '';
        });

        var cidInit = $('#contractor_id').val();
        if (cidInit) {
            loadVendorAssignments(cidInit, { preserveLocationId: initialLocationId, preserveWorkId: selectedWorkId });
        } else {
            $('#location_vendor_hint').text('Choose a vendor first; locations and works come from the vendor master.');
        }

        $('#order_date').on('change', function() {
            refreshPreviewWoNumber(true);
        });
        if (!isEdit) {
            $('#number_prefix, #fiscal_year_label').on('input change', function() {
                refreshPreviewWoNumber(false);
            });
        }
    });
})();
</script>
@endsection
