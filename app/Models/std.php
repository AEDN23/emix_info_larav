<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class std extends Model
{
    protected $table = 'stds';

    protected $fillable = [
        'nomer_std',
        'nama_std',
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
