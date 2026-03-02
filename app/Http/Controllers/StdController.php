<?php

namespace App\Http\Controllers;

use App\Models\std;
use App\Models\departemen;
use Illuminate\Http\Request;

class StdController extends Controller
{
    public function index()
    {
        $stds = std::with(['departemen', 'creator'])->latest()->get();
        return view('std.index', compact('stds'));
    }

    public function create()
    {
        $departemens = departemen::all();

        $lastStd = std::orderBy('id', 'desc')->first();
        if (!$lastStd) {
            $nextNo = 'STD-001';
        } else {
            $lastNo = (int) str_replace('STD-', '', $lastStd->nomer_std);
            $nextNo = 'STD-' . str_pad($lastNo + 1, 3, '0', STR_PAD_LEFT);
        }

        return view('std.create', compact('departemens', 'nextNo'));
    }

    public function store(Request $request)
    {
        // Re-generate nomer_std on server side to ensure accuracy
        $lastStd = std::orderBy('id', 'desc')->first();
        if (!$lastStd) {
            $nomer_std = 'STD-001';
        } else {
            $lastNo = (int) str_replace('STD-', '', $lastStd->nomer_std);
            $nomer_std = 'STD-' . str_pad($lastNo + 1, 3, '0', STR_PAD_LEFT);
        }

        $request->validate([
            'nama_std' => 'required',
            'departemen_id' => 'required|exists:departemens,id',
            'tahun' => 'required',
            'file' => 'required|file|max:10000',
            'video' => 'nullable|file|max:100000',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $formattedNo = str_replace('-', '_', strtolower($nomer_std));
            $fileName = $formattedNo . '_' . now()->format('d-m-Y') . '.' . $request->file('file')->getClientOriginalExtension();
            $filePath = $request->file('file')->storeAs('pdf/std', $fileName, 'public');
        }

        $videoPath = '-';
        if ($request->hasFile('video')) {
            $formattedNo = str_replace('-', '_', strtolower($nomer_std));
            $videoName = $formattedNo . '_' . now()->format('d-m-Y') . '.' . $request->file('video')->getClientOriginalExtension();
            $videoPath = $request->file('video')->storeAs('video/std', $videoName, 'public');
        }

        std::create([
            'nomer_std' => $nomer_std,
            'nama_std' => $request->nama_std,
            'departemen_id' => $request->departemen_id,
            'keterangan' => $request->keterangan ?? '-',
            'approve' => '0',
            'tahun' => $request->tahun,
            'file' => $filePath,
            'active' => '1',
            'video' => $videoPath,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('std.index')->with('success', 'Data Support Document berhasil ditambahkan.');
    }

    public function show(std $std)
    {
        $std->load(['departemen', 'creator']);
        return view('std.show', compact('std'));
    }

    public function edit(std $std)
    {
        $departemens = departemen::all();
        return view('std.edit', compact('std', 'departemens'));
    }

    public function update(Request $request, std $std)
    {
        $request->validate([
            'nomer_std' => 'required|unique:stds,nomer_std,' . $std->id,
            'nama_std' => 'required',
            'departemen_id' => 'required|exists:departemens,id',
            'tahun' => 'required',
            'file' => 'nullable|file|max:10000',
            'video' => 'nullable|file|max:100000',
        ]);

        $data = [
            'nomer_std' => $request->nomer_std,
            'nama_std' => $request->nama_std,
            'departemen_id' => $request->departemen_id,
            'keterangan' => $request->keterangan ?? '-',
            'tahun' => $request->tahun,
        ];

        if ($request->hasFile('file')) {
            $formattedNo = str_replace('-', '_', strtolower($request->nomer_std));
            $fileName = $formattedNo . '_' . $std->created_at->format('d-m-Y') . '.' . $request->file('file')->getClientOriginalExtension();
            $data['file'] = $request->file('file')->storeAs('pdf/std', $fileName, 'public');
        }

        if ($request->hasFile('video')) {
            $formattedNo = str_replace('-', '_', strtolower($request->nomer_std));
            $videoName = $formattedNo . '_' . $std->created_at->format('d-m-Y') . '.' . $request->file('video')->getClientOriginalExtension();
            $data['video'] = $request->file('video')->storeAs('video/std', $videoName, 'public');
        }

        $std->update($data);

        return redirect()->route('std.index')->with('success', 'Data Support Document berhasil diperbarui.');
    }

    public function destroy(std $std)
    {
        $std->delete();
        return redirect()->route('std.index')->with('success', 'Data Support Document berhasil dihapus.');
    }
}
