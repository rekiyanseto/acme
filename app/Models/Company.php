<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['company_code', 'company_name', 'company_site_plan'];

    protected $searchableFields = ['*'];

    public function businessUnits()
    {
        return $this->hasMany(BusinessUnit::class);
    }
}
