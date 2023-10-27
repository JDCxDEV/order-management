@extends('layouts.app')

@section('content')
<div class="container mt-3">
  @if(session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif
  <div class="card">
    <div class="card-header">
      <h5 class="d-flex justify-content-between align-items-center">
        Products List
        <a href="{{ route("products.create") }}" class="btn btn-success"><i class="fa-solid fa-plus"></i> Product</a>  
      </h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Image</th>
              <th scope="col">Name</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($products as $product)
              <tr>
                <td>
                  <a href="{{ $product->image_link }}" target="_blank">
                  <img class="img-thumbnail" width="100" src="{{ $product->image_link }}" alt="{{ $product->name }}">
                  </a>
                </td>
                <th scope="row">{{ $product->name }}</th>
                <td>
                  <a href="{{ route("products.show", $product->id) }}" data-toggle="tooltip" data-placement="top" title="Update" class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-pencil"></i>
                  </a>
                  &nbsp;
                  <a href="{{ route("products.delete", $product->id) }}" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger">
                    <i class="fa-solid fa-trash"></i>
                  </a>                  
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center">
          <div></div>
          {{ $products->links() }}
        </div>
      </div>
    </div>
  </div>  
</div>
@endsection