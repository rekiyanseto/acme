<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MaintenanceDocument extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'document_name',
        'document_remarks',
        'document_file',
        'sub_area_id',
        'equipment_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'maintenance_documents';

    public function subArea()
    {
        return $this->belongsTo(SubArea::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
