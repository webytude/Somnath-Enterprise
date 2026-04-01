<?php

namespace App\Http\Controllers;

use App\Http\Requests\WorkOrderStoreRequest;
use App\Models\Contractor;
use App\Models\WorkOrder;
use App\Services\WorkOrderNumberService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkOrderController extends Controller
{
    public function index()
    {
        $workOrders = WorkOrder::with(['contractor', 'location', 'work'])->latest()->get();

        return view('admin.work-order.index', compact('workOrders'));
    }

    public function create()
    {
        $contractors = Contractor::orderBy('pedhi')->get();
        $orderDate = Carbon::parse(old('order_date', now()->toDateString()));
        $defaultPrefix = old('number_prefix', 'GP');
        $defaultFy = old(
            'fiscal_year_label',
            WorkOrderNumberService::fiscalYearLabelForDate($orderDate)
        );
        $previewWorkOrderNumber = WorkOrderNumberService::previewNext($orderDate, $defaultPrefix, $defaultFy);

        return view('admin.work-order.create', compact('contractors', 'previewWorkOrderNumber', 'defaultPrefix', 'defaultFy'));
    }

    public function vendorAssignments(Contractor $contractor)
    {
        $contractor->load(['locations', 'works']);

        return response()->json([
            'locations' => $contractor->locations->sortBy('name')->values()->map(fn ($l) => [
                'id' => $l->id,
                'name' => $l->name,
            ]),
            'works' => $contractor->works->sortBy('name_of_work')->values()->map(fn ($w) => [
                'id' => $w->id,
                'name_of_work' => $w->name_of_work,
                'location_id' => $w->location_id,
            ]),
        ]);
    }

    public function previewNumber(Request $request)
    {
        $date = Carbon::parse($request->get('order_date', now()->toDateString()));
        $prefix = $request->get('number_prefix', 'GP');
        $fy = $request->get('fiscal_year_label');
        $fy = is_string($fy) && $fy !== '' ? $fy : null;

        return response()->json([
            'work_order_number' => WorkOrderNumberService::previewNext($date, $prefix, $fy),
            'fiscal_year_label' => $fy ?? WorkOrderNumberService::fiscalYearLabelForDate($date),
        ]);
    }

    public function store(WorkOrderStoreRequest $request)
    {
        $data = $request->validated();
        $details = $data['details'];
        unset($data['details']);

        $orderDate = Carbon::parse($data['order_date']);
        $number = WorkOrderNumberService::allocateNext(
            $orderDate,
            $data['number_prefix'],
            $data['fiscal_year_label']
        );

        $total = 0;
        $normalized = [];
        foreach ($details as $index => $row) {
            $qty = (float) $row['quantity'];
            $rate = (float) $row['rate'];
            $amount = round($qty * $rate, 2);
            $total += $amount;
            $normalized[] = [
                'sort_order' => $index,
                'work_details' => $row['work_details'],
                'quantity' => $qty,
                'unit' => $row['unit'],
                'rate' => $rate,
                'amount' => $amount,
            ];
        }

        $workOrder = WorkOrder::create([
            'work_order_number' => $number['work_order_number'],
            'number_prefix' => $number['number_prefix'],
            'fiscal_year_label' => $number['fiscal_year_label'],
            'sequence_number' => $number['sequence_number'],
            'order_date' => $data['order_date'],
            'contractor_id' => $data['contractor_id'],
            'subject' => $data['subject'] ?? null,
            'condition_text' => $data['condition_text'] ?? null,
            'total_order_value' => $total,
            'time_limit_for_work' => $data['time_limit_for_work'] ?? null,
            'payment_condition' => $data['payment_condition'] ?? null,
            'location_id' => $data['location_id'],
            'work_id' => $data['work_id'] ?? null,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        foreach ($normalized as $row) {
            $workOrder->details()->create($row);
        }

        return redirect()->route('work-orders.index')->with('success', 'Work order created successfully.');
    }

    public function show(WorkOrder $workOrder)
    {
        $workOrder->load(['contractor', 'location', 'work', 'details', 'vendorPayments']);

        return view('admin.work-order.show', compact('workOrder'));
    }

    public function edit(WorkOrder $workOrder)
    {
        $contractors = Contractor::orderBy('pedhi')->get();
        $workOrder->load('details');
        $previewWorkOrderNumber = $workOrder->work_order_number;
        $defaultPrefix = old('number_prefix', $workOrder->number_prefix ?? 'GP');
        $defaultFy = old('fiscal_year_label', $workOrder->fiscal_year_label);

        return view('admin.work-order.edit', compact('workOrder', 'contractors', 'previewWorkOrderNumber', 'defaultPrefix', 'defaultFy'));
    }

    public function update(WorkOrderStoreRequest $request, WorkOrder $workOrder)
    {
        $data = $request->validated();
        $details = $data['details'];
        unset($data['details']);

        $total = 0;
        $normalized = [];
        foreach ($details as $index => $row) {
            $qty = (float) $row['quantity'];
            $rate = (float) $row['rate'];
            $amount = round($qty * $rate, 2);
            $total += $amount;
            $normalized[] = [
                'sort_order' => $index,
                'work_details' => $row['work_details'],
                'quantity' => $qty,
                'unit' => $row['unit'],
                'rate' => $rate,
                'amount' => $amount,
            ];
        }

        $workOrder->update([
            'order_date' => $data['order_date'],
            'contractor_id' => $data['contractor_id'],
            'subject' => $data['subject'] ?? null,
            'condition_text' => $data['condition_text'] ?? null,
            'total_order_value' => $total,
            'time_limit_for_work' => $data['time_limit_for_work'] ?? null,
            'payment_condition' => $data['payment_condition'] ?? null,
            'location_id' => $data['location_id'],
            'work_id' => $data['work_id'] ?? null,
            'updated_by' => Auth::id(),
        ]);

        $workOrder->details()->delete();
        foreach ($normalized as $row) {
            $workOrder->details()->create($row);
        }

        return redirect()->route('work-orders.index')->with('success', 'Work order updated successfully.');
    }

    public function destroy(WorkOrder $workOrder)
    {
        $workOrder->delete();

        return redirect()->route('work-orders.index')->with('success', 'Work order deleted successfully.');
    }
}
