<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GstBillList;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\GstBillListStoreRequest;

class GstBillListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gstBillLists = GstBillList::latest()->get();
        return view('admin.gst-bill-list.index', compact('gstBillLists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.gst-bill-list.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GstBillListStoreRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = Auth::user()->id;
        
        GstBillList::create($data);
        
        return redirect()->route('gst-bill-lists.index')->with('success', 'GST Bill created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(GstBillList $gstBillList)
    {
        return view('admin.gst-bill-list.show', compact('gstBillList'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GstBillList $gstBillList)
    {
        return view('admin.gst-bill-list.edit', compact('gstBillList'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GstBillListStoreRequest $request, GstBillList $gstBillList)
    {
        $data = $request->validated();
        $data['updated_by'] = Auth::user()->id;
        
        $gstBillList->update($data);
        
        return redirect()->route('gst-bill-lists.index')->with('success', 'GST Bill updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GstBillList $gstBillList)
    {
        $gstBillList->delete();
        return redirect()->route('gst-bill-lists.index')->with('success', 'GST Bill deleted successfully.');
    }
}
