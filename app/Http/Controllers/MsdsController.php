<?php

namespace App\Http\Controllers;

use App\Models\msds;
use App\Models\departemen;
use Illuminate\Http\Request;

class MsdsController extends Controller
{
    public function index()
    {
        $msds_list = msds::with(['departemen', 'creator'])->latest()->get();
        return view('msds.index', compact('msds_list'));
    }

    public function create()
    {
        $departemens = departemen::all();

        $lastMsds = msds::orderBy('id', 'desc')->first();
        if (!$lastMsds) {
            $nextNo = 'MSDS-001';
        } else {
            $lastNo = (int) str_replace('MSDS-', '', $lastMsds->nomer_msds);
            $nextNo = 'MSDS-' . str_pad($lastNo + 1, 3, '0', STR_PAD_LEFT);
        }

        return view('msds.create', compact('departemens', 'nextNo'));
    }

    public function store(Request $request)
    {
        // Re-generate nomer_msds on server side to ensure accuracy
        $lastMsds = msds::orderBy('id', 'desc')->first();
        if (!$lastMsds) {
            $nomer_msds = 'MSDS-001';
        } else {
            $lastNo = (int) str_replace('MSDS-', '', $lastMsds->nomer_msds);
            $nomer_msds = 'MSDS-' . str_pad($lastNo + 1, 3, '0', STR_PAD_LEFT);
        }

        $request->validate([
            'nama_msds' => 'required',
            'departemen_id' => 'required|exists:departemens,id',
            'tahun' => 'required',
            'file' => 'required|file|max:10000',
            'video' => 'nullable|file|max:100000',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $fileName = $nomer_msds . '_' . now()->format('d-m-Y') . '.' . $request->file('file')->getClientOriginalExtension();
            $filePath = $request->file('file')->storeAs('pdf/msds', $fileName, 'public');
        }

        $videoPath = '-';
        if ($request->hasFile('video')) {
            $videoName = $nomer_msds . '_' . now()->format('d-m-Y') . '.' . $request->file('video')->getClientOriginalExtension();
            $videoPath = $request->file('video')->storeAs('video/msds', $videoName, 'public');
        }

        msds::create([
            'nomer_msds' => $nomer_msds,
            'nama_msds' => $request->nama_msds,
            'departemen_id' => $request->departemen_id,
            'keterangan' => $request->keterangan ?? '-',
            'approve' => '0',
            'tahun' => $request->tahun,
            'file' => $filePath,
            'active' => '1',
            'video' => $videoPath,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('msds.index')->with('success', 'Data MSDS berhasil ditambahkan.');
    }

    public function show(msds $msds)
    {
        $msds->load(['departemen', 'creator']);
        return view('msds.show', compact('msds'));
    }

    public function edit(msds $msds)
    {
        $departemens = departemen::all();
        return view('msds.edit', compact('msds', 'departemens'));
    }

    public function update(Request $request, msds $msds)
    {
        $request->validate([
            'nomer_msds' => 'required|unique:msds,nomer_msds,' . $msds->id,
            'nama_msds' => 'required',
            'departemen_id' => 'required|exists:departemens,id',
            'tahun' => 'required',
            'file' => 'nullable|file|max:10000',
            'video' => 'nullable|file|max:100000',
        ]);

        $data = [
            'nomer_msds' => $request->nomer_msds,
            'nama_msds' => $request->nama_msds,
            'departemen_id' => $request->departemen_id,
            'keterangan' => $request->keterangan ?? '-',
            'tahun' => $request->tahun,
        ];

        if ($request->hasFile('file')) {
            $formattedNo = str_replace('-', '_', strtolower($request->nomer_msds));
            $fileName = $formattedNo . '_' . $msds->created_at->format('d-m-Y') . '.' . $request->file('file')->getClientOriginalExtension();
            $data['file'] = $request->file('file')->storeAs('pdf/msds', $fileName, 'public');
        }

        if ($request->hasFile('video')) {
            $formattedNo = str_replace('-', '_', strtolower($request->nomer_msds));
            $videoName = $formattedNo . '_' . $msds->created_at->format('d-m-Y') . '.' . $request->file('video')->getClientOriginalExtension();
            $data['video'] = $request->file('video')->storeAs('video/msds', $videoName, 'public');
        }

        $msds->update($data);

        return redirect()->route('msds.index')->with('success', 'Data MSDS berhasil diperbarui.');
    }

    public function destroy(msds $msds)
    {
        $msds->delete();
        return redirect()->route('msds.index')->with('success', 'Data MSDS berhasil dihapus.');
    }
}
