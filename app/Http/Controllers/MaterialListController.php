<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MaterialList;
use App\Models\MaterialCategory;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MaterialListStoreRequest;

class MaterialListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materialLists = MaterialList::with('materialCategory')->latest()->get();
        return view('admin.material-list.index', compact('materialLists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $materialCategories = MaterialCategory::orderBy('name')->get();
        return view('admin.material-list.create', compact('materialCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MaterialListStoreRequest $request)
    {
        MaterialList::create([
            'material_category_id' => $request->material_category_id,
            'name' => $request->name,
            'unit' => $request->unit,
            'remark' => $request->remark,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('material-lists.index')
            ->with('success', 'Material List created successfully.');
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
        $materialList = MaterialList::findOrFail($id);
        $materialCategories = MaterialCategory::orderBy('name')->get();
        return view('admin.material-list.edit', compact('materialList', 'materialCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MaterialListStoreRequest $request, string $id)
    {
        $materialList = MaterialList::findOrFail($id);
        $materialList->update([
            'material_category_id' => $request->material_category_id,
            'name' => $request->name,
            'unit' => $request->unit,
            'remark' => $request->remark,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('material-lists.index')
            ->with('success', 'Material List updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $materialList = MaterialList::findOrFail($id);
        $materialList->delete();
        return redirect()->route('material-lists.index')
            ->with('success', 'Material List deleted successfully.');
    }
}
