@extends('layouts.content')
@include('layouts.head')

  <!-- ======= Header ======= -->
  @include('layouts.header')
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  @include('layouts.sidebar')
@section('pageTitle')
    Add Invoice
@endsection
@section('breadCrumb')
    Invoices / Add Invoice
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
                <h4 class="card-title m-3">Add Invoice</h4>
            </div>
          
            <div class="card-body py-3">
                <form action="{{ url('/invoice_add') }}" method="POST" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    {{-- 1 --}}

                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">Invoice Number</label>
                            <input type="text" class="form-control" id="inputName" name="invoice_number"
                                title="Please Insert Invoice Number" required>
                        </div>

                        <div class="col">
                            <label>Invoice Date</label>
                            <input class="form-control fc-datepicker" name="invoice_Date" placeholder="YYYY-MM-DD"
                                type="date" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="col">
                            <label>Due Date</label>
                            <input class="form-control fc-datepicker" name="Due_date" placeholder="YYYY-MM-DD"
                                type="date" required>
                        </div>

                    </div>

                    {{-- 2 --}}
                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">Section</label>
                            <select name="Section" id="Section" class="form-control SlectBox" onclick="console.log($(this).val())"
                                onchange="console.log('change is firing')">
                                <!--placeholder-->
                                <option value="" selected disabled>Select Section</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}"> {{ $section->section_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="inputName" class="control-label">Products</label>
                            <select id="product" name="product" class="form-control">
                            </select>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">Allocation Amount</label>
                            <input type="text" value="0" class="form-control" id="inputName" name="Amount_collection"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                        </div>
                    </div>


                    {{-- 3 --}}

                    <div class="row">

                        <div class="col">
                            <label for="inputName" class="control-label">Commission Amount</label>
                            <input type="number" class="form-control form-control-lg" id="Amount_Commission"
                                name="Amount_Commission" value="0" title="Please Insert Commission Amount "
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                required>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">Discount</label>
                            <input type="number" value="0" class="form-control form-control-lg" id="Discount" name="Discount"
                                title="Please Insert Discount"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                value=0 required>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">VAT Percentage</label>
                            <select name="Rate_VAT" id="Rate_VAT" class="form-control">
                                <!--placeholder-->
                                <option value="" selected disabled>VAT Amount</option>
                                <option value=" 5%">5%</option>
                                <option value="10%">10%</option>
                            </select>
                        </div>

                    </div>

                    {{-- 4 --}}

                    <div class="row">
                        <div class="col">
                            <label for="inputName" class="control-label">VAT Value</label>
                            <input type="text" class="form-control" id="Value_VAT" name="Value_VAT" readonly>
                        </div>

                        <div class="col">
                            <label for="inputName" class="control-label">Total (inc. VAT)</label>
                            <input type="text" class="form-control" id="Total" name="Total" readonly>
                        </div>
                    </div>

                    {{-- 5 --}}
                    <div class="row">
                        <div class="col">
                            <label for="exampleTextarea">Notes</label>
                            <textarea class="form-control" id="exampleTextarea" name="note" rows="3"></textarea>
                        </div>
                    </div><br>

                    <p class="text-danger">* Attachments Types pdf, jpeg ,.jpg , png </p>
                    <h5 class="card-title">Attachments</h5>

                    <div class="col-sm-12 col-md-12">
                        <input type="file" name="pic" class="dropify" accept=".pdf,.jpg, .png, image/jpeg, image/png"
                            data-height="70" />
                    </div><br>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">Save</button>
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
