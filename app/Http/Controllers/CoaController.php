<?php

namespace App\Http\Controllers;

use App\Models\coa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CoaController extends Controller
{
    /**
     * 1. Menampilkan daftar seluruh COA.
     */
    public function index()
    {
        $coas = coa::with(['departemen', 'creator'])->latest()->get();
        return view('coa.index', compact('coas'));
    }

    /**
     * 2. Menampilkan halaman form tambah data COA baru.
     */
    public function create()
    {
        $departemens = \App\Models\departemen::all();

        $lastCoa = coa::orderBy('id', 'desc')->first();
        if (!$lastCoa) {
            $nextNo = 'COA-001';
        } else {
            $lastNo = (int) str_replace('COA-', '', $lastCoa->nomer_coa);
            $nextNo = 'COA-' . str_pad($lastNo + 1, 3, '0', STR_PAD_LEFT);
        }

        return view('coa.create', compact('departemens', 'nextNo'));
    }

    /**
     * 3. Menyimpan data COA baru ke database.
     */
    public function store(Request $request)
    {
        // Re-generate nomer_coa on server side to ensure accuracy
        $lastCoa = coa::orderBy('id', 'desc')->first();
        if (!$lastCoa) {
            $nomer_coa = 'COA-001';
        } else {
            $lastNo = (int) str_replace('COA-', '', $lastCoa->nomer_coa);
            $nomer_coa = 'COA-' . str_pad($lastNo + 1, 3, '0', STR_PAD_LEFT);
        }

        $request->validate([
            'nama_coa' => 'required',
            'departemen_id' => 'required|exists:departemens,id',
            'tahun' => 'required',
            'file' => 'required|file|max:10000',
            'video' => 'nullable|file|max:100000',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $formattedNo = str_replace('-', '_', strtolower($nomer_coa));
            $fileName = $formattedNo . '_' . now()->format('d-m-Y') . '.' . $request->file('file')->getClientOriginalExtension();
            $filePath = $request->file('file')->storeAs('pdf/coa', $fileName, 'public');
        }

        $videoPath = '-';
        if ($request->hasFile('video')) {
            $formattedNo = str_replace('-', '_', strtolower($nomer_coa));
            $videoName = $formattedNo . '_' . now()->format('d-m-Y') . '.' . $request->file('video')->getClientOriginalExtension();
            $videoPath = $request->file('video')->storeAs('video/coa', $videoName, 'public');
        }

        coa::create([
            'nomer_coa' => $nomer_coa,
            'nama_coa' => $request->nama_coa,
            'departemen_id' => $request->departemen_id,
            'keterangan' => $request->keterangan ?? '-',
            'approve' => '0',
            'tahun' => $request->tahun,
            'file' => $filePath,
            'active' => '1',
            'video' => $videoPath,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('coa.index')->with('success', 'Data COA berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    /**
     * 4. Menampilkan detail data COA tertentu.
     */
    public function show(coa $coa)
    {
        $coa->load(['departemen', 'creator']);
        return view('coa.show', compact('coa'));
    }

    /**
     * 5. Menampilkan halaman form edit data COA tertentu.
     */
    public function edit(coa $coa)
    {
        $departemens = \App\Models\departemen::all();
        return view('coa.edit', compact('coa', 'departemens'));
    }

    /**
     * 6. Memperbarui data COA yang sudah ada di database.
     */
    public function update(Request $request, coa $coa)
    {
        $request->validate([
            'nomer_coa' => 'required|unique:coas,nomer_coa,' . $coa->id,
            'nama_coa' => 'required',
            'departemen_id' => 'required|exists:departemens,id',
            'tahun' => 'required',
            'file' => 'nullable|file|max:10000',
            'video' => 'nullable|file|max:100000',
        ]);

        $data = [
            'nomer_coa' => $request->nomer_coa,
            'nama_coa' => $request->nama_coa,
            'departemen_id' => $request->departemen_id,
            'keterangan' => $request->keterangan ?? '-',
            'tahun' => $request->tahun,
        ];

        if ($request->hasFile('file')) {
            $formattedNo = str_replace('-', '_', strtolower($request->nomer_coa));
            $fileName = $formattedNo . '_' . $coa->created_at->format('d-m-Y') . '.' . $request->file('file')->getClientOriginalExtension();
            $data['file'] = $request->file('file')->storeAs('pdf/coa', $fileName, 'public');
        }

        if ($request->hasFile('video')) {
            $formattedNo = str_replace('-', '_', strtolower($request->nomer_coa));
            $videoName = $formattedNo . '_' . $coa->created_at->format('d-m-Y') . '.' . $request->file('video')->getClientOriginalExtension();
            $data['video'] = $request->file('video')->storeAs('video/coa', $videoName, 'public');
        }

        $coa->update($data);

        return redirect()->route('coa.index')->with('success', 'Data COA berhasil diperbarui.');
    }

    /**
     * 7. Menghapus data COA dari database.
     */
    public function destroy(coa $coa)
    {
        // Hapus file PDF jika ada
        if ($coa->file && Storage::disk('public')->exists($coa->file)) {
            Storage::disk('public')->delete($coa->file);
        }

        // Hapus file Video jika ada (dan bukan '-')
        if ($coa->video && $coa->video !== '-' && Storage::disk('public')->exists($coa->video)) {
            Storage::disk('public')->delete($coa->video);
        }

        $coa->delete();
        return redirect()->route('coa.index')->with('success', 'Data COA dan file terkait berhasil dihapus.');
    }
}
