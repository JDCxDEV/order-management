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
        Customers List
        <a href="{{ route("customers.create") }}" class="btn btn-success"><i class="fa-solid fa-plus"></i> Customer</a>  
      </h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Address</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($customers as $customer)
              <tr>
                <th scope="row">{{ $customer->name() }}</th>
                <td>{{ $customer->address }}</td>
                <td>
                  <a href="{{ route("customers.show", $customer->id) }}" data-toggle="tooltip" data-placement="top" title="Update" class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-pencil"></i>
                  </a>
                  &nbsp;
                  <a href="{{ route("customers.delete", $customer->id) }}" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger">
                    <i class="fa-solid fa-trash"></i>
                  </a>                  
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center">
          <div></div>
          {{ $customers->links() }}
        </div>
      </div>
    </div>
  </div>  
</div>
@endsection