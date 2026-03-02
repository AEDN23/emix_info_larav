<?php

namespace App\Http\Controllers;

use App\Models\wi;
use App\Models\departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WiController extends Controller
{

    /**
     * 1. Menampilkan daftar seluruh Work Instruction (WI).
     */
    public function index()
    {
        $wis = wi::with(['departemen', 'creator'])->latest()->get();
        return view('wi.index', compact('wis'));
    }


    /**
     * 2. Menampilkan halaman form tambah data Work Instruction (WI) baru.
     */

    public function create()
    {
        $departemens = departemen::all();

        $lastWi = wi::orderBy('id', 'desc')->first();
        if (!$lastWi) {
            $nextNo = 'WI-001';
        } else {
            $lastNo = (int) str_replace('WI-', '', $lastWi->nomer_wi);
            $nextNo = 'WI-' . str_pad($lastNo + 1, 3, '0', STR_PAD_LEFT);
        }

        return view('wi.create', compact('departemens', 'nextNo'));
    }


    /**
     * 3. Menyimpan data Work Instruction (WI) baru ke database.
     */
    public function store(Request $request)
    {
        // Re-generate nomer_wi on server side to ensure accuracy
        $lastWi = wi::orderBy('id', 'desc')->first();
        if (!$lastWi) {
            $nomer_wi = 'WI-001';
        } else {
            $lastNo = (int) str_replace('WI-', '', $lastWi->nomer_wi);
            $nomer_wi = 'WI-' . str_pad($lastNo + 1, 3, '0', STR_PAD_LEFT);
        }

        $request->validate([
            'nama_wi' => 'required',
            'departemen_id' => 'required|exists:departemens,id',
            'tahun' => 'required',
            'file' => 'required|file|max:10000',
            'video' => 'nullable|file|max:100000',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $formattedNo = str_replace('-', '_', strtolower($nomer_wi));
            $fileName = $formattedNo . '_' . now()->format('d-m-Y') . '.' . $request->file('file')->getClientOriginalExtension();
            $filePath = $request->file('file')->storeAs('pdf/wi', $fileName, 'public');
        }

        $videoPath = '-';
        if ($request->hasFile('video')) {
            $formattedNo = str_replace('-', '_', strtolower($nomer_wi));
            $videoName = $formattedNo . '_' . now()->format('d-m-Y') . '.' . $request->file('video')->getClientOriginalExtension();
            $videoPath = $request->file('video')->storeAs('video/wi', $videoName, 'public');
        }

        wi::create([
            'nomer_wi' => $nomer_wi,
            'nama_wi' => $request->nama_wi,
            'departemen_id' => $request->departemen_id,
            'keterangan' => $request->keterangan ?? '-',
            'approve' => '0',
            'tahun' => $request->tahun,
            'file' => $filePath,
            'active' => '1',
            'video' => $videoPath,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('wi.index')->with('success', 'Data Work Instruction berhasil ditambahkan.');
    }


    /**
     * 4. Menampilkan detail data Work Instruction (WI) tertentu.
     */
    public function show(wi $wi)
    {
        $wi->load(['departemen', 'creator']);
        return view('wi.show', compact('wi'));
    }


    /**
     * 5. Menampilkan halaman form edit data Work Instruction (WI) tertentu.
     */
    public function edit(wi $wi)
    {
        $departemens = departemen::all();
        return view('wi.edit', compact('wi', 'departemens'));
    }


    /**
     * 6. Memperbarui data Work Instruction (WI) yang sudah ada di database.
     */
    public function update(Request $request, wi $wi)
    {
        $request->validate([
            'nomer_wi' => 'required|unique:wis,nomer_wi,' . $wi->id,
            'nama_wi' => 'required',
            'departemen_id' => 'required|exists:departemens,id',
            'tahun' => 'required',
            'file' => 'nullable|file|max:10000',
            'video' => 'nullable|file|max:100000',
        ]);

        $data = [
            'nomer_wi' => $request->nomer_wi,
            'nama_wi' => $request->nama_wi,
            'departemen_id' => $request->departemen_id,
            'keterangan' => $request->keterangan ?? '-',
            'tahun' => $request->tahun,
        ];

        if ($request->hasFile('file')) {
            $formattedNo = str_replace('-', '_', strtolower($request->nomer_wi));
            $fileName = $formattedNo . '_' . $wi->created_at->format('d-m-Y') . '.' . $request->file('file')->getClientOriginalExtension();
            $data['file'] = $request->file('file')->storeAs('pdf/wi', $fileName, 'public');
        }

        if ($request->hasFile('video')) {
            $formattedNo = str_replace('-', '_', strtolower($request->nomer_wi));
            $videoName = $formattedNo . '_' . $wi->created_at->format('d-m-Y') . '.' . $request->file('video')->getClientOriginalExtension();
            $data['video'] = $request->file('video')->storeAs('video/wi', $videoName, 'public');
        }

        $wi->update($data);

        return redirect()->route('wi.index')->with('success', 'Data Work Instruction berhasil diperbarui.');
    }


    /**
     * 7. Menghapus data Work Instruction (WI) dari database.
     */
    public function destroy(wi $wi)
    {
        // Hapus file PDF jika ada
        if ($wi->file && Storage::disk('public')->exists($wi->file)) {
            Storage::disk('public')->delete($wi->file);
        }

        // Hapus file Video jika ada (dan bukan '-')
        if ($wi->video && $wi->video !== '-' && Storage::disk('public')->exists($wi->video)) {
            Storage::disk('public')->delete($wi->video);
        }

        $wi->delete();
        return redirect()->route('wi.index')->with('success', 'Data Work Instruction dan file terkait berhasil dihapus.');
    }
}
