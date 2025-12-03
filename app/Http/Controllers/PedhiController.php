<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pedhi;
use App\Models\Department;
use App\Models\Subdepartment;
use App\Models\Division;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PedhiStoreRequest;

class PedhiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedhi = Pedhi::with(['department', 'subdepartment', 'division'])->latest()->get();
        return view('admin.pedhi.index', compact('pedhi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.pedhi.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PedhiStoreRequest $request)
    {
        Pedhi::create([
            'name' => $request->name,
            'department_id' => $request->department_id,
            'subdepartment_id' => $request->subdepartment_id,
            'division_id' => $request->division_id,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('pedhi.index')
            ->with('success', 'Pedhi created successfully.');
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
        $pedhi = Pedhi::findOrFail($id);
        $departments = Department::orderBy('name')->get();
        $subdepartments = Subdepartment::where('department_id', $pedhi->department_id)->orderBy('name')->get();
        $divisions = Division::where('subdepartment_id', $pedhi->subdepartment_id)->orderBy('name')->get();
        return view('admin.pedhi.edit', compact('pedhi', 'departments', 'subdepartments', 'divisions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PedhiStoreRequest $request, string $id)
    {
        $pedhi = Pedhi::findOrFail($id);
        $pedhi->update([
            'name' => $request->name,
            'department_id' => $request->department_id,
            'subdepartment_id' => $request->subdepartment_id,
            'division_id' => $request->division_id,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('pedhi.index')
            ->with('success', 'Pedhi updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pedhi = Pedhi::findOrFail($id);
        $pedhi->delete();
        return redirect()->route('pedhi.index')
            ->with('success', 'Pedhi deleted successfully.');
    }

    /**
     * Get subdepartments by department ID (for AJAX)
     */
    public function getSubdepartments(Request $request)
    {
        $subdepartments = Subdepartment::where('department_id', $request->department_id)
            ->orderBy('name')
            ->get();
        
        return response()->json($subdepartments);
    }

    /**
     * Get divisions by subdepartment ID (for AJAX)
     */
    public function getDivisions(Request $request)
    {
        $divisions = Division::where('subdepartment_id', $request->subdepartment_id)
            ->orderBy('name')
            ->get();
        
        return response()->json($divisions);
    }
}
