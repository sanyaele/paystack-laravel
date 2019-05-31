@extends('layouts.inner')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Input the OTP Code</div>

                <div class="card-body">
                    <form action="/pay/otp" method="post">
                        <div class="form-group">
                            <!-- <label for="account_number">Account Number</label> -->
                            <input class="form-control" id="otp" name="otp" type="text" placeholder="OTP">
                        </div>

                        <input type="hidden" name="transfer_code" id="transfer_code" value="{{ $transfer_code; }}">
                        <input type="submit" class="btn btn-success btn-block" value="Confirm OTP">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection