<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class departemen extends Model
{
    protected $fillable = [
        'nama_departemen',
        'deskripsi',
    ];

    public function coas()
    {
        return $this->hasMany(coa::class);
    }
    public function msds()
    {
        return $this->hasMany(msds::class);
    }
    public function stds()
    {
        return $this->hasMany(std::class);
    }
    public function wis()
    {
        return $this->hasMany(wi::class);
    }
}
