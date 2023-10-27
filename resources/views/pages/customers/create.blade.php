@extends('layouts.app')

@section('content')
<div class="container h-100 mt-3">
  <div class="row h-100 justify-content-center align-items-center">
    <div class="col-12">
      @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif
      
      <div class="card">
        <div class="card-header">
          <h5 class="card-title">Add New Customer</h5>
        </div>
        <form action="{{ route('customers.store') }}" method="post">
          <div class="card-body">
            @csrf
            <div class="form-group">
              <label for="firstname">Firstname</label>
              <input type="text" class="form-control @if($errors->first('firstname')) is-invalid @endif" value="{{ old("firstname") }}" id="firstname" name="firstname">
              @if($errors->has('firstname'))
                <div class="invalid-feedback">{{ $errors->first('firstname') }}</div>
              @endif
            </div>
            <div class="form-group">
              <label for="lastname">Lastname</label>
              <input type="text" class="form-control @if($errors->first('lastname')) is-invalid @endif" value="{{ old("lastname") }}" id="lastname" name="lastname">
              @if($errors->has('lastname'))
                <div class="invalid-feedback">{{ $errors->first('lastname') }}</div>
              @endif
            </div>
            <div class="form-group">
              <label for="address">Address</label>
              <input type="text" class="form-control @if($errors->first('address')) is-invalid @endif" value="{{ old("address") }}" id="address" name="address">
              @if($errors->has('address'))
                <div class="invalid-feedback">{{ $errors->first('address') }}</div>
              @endif              
            </div>        
          </div>
          <div class="card-footer text-end">
            <a type="button" href="{{ route("customers.index") }}" class="btn btn-secondary">Cancel</a> &nbsp;
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection