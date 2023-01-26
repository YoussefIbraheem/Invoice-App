@extends('layouts.content')
@include('layouts.head')

  <!-- ======= Header ======= -->
  @include('layouts.header')
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  @include('layouts.sidebar')
@section('pageTitle')
    Sections
@endsection
@section('breadCrumb')
Sections
@endsection

@section('content')

<div class="rounded-3 p-3">
  <div class="row">
     <div class="card">
      <h4 class="card-title m-3">Sections List</h4>
      <div class="card-header pb-0"> 
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
          @if (session()->has('section_update_success'))
          <div style="width:fit-content" class="alert alert-success">
              
              <p>{{ session()->get('section_update_success') }}</p>
              
          </div> 
          @endif 
          @if (session()->has('section_add_success'))
          <div style="width:fit-content" class="alert alert-success">
              
              <p>{{ session()->get('section_add_success') }}</p>
              
          </div> 
          @endif  
          @if (session()->has('section_delete_success'))
          <div style="width:fit-content" class="alert alert-success">
              
              <p>{{ session()->get('section_delete_success') }}</p>
              
          </div> 
          @endif  
      </div>
      <div class="col-md-12 ">
        <button   class="btn btn-sm  m-3  btn-outline-primary" type="button" data-bs-toggle="modal" data-bs-target="#addSection">Add Section</button>
      </div>
      </div>
    <div class="card-body  py-3">
      <div class="col-md-12">
        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Section Name</th>
                <th scope="col">Description</th>
                <th scope="col">Update</th>
                <th scope="col">Delete</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($sections as $section )
              <tr>
                <th scope="row">{{ $loop->iteration }}</th>
                <td>{{ $section->section_name }}</td>
                <td><textarea disabled style="resize:none ;overflow:scroll; background-color:#faf9f6" name="" id="" cols="30" rows="3">{{ $section->description }}</textarea></td>
                <td><button type="button" data-bs-toggle="modal" data-bs-target="#updateSection{{ $section->id }}" class="btn btn-sm btn-outline-info">Update</button></td>
                <td>
                  <form method="POST" action="{{ url("section_delete/$section->id") }}">
                    @csrf
                    @method('delete')
                  <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                  </form>
                </td>
              </tr>
              @endforeach
              
            </tbody>
          </table>
    </div>
    </div>
    
    </div>  
  </div>
  <div class="modal fade" id="addSection" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Add Section</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" action="{{ url('section_add') }}">
          @csrf
        <div class="modal-body">
          <div class="form-group p-3">
            <label for="section_name">
              Section Name
            </label>
            <input class="form-control" type="text" name="section_name" id="">
          </div>
          <div class="form-group p-3">
            <label for="section_name">
              Section Name
            </label>
            <textarea class="form-control" name="section_notes" id="" cols="30" rows="10"></textarea>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline-primary">Save changes</button>
        </div>
      </form>
      </div>
    </div>
  </div>
  @foreach ($sections as $section )
  <div class="modal fade" id="updateSection{{ $section->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Update Section</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" action="{{ url("section_update/$section->id") }}">
          @csrf
          @method('PUT')
        <div class="modal-body">
          <div class="form-group p-3">
            <label for="section_name">
              Section Name
            </label>
            <input value="{{ $section->section_name }}" class="form-control" type="text" name="section_name_update" id="">
          </div>
          <div class="form-group p-3">
            <label for="section_name">
              Section Name
            </label>
            <textarea class="form-control" name="section_notes_update" id="" cols="30" rows="10">{{ $section->description }}</textarea>
          </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-outline-primary">Save changes</button>
        </div>
      </form>
      </div>
    </div>
  </div>
  @endforeach
 
</div>
@endsection