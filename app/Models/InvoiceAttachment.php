<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceAttachment extends Model
{
    protected $fillable = ['file_name',
    'invoice_number',
    'Created_by',
    'invoice_id'];
    public function invoices(){
        return $this->belongsTo(Invoice::class,'section_id');
    }
    use HasFactory;
}
