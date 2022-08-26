<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Equipment extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'equipment_name',
        'equipment_code',
        'equipment_description',
        'maintenance_by',
        'sub_area_id',
    ];

    protected $searchableFields = ['*'];

    public function subArea()
    {
        return $this->belongsTo(SubArea::class);
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
