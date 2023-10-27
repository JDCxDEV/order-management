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
        Users List
        <a href="{{ route("users.create") }}" class="btn btn-success"><i class="fa-solid fa-plus"></i> User</a>  
      </h5>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead class="thead-dark">
            <tr>
              <th scope="col">Image</th>
              <th scope="col">Name</th>
              <th scope="col">Email</th>
              <th scope="col">Manager</th>              
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($users as $user)
              <tr>
                <td>
                  <a href="{{ $user->image_link }}" target="_blank">
                    <img class="img-thumbnail" width="100" src="{{ $user->image_link }}" alt="{{ $user->name }}">
                  </a>                  
                </td>                
                <th scope="row">{{ $user->name }}</th>
                <td>{{ $user->email }}</td>
                <td>
                  @if ($user->is_manager)
                    <span class="badge badge-primary">Yes</span>
                  @else
                    <span class="badge badge-danger">No</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route("users.show", $user->id) }}" data-toggle="tooltip" data-placement="top" title="Update" class="btn btn-sm btn-primary">
                    <i class="fa-solid fa-pencil"></i>
                  </a>
                  &nbsp;

                  @if ($user->id != Auth::user()->id)               
                    <a href="{{ route("users.delete", $user->id) }}" data-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger">
                      <i class="fa-solid fa-trash"></i>
                    </a>
                  @endif
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
        <div class="d-flex justify-content-between align-items-center">
          <div></div>
          {{ $users->links() }}
        </div>
      </div>
    </div>
  </div>  
</div>
@endsection