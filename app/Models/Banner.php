<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function rel_to_product_type(){
        return $this->belongsTo(Subcategory::class,'product_type');
    }
}
