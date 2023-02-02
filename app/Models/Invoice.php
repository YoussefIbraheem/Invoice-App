<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Invoice extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'invoice_number',
        'invoice_Date',
        'Due_date',
        'product',
        'section_id',
        'Amount_collection',
        'Amount_Commission',
        'Discount',
        'Value_VAT',
        'Rate_VAT',
        'Total',
        'Status',
        'note',
        'Payment_Date',
    ];
    use HasFactory;
    public function sections(){
        return $this->belongsTo(Section::class,'section_id');
    }
    public function invoiceDetails(){
        return $this->hasOne(InvoiceDetails::class , 'invoice_id', 'id');
    }
    public function invoiceAttachment(){
        return $this->hasOne(InvoiceAttachment::class , 'invoice_id', 'id');
    }
}
