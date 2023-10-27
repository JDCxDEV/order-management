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
        Orders List
      </h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead class="thead-dark">
            <tr>
              <th>Customer</th>
              <th>Items</th>
              <th>Created By</th>
              <th>Created At</th>
              <th>Actions</th>              
            </tr>
          </thead>
          <tbody>
            @foreach ($orders as $order)
              <tr>
                <td>{{ $order->customer->name() }}</td>
                <td>
                  @foreach ($order->order_items as $item)
                    <li>{{ $item->product->name }} x {{ $item->quantity }}</li>
                  @endforeach
                </td>
                <td>{{ $order->transacted_by->name }}</td>
                <td>{{ $order->readable_created_at() }}</td>
                <td>
                  <a href="{{ route("orders.show", $order->id) }}" data-toggle="tooltip" data-placement="top" title="View" class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  &nbsp;
                  <a href="{{ route("orders.delete", $order->id) }}" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger">
                    <i class="fa-solid fa-trash"></i>
                  </a>                  
                </td>
              </tr>
            @endforeach
            @if (!count($orders))
              <tr><td colspan="5" align="center">No orders found</td></tr>
            @endif
          </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center">
          <div></div>
          {{ $orders->links() }}
        </div>
      </div>
    </div>
  </div>  
</div>
@endsection