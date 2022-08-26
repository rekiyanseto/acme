<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Photo extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['photo', 'remarks', 'survey_id'];

    protected $searchableFields = ['*'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
