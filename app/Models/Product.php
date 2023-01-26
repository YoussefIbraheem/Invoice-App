<?php

namespace App\Models;

use App\Models\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    protected $fillable = ['product_name','section_id','description'];
    use HasFactory;
    public function sections(){
        return $this->belongsTo(Section::class,'section_id');
    }
}
