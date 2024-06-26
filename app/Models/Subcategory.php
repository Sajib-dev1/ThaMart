<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcategory extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    function rel_to_cat(){
        return $this->belongsTo(Category::class,'category_id')->withTrashed();
    }
}
