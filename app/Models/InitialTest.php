<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InitialTest extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = [
        'initial_test_tool',
        'initial_test_result',
        'initial_test_standard',
        'initial_test_note',
        'survey_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'initial_tests';

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }
}
