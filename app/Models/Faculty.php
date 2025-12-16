<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = ['name'];

    public function prodis()
    {
        return $this->hasMany(Prodi::class);
    }
}
