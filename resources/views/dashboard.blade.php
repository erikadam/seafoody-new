@extends('layouts.app')

@section('content')
  <h1 class="mb-4">Dashboard</h1>
  <div class="alert alert-info">
    Selamat datang, {{ Auth::user()->name }}!
  </div>
@endsection
