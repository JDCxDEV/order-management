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
          <h5 class="card-title">Update {{ $product->name }}</h5>
        </div>
        <form action="{{ route('products.update', $product->id) }}" method="post">
          <div class="card-body">
            @csrf
            @method("PUT")
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control @if($errors->first('name')) is-invalid @endif" value="{{ old("name", $product->name) }}" id="name" name="name">
              @if($errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
              @endif
            </div>
            <div class="form-group">
              <label for="image_link">Image Link</label>
              <input type="text" class="form-control @if($errors->first('image_link')) is-invalid @endif" value="{{ old("image_link", $product->image_link) }}" id="image_link" name="image_link">
              @if($errors->has('image_link'))
                <div class="invalid-feedback">{{ $errors->first('image_link') }}</div>
              @endif
            </div>
          </div>
          <div class="card-footer text-end">
            <a type="button" href="{{ route("products.index") }}" class="btn btn-secondary">Cancel</a> &nbsp;
            <a type="button" href="{{ route("products.delete", $product->id) }}" class="btn btn-danger">Delete</a> &nbsp;
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection