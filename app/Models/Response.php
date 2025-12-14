<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    protected $fillable = ['respondent_code'];

    public function answers()
    {
        return $this->hasMany(Answer::class, 'response_id', 'id');
    }   

}
