@extends('layouts.content')
@include('layouts.head')

  <!-- ======= Header ======= -->
  @include('layouts.header')
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  @include('layouts.sidebar')
@section('pageTitle')
    Dashboard
@endsection
@section('breadCrumb')
    Dashboard
@endsection

@section('content')
<div class="p-3 rounded-3">
    <div class="row">
     <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Default Tabs Justified</h5>

          <!-- Default Tabs -->
          <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
            <li class="nav-item flex-fill" role="presentation">
              <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-justified" type="button" role="tab" aria-controls="home" aria-selected="true">Invoice Details</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
              <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-justified" type="button" role="tab" aria-controls="profile" aria-selected="false">Payments</button>
            </li>
            <li class="nav-item flex-fill" role="presentation">
              <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-justified" type="button" role="tab" aria-controls="contact" aria-selected="false">Attachments</button>
            </li>
          </ul>
          <div class="tab-content pt-2" id="myTabjustifiedContent">
            <div class="tab-pane fade show active" id="home-justified" role="tabpanel" aria-labelledby="home-tab">
              <table class="table table-striped">
                <tbody>
                  <tr>
                    <th>Invoice Number</th>
                    <td>{{ $invoice->invoice_number }}</td>
                    <th>Payment Date</th>
                    <td>{{ $invoice->Payment_Date }}</td>
                    <th>Due Date</th>
                    <td>{{ $invoice->Due_date }}</td>
                    <th>Section</th>
                    <td>{{ $invoice->sections->section_name }}</td>
                  </tr>
                  <tr>
                    <th>Product</th>
                    <td>{{ $invoice->product }}</td>
                    <th>Allocation Amount</th>
                    <td>{{ $invoice->Amount_collection }}</td>
                    <th>Commission Amount</th>
                    <td>{{ $invoice->Amount_Commission }}</td>
                    <th>Discount</th>
                    <td>{{ $invoice->Discount }}</td>
                  </tr>
                  <tr>
                    <th>Tax Rate</th>
                    <td>{{ $invoice->Rate_VAT }}</td>
                    <th>Tax Value</th>
                    <td>{{ $invoice->Value_VAT }}</td>
                    <th>Total (incl. VAT)</th>
                    <td>{{ $invoice->Total }}</td>
                    <th>Status</th>
                    @if($invoice->Status == 'Unpaid')
                    <td class="text-danger">{{ $invoice->Status }}</td>
                    @elseif ($invoice->Status == 'Partially Paid')
                    <td class="text-warning">{{ $invoice->Status }}</td>
                    @else
                    <td class="text-success">{{ $invoice->Status }}</td>
                    @endif
                  </tr>
                  <tr>
                    <th>Notes</th>
                    <td>{{ $invoice->note }}</td>
                  </tr>
                  
                  

                </tbody>
              </table>
            </div>
            <div class="tab-pane fade" id="profile-justified" role="tabpanel" aria-labelledby="profile-tab">
              <table class="table">
                <thead>
                  <th>Invoice Number</th>
                  <th>Product Type</th>
                  <th>Section</th>
                  <th>Payment Status</th>
                  <th>Payment Date</th>
                  <th>Notes</th>
                  <th>Issuing Date</th>
                  <th>User</th>
                </thead>
                <tbody>
                  @foreach ($invoiceDetails as $singleInvoice)
                  <tr>
                    <td>{{ $singleInvoice->invoice_number }}</td>
                    <td>{{ $singleInvoice->product }}</td>
                    <td>{{ $invoice->sections->section_name }}</td>
                    @if($singleInvoice->Status == 'Unpaid')
                    <td class="text-danger">{{ $singleInvoice->Status }}</td>
                    @elseif ($singleInvoice->Status == 'Partially Paid')
                    <td class="text-warning">{{ $singleInvoice->Status }}</td>
                    @else
                    <td class="text-success">{{ $singleInvoice->Status }}</td>
                    @endif
                    <td>{{ $singleInvoice->Payment_Date }}</td>
                    <td>@if(!empty($singleInvoice->note))<textarea  disabled style="resize:none ;overflow:scroll; background-color:#faf9f6" name="" id="" cols="15" rows="3">{{ $singleInvoice->note }}</textarea>@endif</td>
                    <td>{{ $singleInvoice->created_at }}</td>
                    <td>{{ $singleInvoice->user }}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
           
            <div class="tab-pane fade" id="contact-justified" role="tabpanel" aria-labelledby="contact-tab">
              @if($errors->any())
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error )
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
                </div>
              @endif
              <form enctype="multipart/form-data" method="POST" action="{{ url("invoice_attachment_add/$invoice->id") }}" >
                @csrf
                <div class="mb-3 w-25">
                  <label for="formFile" class="form-label">Add Attachment</label>
                  <input class="form-control" name="attachment_file" type="file">
                </div>
                <button type="submit" class="btn btn-sm btn-outline-primary">Confirm</button>
              </form>
              @if(!empty($invoiceAttachment))
              <table class="table">
                <thead>
                  <th>File Name</th>
                  <th>Created By</th>
                  <th>Creation Date</th>
                  <th>Options</th>
                </thead>
                <tbody>
                  @foreach ( $invoiceAttachment as $file )
                  <tr>
                    <td>{{ basename($file->file_name) }}</td>
                    <td>{{ $file->Created_by }}</td>
                    <td>{{ $file->created_at }}</td>
                    <td><div class="dropdown">
                      <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                       Actions
                      </button>
                      <ul class="dropdown-menu">
                        <li><a href="{{ url("/get_file/$file->id") }}" class="dropdown-item">Show</a></li>
                        <li><a href="{{ url("/download_file/$file->id") }}" class="dropdown-item">Download</a></li>
                        <li>
                          <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteeModal{{ $file->id }}">
                            Delete
                          </button>
                        </li>
                      </ul>
                    </div>
                     
                      
                      
                    </td>
                  </tr>
                  <div class="modal fade" id="deleteeModal{{ $file->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Delete File</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
                        </div>
                        <form method="POST" action="{{ url("/delete_file/$file->id") }}">
                          @csrf
                          @method('delete')
                        <div class="modal-body">
                          Delete {{ basename($file->file_name) }}?
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-outline-danger">Delete</button>
                        </div>
                      </form>
                      </div>
                    </div>
                  </div>
                  @endforeach
                 
                </tbody>
              </table>
              @endif
            </div>
           
          </div><!-- End Default Tabs -->

        </div>
      </div>

     </div>
          </div>
          </div>
    
@endsection