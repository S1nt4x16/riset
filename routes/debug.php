<?php

use Illuminate\Support\Facades\Route;
use App\Models\Question;

Route::get('/debug-questions', function () {
    return Question::select('id', 'section', 'text')->get();
});
