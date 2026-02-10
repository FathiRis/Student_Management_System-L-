@extends('app')
@push('page_title')
Student Register
@endpush
@push('page_head')
Student Registration form
@endpush
@push('side_head')
Admin
@endpush
@section('content')

<form>
  <div class="form-row">
    <div class="form-group col-md-8">
      <label for="inputEmail4">Student Name</label>
      <input type="text" class="form-control" id="name" placeholder="Name">
    </div>
    <div class="form-group col-md-4">
      <label for="inputPassword4">Mobile No</label>
      <input type="text" class="form-control" id="mobile no" placeholder="+94 77 123 4567">
    </div>
    <div class="form-group col-md-4">
      <label for="inputPassword4">Mobile No</label>
      <input type="text" class="form-control" id="mobile no" placeholder="+94 77 123 4567">
    </div>
  </div>
  <div class="form-group col-md-6">
    <label for="inputAddress">Address</label>
    <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
  </div>
  <div class="form-group col-md-6">
    <label for="inputAddress2">Address 2</label>
    <input type="text" class="form-control" id="inputAddress2" placeholder="Apartment, studio, or floor">
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">City</label>
      <input type="text" class="form-control" id="inputCity">
    </div>
    <div class="form-group col-md-4">
      <label for="inputState">State</label>
      <select id="inputState" class="form-control">
        <option selected>Choose...</option>
        <option>...</option>
      </select>
    </div>
    <div class="form-group col-md-2">
      <label for="inputZip">Zip</label>
      <input type="text" class="form-control" id="inputZip">
    </div>
  </div>
  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Check me out
      </label>
    </div>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection

            
          