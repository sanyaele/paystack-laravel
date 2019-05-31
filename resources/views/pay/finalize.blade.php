@extends('layouts.inner')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Your Payment is successful</div>

                <div class="card-body">
                    <img src="{{ asset('/images/success.gif') }}" alt="Success">
                    <div class="text-success">You have successfully paid this supplier. <a href="/home" target="_top">Click to Continue</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection