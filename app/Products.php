<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $fillable = [
        "product_name",
        "notes",
        "section_id",
    ];
    public function section(){
        return $this->belongsTo('App\Sections');
    }
}
