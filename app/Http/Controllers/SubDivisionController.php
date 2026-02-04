<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubDivision;
use App\Models\Division;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SubDivisionStoreRequest;

class SubDivisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subDivisions = SubDivision::with('division')->latest()->get();
        return view('admin.sub-division.index', compact('subDivisions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $divisions = Division::orderBy('name')->get();
        return view('admin.sub-division.create', compact('divisions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubDivisionStoreRequest $request)
    {
        SubDivision::create([
            'name' => $request->name,
            'division_id' => $request->division_id,
            'head_of_sub_division' => $request->head_of_sub_division,
            'address' => $request->address,
            'name_of_sub_div_head' => $request->name_of_sub_div_head,
            'head_mobile_number' => $request->head_mobile_number,
            'sub_div_contact_person_name' => $request->sub_div_contact_person_name,
            'contact_person_name' => $request->contact_person_name,
            'contact_person_mobile_number' => $request->contact_person_mobile_number,
            'remark' => $request->remark,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('sub-division.index')
            ->with('success', 'Sub Division created successfully.');
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
        $subDivision = SubDivision::findOrFail($id);
        $divisions = Division::orderBy('name')->get();
        return view('admin.sub-division.edit', compact('subDivision', 'divisions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubDivisionStoreRequest $request, string $id)
    {
        $subDivision = SubDivision::findOrFail($id);
        $subDivision->update([
            'name' => $request->name,
            'division_id' => $request->division_id,
            'head_of_sub_division' => $request->head_of_sub_division,
            'address' => $request->address,
            'name_of_sub_div_head' => $request->name_of_sub_div_head,
            'head_mobile_number' => $request->head_mobile_number,
            'sub_div_contact_person_name' => $request->sub_div_contact_person_name,
            'contact_person_name' => $request->contact_person_name,
            'contact_person_mobile_number' => $request->contact_person_mobile_number,
            'remark' => $request->remark,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('sub-division.index')
            ->with('success', 'Sub Division updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $subDivision = SubDivision::findOrFail($id);
        $subDivision->delete();
        return redirect()->route('sub-division.index')
            ->with('success', 'Sub Division deleted successfully.');
    }
}
