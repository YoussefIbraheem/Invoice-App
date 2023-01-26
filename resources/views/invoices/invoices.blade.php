@extends('layouts.content')
@include('layouts.head')

  <!-- ======= Header ======= -->
  @include('layouts.header')
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  @include('layouts.sidebar')
@section('pageTitle')
Invoices
@endsection
@section('breadCrumb')
Invoices
@endsection

@section('content')
<div class="p-3 rounded-3">
  <div class="row">
    <div class="card">
      <div class="card-header pb-0">
        <h3 class="card-title  m-3">
          Invoices List
        </h3>
        <form action="{{ url('/invoice_form') }}" method="GET">
        <button class="btn my-3 btn-sm btn-outline-primary">
          Add Invoice
        </button>
        </form>
      </div>
      <div class="card-body">
        <div class="col-md-12">
          <table class="table table-striped">
              <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Invoice Number</th>
                    <th scope="col">Invoice Date</th>
                    <th scope="col">Allocation Date</th>
                    <th scope="col">Product</th>
                    <th scope="col">Department</th>
                    <th scope="col">Discount</th>
                    <th scope="col">VAT Percentage</th>
                    <th scope="col">VAT Amount</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                    <th scope="col">Notes</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ( $invoices as $invoice )
                  <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->invoice_Date }}</td>
                    <td>{{ $invoice->Due_date }}</td>
                    <td>{{ $invoice->product }}</td>
                    <td>{{ $invoice->sections->section_name }}</td>
                    <td>{{ $invoice->Discount }}</td>
                    <td>{{ $invoice->Rate_VAT }}</td>
                    <td>{{ $invoice->Value_VAT }}</td>
                    <td>{{ $invoice->Total }}</td>
                    <td>{{ $invoice->Status }}</td>
                    <td>@if(!empty($invoice->note))<textarea  disabled style="resize:none ;overflow:scroll; background-color:#faf9f6" name="" id="" cols="15" rows="3">{{ $invoice->note }}</textarea>@endif</td>
                  </tr>
                  @endforeach
                 
                
                </tbody>
            </table>
          </div>
      </div>
    </div>
 
</div>

</div>
@endsection