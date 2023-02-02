@extends('layouts.content')
@include('layouts.head')

  <!-- ======= Header ======= -->
  @include('layouts.header')
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  @include('layouts.sidebar')
@section('pageTitle')
    Update Invoice
@endsection
@section('breadCrumb')
    Invoices / Update Invoice
@endsection

@section('content')
<div class="row">

    <div class="col-md-4">
        @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach  ( $errors->all() as $error )
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        
        @endif
        @if (session()->has('invoice_update_success'))
        <div style="width:fit-content" class="alert alert-success">
            
            <p>{{ session()->get('invoice_update_success') }}</p>
            
        </div> 
        @endif 
        @if (session()->has('invoice_add_success'))
        <div style="width:fit-content" class="alert alert-success">
            
            <p>{{ session()->get('invoice_add_success') }}</p>
            
        </div> 
        @endif  
        @if (session()->has('invoice_delete_success'))
        <div style="width:fit-content" class="alert alert-success">
            
            <p>{{ session()->get('invoice_delete_success') }}</p>
        </div> 
        @endif  
      </div>
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header pb-0">
                <h4 class="card-title m-3">Update Invoice</h4>
            </div>
          
            <div class="card-body py-3">
                <form action="{{ url("/add_payment/$invoice->id") }}" method="POST" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    {{-- 1 --}}

                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">Invoice Number</label>
                            <input disabled value="{{ $invoice->invoice_number }}" type="text" class="form-control" id="inputName" name="invoice_number"
                                title="Please Insert Invoice Number" required>
                        </div>

                        <div class="col">
                            <label>Invoice Date</label>
                            <input disabled  value="{{ $invoice->invoice_Date }}" class="form-control fc-datepicker" name="invoice_Date" placeholder="YYYY-MM-DD"
                                type="date" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="col">
                            <label>Due Date</label>
                            <input disabled value="{{ $invoice->Due_date }}" class="form-control fc-datepicker" name="Due_date" placeholder="YYYY-MM-DD"
                                type="date" required>
                        </div>

                    </div>

                    {{-- 2 --}}
                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">Section</label>
                            <select disabled name="Section" id="Section" class="form-control SlectBox" onclick="console.log($(this).val())"
                                onchange="console.log('change is firing')">
                                <!--placeholder-->
                                <option value="{{ $invoice->section_id }}" selected hidden>{{ $invoice->sections->section_name }}</option>
                            </select>
                        </div>
                        <div class="col">
                            <label for="inputName" class="control-label">Products</label>
                            <select disabled  id="product" name="product" class="form-control">
                                <option selected hidden value="{{ $invoice->product }}">{{ $invoice->product }}</option>
                            </select>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">Allocation Amount</label>
                            <input disabled type="text" value="{{ $invoice->Amount_collection }}" class="form-control" id="inputName" name="Amount_collection"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        </div>
                    </div>


                    {{-- 3 --}}

                    <div class="row">

                        <div class="col">
                            <label for="inputName" class="control-label">Commission Amount</label>
                            <input disabled type="number" class="form-control form-control-lg" id="Amount_Commission"
                                name="Amount_Commission" value="{{ $invoice->Amount_Commission }}" title="Please Insert Commission Amount "
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                required>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">Discount</label>
                            <input disabled type="number" value="{{ $invoice->Discount }}" class="form-control form-control-lg" id="Discount" name="Discount"
                                title="Please Insert Discount"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                value=0 required>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">VAT Percentage</label>
                            <select disabled disabled name="Rate_VAT" id="Rate_VAT" class="form-control">
                                <!--placeholder-->
                                <option value="{{ $invoice->Rate_VAT }}" selected hidden>{{  $invoice->Rate_VAT }}</option>
                                <option value=" 5%">5%</option>
                                <option value="10%">10%</option>
                            </select>
                        </div>

                    </div>

                    {{-- 4 --}}

                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">VAT Value</label>
                            <input disabled type="text" value="{{ $invoice->Value_VAT }}" class="form-control" id="Value_VAT" name="Value_VAT" readonly>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">Total (inc. VAT)</label>
                            <input disabled value="{{ $invoice->Total }}" type="text" class="form-control" id="Total" name="Total" readonly>
                        </div>
                    </div>

                    {{-- 5 --}}
                    <div class="row">
                        <div class="col">
                            <label for="exampleTextarea">Notes</label>
                            <textarea disabled class="form-control" id="exampleTextarea" name="note" rows="3">{{ $invoice->note }}</textarea>
                        </div>
                    </div><br>
                    <br>
                    <div class="d-flex justify-content-around my-5">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">payment Date</label>
                            <input value="{{ date('Y-m-d') }}" id="dueDate" type="date" name="payment_date" class="form-control" >
                          </div>
                          <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <select class="form-control" name="payment_status">
                                <option selected hidden value="{{ $invoice->Status }}">{{ $invoice->Status }}</option>
                                <option value="Paid">Paid</option>
                                <option value="Partially Paid">Partially Paid</option>
                                <option value="Unpaid">Unpaid</option>
                            </select>
                          </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-outline-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
{{-- <script>
    $(document).ready(function() {
          $('select[name="Section"]').on('change', function() {
              var SectionId = $(this).val();
              if (SectionId) {
                  $.ajax({
                      url: "{{ URL::to('section') }}/" + SectionId,
                      type: "GET",
                      dataType: "json",
                      success: function(data) {
                          $('select[name="product"]').empty();
                          $.each(data, function(key, value) {
                              $('select[name="product"]').append('<option value="' +
                                  value + '">' + value + '</option>');
                          });
                      },
                  });
              } else {
                  console.log('AJAX load did not work');
              }
          });
      });
</script> --}}
