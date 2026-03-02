<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class msds extends Model
{
    protected $table = 'msds';

    protected $fillable = [
        'nomer_msds',
        'nama_msds',
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
