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
        <div class="d-flex justify-content-between">
          <form class="" action="{{ url('/invoice_form') }}" method="GET">
          <button class="btn my-3 btn-sm btn-outline-primary">
            Add Invoice
          </button>
          </form>
        </div>
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
                    <th scope="col">Payment Date</th>
                    <th scope="col">Product</th>
                    <th scope="col">Department</th>
                    <th scope="col">Discount</th>
                    <th scope="col">VAT Percentage</th>
                    <th scope="col">VAT Amount</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                    <th scope="col">Notes</th>
                    <th scope="col">Options</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ( $invoices as $invoice )
                  <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $invoice->invoice_number }}</td>
                    <td>{{ $invoice->invoice_Date }}</td>
                    <td>{{ $invoice->Due_date }}</td>
                    <td>{{ $invoice->Payment_Date }}</td>
                    <td>{{ $invoice->product }}</td>
                    <td><a href="{{ url("invoice_details/$invoice->id") }}">{{ $invoice->sections->section_name }}</a></td>
                    <td>{{ $invoice->Discount }}</td>
                    <td>{{ $invoice->Rate_VAT }}</td>
                    <td>{{ $invoice->Value_VAT }}</td>
                    <td>{{ $invoice->Total }}</td>
                    <td>{{ $invoice->Status }}</td>
                    <td>@if(!empty($invoice->note))<textarea  disabled style="resize:none ;overflow:scroll; background-color:#faf9f6" name="" id="" cols="15" rows="3">{{ $invoice->note }}</textarea>@endif</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                          Options
                        </button>
                        <ul class="dropdown-menu">
                          <li>
                            <form method="POST" action="{{ url("/invoice_archived_restore/$invoice->id") }}">
                            @csrf
                            @method('put')
                            <button class="dropdown-item" type="submit">Restore</button>
                            </form>
                          <li>
                            <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $invoice->id }}">
                              Delete
                            </button>
                        </li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                  <div class="modal fade" id="deleteModal{{ $invoice->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Invoice</h1>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ url("/invoice_archived_delete/$invoice->id") }}" method="POST" >
                        <div class="modal-body">
                            @csrf
                            @method('delete')
                            <p>Are You Sure You Want to Delete Invoice {{ $invoice->invoice_number }}?</p>
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
          </div>
      </div>
    </div>
 
</div>

</div>
@endsection