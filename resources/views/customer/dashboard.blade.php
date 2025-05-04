@extends('layouts.customer')

@section('content')
<h1 class="mb-4">Dashboard Customer</h1>
<div class="alert alert-info">
  Selamat datang, {{ Auth::user()->name }}!
</div>
@endsection

