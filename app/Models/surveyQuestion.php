<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class surveyQuestion extends Model
{
    use HasFactory;
    protected $fillable = ['question', 'data', 'type', 'survey_id', 'description'];

    public function survey() {
        return $this->belongsTo(Survey::class);
    }

}
