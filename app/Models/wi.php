<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class wi extends Model
{
    protected $table = 'wis';

    protected $fillable = [
        'nomer_wi',
        'nama_wi',
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
