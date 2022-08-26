<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SurveyResult extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'survey_result_condition',
        'survey_result_note',
        'survey_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'survey_results';

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
