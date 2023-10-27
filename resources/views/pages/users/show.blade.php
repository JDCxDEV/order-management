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
          <h5 class="card-title">Update {{ $user->name }}</h5>
        </div>
        <form action="{{ route('users.update', $user->id) }}" method="post">
          <div class="card-body">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control @if($errors->first('name')) is-invalid @endif" 
              value="{{ old("name", $user->name) }}" id="name" name="name">
              @if($errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
              @endif
            </div>

            <div class="form-group">
              <label for="email">Email</label>
              <input type="text" class="form-control @if($errors->first('email')) is-invalid @endif" 
              value="{{ old("email", $user->email) }}" id="email" name="email">
              @if($errors->has('email'))
                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
              @endif
            </div>
            
            <div class="form-group">
              <label for="image_link">Image Link</label>
              <input type="text" class="form-control @if($errors->first('image_link')) is-invalid @endif" 
              value="{{ old("image_link", $user->image_link) }}" id="image_link" name="image_link">
              @if($errors->has('image_link'))
                <div class="invalid-feedback">{{ $errors->first('image_link') }}</div>
              @endif
            </div>            

            <div class="form-group">
              <label for="description">Description</label>
              <textarea class="form-control" rows="3" id="description" name="description">
              {{ old("description", $user->description) }}
              </textarea>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" @if(old("is_manager", $user->is_manager)) checked @endif id="is_manager" name="is_manager">
              <label class="form-check-label" for="is_manager">
                Manager
              </label>
            </div>       

          </div>
          <div class="card-footer text-end">
            <a type="button" href="{{ route("users.index") }}" class="btn btn-secondary">Cancel</a> &nbsp;
            @if ($user->id != Auth::user()->id)
              <a type="button" href="{{ route("users.delete", $user->id) }}" class="btn btn-danger">Delete</a> &nbsp;
            @endif
            <button type="submit" class="btn btn-primary">Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection