<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    protected $fillable = ['invoice_number','product','Section','Payment_Date','note','user','invoice_id','Status'];
    use HasFactory;
    public function invoices(){
        $this->belongsTo(invoices::class);
    }
}
