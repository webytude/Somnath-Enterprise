<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DailyExpense;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DailyExpenseStoreRequest;

class DailyExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = DailyExpense::with('staff');
        
        // If logged in as staff, only show their expenses
        if (Auth::check() && Auth::user()->isStaff() && Auth::user()->staff) {
            $query->where('staff_id', Auth::user()->staff->id);
        }
        
        $expenses = $query->latest('date')->latest()->get();
        return view('admin.daily-expense.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // If logged in as staff, only show their own name
        if (Auth::check() && Auth::user()->isStaff() && Auth::user()->staff) {
            $staff = collect([Auth::user()->staff]);
        } else {
            $staff = Staff::orderBy('first_name')->get();
        }
        
        return view('admin.daily-expense.create', compact('staff'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DailyExpenseStoreRequest $request)
    {
        // If logged in as staff, force their staff_id
        $staffId = $request->staff_id;
        if (Auth::check() && Auth::user()->isStaff() && Auth::user()->staff) {
            $staffId = Auth::user()->staff->id;
        }
        
        DailyExpense::create([
            'staff_id' => $staffId,
            'date' => $request->date,
            'amount' => $request->amount,
            'description' => $request->description,
            'remark' => $request->remark,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('daily-expense.index')
            ->with('success', 'Daily expense created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $expense = DailyExpense::findOrFail($id);
        
        // If logged in as staff, check if they own this expense
        if (Auth::check() && Auth::user()->isStaff() && Auth::user()->staff) {
            if ($expense->staff_id != Auth::user()->staff->id) {
                abort(403, 'You can only edit your own expenses.');
            }
            $staff = collect([Auth::user()->staff]);
        } else {
            $staff = Staff::orderBy('first_name')->get();
        }
        
        return view('admin.daily-expense.edit', compact('expense', 'staff'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DailyExpenseStoreRequest $request, string $id)
    {
        $expense = DailyExpense::findOrFail($id);
        
        // If logged in as staff, check if they own this expense and force their staff_id
        $staffId = $request->staff_id;
        if (Auth::check() && Auth::user()->isStaff() && Auth::user()->staff) {
            if ($expense->staff_id != Auth::user()->staff->id) {
                abort(403, 'You can only update your own expenses.');
            }
            $staffId = Auth::user()->staff->id;
        }
        
        $expense->update([
            'staff_id' => $staffId,
            'date' => $request->date,
            'amount' => $request->amount,
            'description' => $request->description,
            'remark' => $request->remark,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('daily-expense.index')
            ->with('success', 'Daily expense updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $expense = DailyExpense::findOrFail($id);
        
        // If logged in as staff, check if they own this expense
        if (Auth::check() && Auth::user()->isStaff() && Auth::user()->staff) {
            if ($expense->staff_id != Auth::user()->staff->id) {
                abort(403, 'You can only delete your own expenses.');
            }
        }
        
        $expense->delete();
        return redirect()->route('daily-expense.index')
            ->with('success', 'Daily expense deleted successfully.');
    }
}
