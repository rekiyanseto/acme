<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubArea extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'sub_area_name',
        'sub_area_code',
        'sub_area_description',
        'sub_area_site_plan',
        'maintenance_by',
        'area_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'sub_areas';

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function equipments()
    {
        return $this->hasMany(Equipment::class);
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }

    public function maintenanceDocuments()
    {
        return $this->hasMany(MaintenanceDocument::class);
    }
}
