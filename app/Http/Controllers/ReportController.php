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
        // Ambil semua report dengan relasi group
        $reports = Report::with('group')->latest()->get();

        // Tampilkan view index dengan data reports
        return view('reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Group $group)
    {
        // Tampilkan view create dengan data group
        return view('reports.create', compact('group'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'report_date' => 'required|date',
            'pj_odoj' => 'nullable|string|max:255',
            'pj_bersaksi' => 'nullable|string|max:255',
            'pj_nextday' => 'nullable|string|max:255',
        ]);

        // Buat report baru
        $report = Report::create([
            'group_id' => $request->group_id,
            'report_date' => $request->report_date,
            'pj_odoj' => $request->pj_odoj,
            'pj_bersaksi' => $request->pj_bersaksi,
            'pj_nextday' => $request->pj_nextday,
        ]);

        // Redirect ke halaman entries dengan pesan sukses
        return redirect()->route('entries.index', $report)->with('success', 'Report created successfully! Now you can add entries for this report.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        // Ambil data report dengan relasi group dan entries
        $report->load('group', 'entries');

        // Tampilkan view show dengan data report
        return view('reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        // Ambil semua group untuk dropdown
        $groups = Group::all();

        // Tampilkan view edit dengan data report dan groups
        return view('reports.edit', compact('report', 'groups'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        // Validasi input
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'report_date' => 'required|date',
            'pj_odoj' => 'nullable|string|max:255',
            'pj_bersaksi' => 'nullable|string|max:255',
            'pj_nextday' => 'nullable|string|max:255',
        ]);

        // Update data report
        $report->update([
            'group_id' => $request->group_id,
            'report_date' => $request->report_date,
            'pj_odoj' => $request->pj_odoj,
            'pj_bersaksi' => $request->pj_bersaksi,
            'pj_nextday' => $request->pj_nextday,
        ]);

        // Redirect ke halaman show dengan pesan sukses
        return redirect()->route('reports.show', $report)->with('success', 'Report updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        // Hapus report
        $report->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('reports.index')->with('success', 'Report deleted successfully!');
    }
}
