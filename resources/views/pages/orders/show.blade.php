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
        Orders Details
        <a href="{{ route("product-board") }}" class="btn btn-success"><i class="fa-solid fa-plus"></i> Create New Order</a>
      </h5>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <label>Customer Name: <span class="badge badge-info">{{ $order->customer->name() }}</span></label>
        </div>
        <div class="col-md-6">
          <label>Order Date & Time: <span class="badge badge-info">{{ $order->readable_created_at() }}</span></label>
        </div>
        <div class="col-md-6">
          <label>Transacted By: <span class="badge badge-info">{{ $order->transacted_by->name }}</span></label>
        </div>                
      </div>
      <hr />
      <div class="table-responsive">
        <h6>Order Items — Total Items <span class="badge badge-success">({{ $order->totalItems() }})</span></h6>
        <table class="table table-striped">
          <thead class="thead-dark">
            <tr>
              <th>Image</th>
              <th>Name</th>
              <th>Quantity</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($order->order_items as $item)
              <tr>
                <td>
                  <a href="{{ $item->product->image_link }}" target="_blank">
                  <img class="img-thumbnail" width="100" src="{{ $item->product->image_link }}" alt="{{ $item->product->name }}">
                </td>                
                <td>{{ $item->product->name }}</td>
                <td><span class="badge badge-primary">{{ $item->quantity }}</span></td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>  
</div>
@endsection