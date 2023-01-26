@extends('layouts.content')
@include('layouts.head')

  <!-- ======= Header ======= -->
  @include('layouts.header')
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  @include('layouts.sidebar')
@section('pageTitle')
    Products
@endsection
@section('breadCrumb')
Products
@endsection

@section('content')
<div class="rounded-3 p-3">
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <h4 class="card-title m-3">Products List</h4>
                    <div class="card-header pb-0">
                        <div class="d-flex justify-content-between">
                            
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
                                @if (session()->has('product_update_success'))
                                <div style="width:fit-content" class="alert alert-success">
                                    
                                    <p>{{ session()->get('product_update_success') }}</p>
                                    
                                </div> 
                                @endif 
                                @if (session()->has('product_add_success'))
                                <div style="width:fit-content" class="alert alert-success">
                                    
                                    <p>{{ session()->get('product_add_success') }}</p>
                                    
                                </div> 
                                @endif  
                                @if (session()->has('product_delete_success'))
                                <div style="width:fit-content" class="alert alert-success">
                                    
                                    <p>{{ session()->get('product_delete_success') }}</p>
                                    
                                </div> 
                                @endif  
                            </div>
                            <i class="mdi mdi-dots-horizontal text-gray"></i>
                        </div>
                        <div class="col-sm-6  col-md-4 col-xl-3">
                            <button type="button" class="btn m-3 btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addProduct">
                                Add Product
                              </button>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mg-b-0 text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Section</th>
                                        <th>Description</th>
                                        <th>Update</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products as $product )
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $product->product_name }}</td>
                                        <td>{{ $product->sections->section_name }}</td>
                                        <td> <textarea disabled style="resize:none ;overflow:scroll; background-color:#faf9f6" name="" id="" cols="30" rows="3">{{ $product->description }}</textarea></td>
                                        <td><button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateProduct{{ $product->id }}">
                                            Update
                                          </button></td>
                                    <td><form method="post" action="{{ url("product_delete/$product->id") }}">
                                      @csrf
                                      @method('delete')
                                      <button class="btn btn-sm btn-outline-danger">Delete</button>  
                                    </form></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form method="POST" action="{{ url('/product_add') }}">
                        @csrf
                    <div class="modal-body">
                        <label class="form-group" for="product_name">Product Name</label>
                        <input class=" form-control" name="product_name" id="product_name" type="text">
                        <label class="form-group" for="section_name">Section Name</label>
                        <select class="form-control" name="section_id" id="section_name">
                            <option hidden selected disabled value="">--select--</option>
                            @foreach ($sections as $section )
                            <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                            @endforeach
                        </select>
                        <label class="form-group" for="description">description</label>
                        <textarea class=" form-control" name="description" id="" cols="30" rows="10"></textarea>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-outline-primary">Save changes</button>
                    </div>
                </form>
                  </div>
                </div>
              </div>
            @foreach ($products as $product )
            <div class="modal fade" id="updateProduct{{ $product->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="{{ url("product_update/$product->id") }}">
                            @csrf
                            @method('PUT')
                            <label class="form-group" for="product_name">Product Name</label>
                            <input value="{{ $product->product_name }}" class=" form-control" name="product_name_update" id="product_name_update" type="text">
                            <label class="form-group" for="section_name">Section Name</label>
                            <select class="form-control" name="section_id_update" id="section_name_update">
                                <option hidden selected value="{{ $product->section_id }}">--Select--</option>
                                @foreach ($sections as $section )
                                <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                @endforeach
                            </select>
                            <label class="form-group" id="description_update" for="description_update">description</label>
                            <textarea class=" form-control" name="description_update" id="" cols="30" rows="10">{{ $product->description}}</textarea>
                           
                          
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-outline-primary" type="submit">Save changes</button>
                        <button class="btn ripple btn-outline-secondary" data-dismiss="modal" type="button">Close</button>
                    </div>
                 </form>
                  </div>
                </div>
              </div>
            @endforeach
            
        </div>
        
    </div>
</div>
@endsection