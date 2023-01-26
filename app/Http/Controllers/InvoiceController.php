<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\InvoiceDetails;
use App\Models\InvoiceAttachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::all();
        
        return view('invoices.invoices',compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function getProducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("Product_name", "id");
        return json_encode($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    $validation = $request->validate([
           'invoice_number'=>'required',
           'product'=>'required',
           'Section'=>'required',
           'Amount_Commission'=>'required',
           'Discount'=>'required',
           'Value_VAT'=>'required',
           'Rate_VAT'=>'required',
           'Total'=>'required',
    ]);

            Invoice::create([
            'invoice_number'=>$request->invoice_number,
            'invoice_Date'=>$request->invoice_Date,
            'Due_date'=>$request->Due_date,
            'product'=>$request->product,
            'section_id'=>$request->Section,
            'Amount_collection'=>$request->Amount_collection,
            'Amount_Commission'=>$request->Amount_Commission,
            'Discount'=>$request->Discount,
            'Value_VAT'=>$request->Value_VAT,
            'Rate_VAT'=>$request->Rate_VAT,
            'Total'=>$request->Total,
            'Status'=>"unpaid",
            'Value_Status'=>2,
            'note'=>$request->note,
            ]);
    
            $invoice_id = Invoice::latest()->first()->id;
            InvoiceDetails::create([
                'invoice_id'=>$invoice_id,
                'invoice_number'=>$request->invoice_number,
                'product'=>$request->product,
                'Section'=>$request->Section,
                'Status'=>"unpaid",
                'Value_Status'=>2,
                'note'=>$request->note,
                'user'=>(Auth::user()->name)
            ]);
    
            $picture = $request->validate([
                'pic'=>'file|mimes:png,jpg,jpeg,svg,pdf'
            ]);
            if(!empty($request->hasFile('pic'))){
                $picture['pic'] = Storage::putFile('attachments', $picture['pic']);
                InvoiceAttachment::create([
                    'file_name'=>$picture['pic'],
                    'invoice_number'=>$request->invoice_number,
                    'Created_by'=>Auth::user()->name,
                    'invoice_id'=>$invoice_id
                ]);
            }
            
            session()->flash('add_invoice_success',"Invoice added successfully");
            return redirect(url('/invoice_add'));
    
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function showInvoiceForm()
    {$sections = Section::all();
       return view('invoices.add_invoice',compact('sections'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
