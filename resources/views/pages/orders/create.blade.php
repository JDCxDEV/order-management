@extends('layouts.app')

@section('content')
<div class="container h-100 mt-3">
  <div class="row h-100">
    <product-board
    logged-in="{{ Auth::check("auth") ? 1: 0}}"
    ></product-board>
  </div>
</div>
@endsection