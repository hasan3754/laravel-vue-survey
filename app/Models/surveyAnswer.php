<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class surveyAnswer extends Model
{
    use HasFactory;

    const CREATED_AT = NULL;
    CONST UPDATED_AT = NULL;

    protected $fillable = ['survey_id', 'start_date', 'end_date'];
}
