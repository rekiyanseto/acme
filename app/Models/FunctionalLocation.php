<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FunctionalLocation extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'functional_location_name',
        'functional_location_code',
        'functional_location_site_plan',
        'business_unit_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'functional_locations';

    public function businessUnit()
    {
        return $this->belongsTo(BusinessUnit::class);
    }

    public function areas()
    {
        return $this->hasMany(Area::class);
    }
}
