<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Subdepartment;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SubdepartmentStoreRequest;

class SubdepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subdepartments = Subdepartment::with('department')->latest()->get();
        return view('admin.subdepartment.index', compact('subdepartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::orderBy('name')->get();
        return view('admin.subdepartment.create', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubdepartmentStoreRequest $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subdepartments',
            'department_id' => 'required|exists:departments,id',
        ]);

        Subdepartment::create([
            'name' => $request->name,
            'department_id' => $request->department_id,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('sub-departments.index')
            ->with('success', 'Subdepartment created successfully.');
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
        $subdepartment = Subdepartment::findOrFail($id);
        $departments = Department::orderBy('name')->get();
        return view('admin.subdepartment.edit', compact('subdepartment', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:subdepartments,name,' . $id,
            'department_id' => 'required|exists:departments,id',
        ]);

        $subdepartment = Subdepartment::findOrFail($id);
        $subdepartment->update([
            'name' => $request->name,
            'department_id' => $request->department_id,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('sub-departments.index')
            ->with('success', 'Subdepartment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subdepartment $subdepartment)
    {
        try {
            $subdepartment->delete();
            return redirect()->route('sub-departments.index')->with('success', 'Subdepartment deleted.');
        } catch (\Exception $e) {
           dd($e->getMessage());
        }
        
    }
}
