<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Area extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'area_name',
        'area_code',
        'area_site_plan',
        'functional_location_id',
    ];

    protected $searchableFields = ['*'];

    public function functionalLocation()
    {
        return $this->belongsTo(FunctionalLocation::class);
    }

    public function subAreas()
    {
        return $this->hasMany(SubArea::class);
    }
}
