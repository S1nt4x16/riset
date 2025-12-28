<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['key', 'section', 'text', 'description', 'type', 'options'];

    protected $casts = [
        'options' => 'array',
    ];

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
