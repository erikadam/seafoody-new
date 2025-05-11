@extends('layouts.customer')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">Edit Profil Toko</div>
                <div class="card-body">
                    <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <input type="text" name="name" value="{{ old('name', $user->name) }}">
                        <input type="text" name="store_address" value="{{ old('store_address', $user->store_address) }}">
                        <textarea name="store_description">{{ old('store_description', $user->store_description) }}</textarea>
                        <input type="file" name="store_logo">

                        <button type="submit">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
