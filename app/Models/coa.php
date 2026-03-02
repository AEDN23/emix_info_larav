<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class coa extends Model
{
    protected $table = 'coas';

    protected $fillable = [
        'nomer_coa',
        'nama_coa',
        'departemen_id',
        'keterangan',
        'approve',
        'tahun',
        'file',
        'active',
        'video',
        'created_by',
    ];

    public function departemen()
    {
        return $this->belongsTo(departemen::class, 'departemen_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
