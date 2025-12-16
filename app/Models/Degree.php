<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Degree extends Model
{
    protected $fillable = ['name'];

    public function prodis()
    {
        return $this->belongsToMany(Prodi::class, 'degree_prodi');
    }
}
