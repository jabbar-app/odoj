<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Group $group)
    {
        return view('reports.create', compact('group'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'report_date' => 'required|date',
            'pj_odoj' => 'nullable|string|max:255',
            'pj_bersaksi' => 'nullable|string|max:255',
            'pj_nextday' => 'nullable|string|max:255',
        ]);

        $report = Report::create([
            'group_id' => $request->group_id,
            'report_date' => $request->report_date,
            'pj_odoj' => $request->pj_odoj,
            'pj_bersaksi' => $request->pj_bersaksi,
            'pj_nextday' => $request->pj_nextday,
        ]);

        return redirect()->route('entries.index', $report)->with('success', 'Report created successfully! Now you can add entries for this report.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}
