<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Survey extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'survey_period_id',
        'sub_area_id',
        'equipment_id',
        'sub_category_id',
    ];

    protected $searchableFields = ['*'];

    public function surveyPeriod()
    {
        return $this->belongsTo(SurveyPeriod::class);
    }

    public function subArea()
    {
        return $this->belongsTo(SubArea::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function settlements()
    {
        return $this->hasMany(Settlement::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function initialTests()
    {
        return $this->hasMany(InitialTest::class);
    }

    public function surveyResults()
    {
        return $this->hasMany(SurveyResult::class);
    }

    public function settlementByBusinessUnits()
    {
        return $this->hasMany(SettlementByBusinessUnit::class);
    }
}
