<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Section;
use Illuminate\Http\Request;
use App\Models\InvoiceDetails;
use App\Models\InvoiceAttachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AddInvoiceNotification;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status = 'All')
    {
        if($status == 'All'){
            $invoices = Invoice::all();  
        }else{
            $invoices = Invoice::where('Status',$status)->get();
        }
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
            'note'=>$request->note,
            ]);
    
            $invoice_id = Invoice::latest()->first()->id;
            InvoiceDetails::create([
                'invoice_id'=>$invoice_id,
                'invoice_number'=>$request->invoice_number,
                'product'=>$request->product,
                'Section'=>$request->Section,
                'Status'=>"unpaid",
                'note'=>$request->note,
                'user'=>(Auth::user()->name)
            ]);
    
            $picture = $request->validate([
                'pic'=>'file|mimes:png,jpg,jpeg,svg,pdf'
            ]);
            if(!empty($request->hasFile('pic'))){
                $OriginalName = $request->pic->getClientOriginalName();
                $picture['pic'] = Storage::putFileAs("attachments/$request->invoice_number",$picture['pic'],$OriginalName);
                InvoiceAttachment::create([
                    'file_name'=>$picture['pic'],
                    'invoice_number'=>$request->invoice_number,
                    'Created_by'=>Auth::user()->name,
                    'invoice_id'=>$invoice_id
                ]);
            }
            $user = User::get();

            Notification::send($user,new AddInvoiceNotification($invoice_id));
            
            session()->flash('add_invoice_success',"Invoice added successfully");
            return redirect(url('/invoice_show/All'));
    
    
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

    public function showInvoiceUpdateForm($id){
        $invoice = Invoice::findOrFail($id);
        $sections = Section::all();
        return view('invoices.update_invoice',compact('invoice' , 'sections'));
    }

    public function showPaymentForm($id){
        $invoice = Invoice::findOrFail($id);
        $sections = Section::all();
        return view('invoices.add_payment',compact('invoice' , 'sections'));
    }

    public function changePaymentStatus(Request $request , $id){
        $data = $request->validate([
            'payment_status'=>'required',
            'payment_date'=>'required'
        ]);
        $invoice = Invoice::findOrFail($id);
        
       InvoiceDetails::create([
        'invoice_number'=>$invoice->invoice_number,
        'product'=>$invoice->product,
        'Section'=>$invoice->section_id,
        'Status'=>$request->payment_status,
        'Payment_Date'=>$request->payment_date,
        'note'=>$invoice->note,
        'user'=>Auth::user()->name,
        'invoice_id'=>$invoice->id
       ]);
       $invoice->update(['Status'=>$request->payment_status , 'Payment_Date'=>$request->payment_date]);

       return redirect(url('/invoice_show/All'));
        
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
    public function update(Request $request, $id)
    {
        $validation = $request->validate([
            'invoice_number'=>'required',
            'product'=>'required',
            'Section'=>'required',
            'Amount_Commission'=>'required',
            'Discount'=>'required',
            'Value_VAT'=>'required',
            'Rate_VAT'=>'required',
            'Total'=>'required',
     ]);

       $invoice = Invoice::findOrFail($id);
          
       $invoice->update([
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
             'note'=>$request->note,
             ]);
     
             $invoice_id = Invoice::latest()->first()->id;
             $invoice_details = InvoiceDetails::where('invoice_id',$invoice_id);
             $invoice_details->update([
                 'invoice_id'=>$invoice_id,
                 'invoice_number'=>$request->invoice_number,
                 'product'=>$request->product,
                 'Section'=>$request->Section,
                 'Status'=>"unpaid",
                 'note'=>$request->note,
                 'user'=>(Auth::user()->name)
             ]);
     
         
             session()->flash('add_invoice_success',"Invoice Updated successfully");
             return redirect(url('/invoice_show/All'));
    }

    public function showArchivedInvoices(){
        $invoices = Invoice::onlyTrashed()->get();
        return view('invoices.archived_invoice',compact('invoices'));
    }

    public function deleteArchivedInvoices($id){
        $invoice = Invoice::withTrashed()->find($id);
        $invoice_Attachment = InvoiceAttachment::where('invoice_id',$id)->get();
         if(!empty($invoice_Attachment)){
            foreach ($invoice_Attachment as $file) 
                Storage::Delete($file->file_name);
    }
          $invoice->forceDelete();
          return redirect()->back();
    }

    public function restoreArchivedInvoices($id){
        $invoice = Invoice::withTrashed()->find($id);
        $invoice->restore();
        return redirect()->back();
    }

    public function delete($id){
        $invoice = Invoice::findOrFail($id);
    $invoice->delete();
    return redirect()->back();
}

    public function printInvoice($id){
        $invoices = Invoice::findOrFail($id);
        return view('invoices.print_invoice',compact('invoices'));
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
