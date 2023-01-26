<?php

namespace App\Models;

use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    protected $fillable = ['section_name','description','created_by'];
    use HasFactory;
    public function invoices(){
        return $this->hasMany(Invoice::class);
    }
    public function products(){
        return $this->hasMany(Product::class);
    }
}
