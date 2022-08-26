<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SettlementByBusinessUnit extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'note',
        'spk_no',
        'progress',
        'photo',
        'condition',
        'survey_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'settlement_by_business_units';

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
