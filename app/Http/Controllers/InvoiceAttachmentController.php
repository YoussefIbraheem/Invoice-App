<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceAttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request , $id)
    {
         $validation = $request->validate([
             'attachment_file'=>'required|file|mimes:png,jpg,jpeg,pdf,svg'
         ]);
         $invoiceData = InvoiceDetails::findOrFail($id);
         $OriginalName = $request->attachment_file->getClientOriginalName();
         $validation['attachment_file'] = Storage::putFileAs("attachments/$invoiceData->invoice_number",$validation['attachment_file'],$OriginalName);
        InvoiceAttachment::create([
            'file_name'=>$validation['attachment_file'],
            'invoice_number'=> $invoiceData->invoice_number,
            'Created_by'=>Auth::user()->name,
            'invoice_id'=> $invoiceData->invoice_id
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoiceAttachment  $invoiceAttachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceAttachment $invoiceAttachment)
    {
        //
    }

    public function getFile($id){
        $location = "app/".InvoiceAttachment::findOrFail($id)->file_name;
        $file = storage_path()."/".$location ;
        return response()->file($file);
    }

    public function downloadFile($id){
        $location = "app/".InvoiceAttachment::findOrFail($id)->file_name;
        $file = storage_path()."/".$location ;
        return response()->download($file);
    }

    public function deleteFile($id){
        $data = InvoiceAttachment::findOrFail($id);
        $data->delete();
        Storage::delete($data->file_name);
        return redirect()->back();
    }
}
