<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubCategory extends Model
{
    use HasFactory;
    use Searchable;
    use SoftDeletes;

    protected $fillable = ['category_name', 'category_code', 'category_id'];

    protected $searchableFields = ['*'];

    protected $table = 'sub_categories';

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function surveys()
    {
        return $this->hasMany(Survey::class);
    }
}
