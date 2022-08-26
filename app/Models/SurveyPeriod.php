<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SurveyPeriod extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'periode_name',
        'periode_description',
        'periode_status',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'survey_periods';

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }
}
