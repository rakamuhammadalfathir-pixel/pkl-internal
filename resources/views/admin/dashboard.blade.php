@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header">Data Transaksi</div>
                <div class="card-body">

                  @if(session('success'))
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                  @endif
                  <a href="{{ route('transaksi.create') }}" class="btn btn-primary">Add</a>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
