<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BusinessUnit extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'business_unit_name',
        'business_unit_code',
        'business_unit_site_plan',
        'company_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'business_units';

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function functionalLocations()
    {
        return $this->hasMany(FunctionalLocation::class);
    }
}
