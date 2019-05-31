@extends('layouts.inner')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Pay {{ $supply->supplier->name }}</div>

                <div class="card-body">
                    <form action="add_pay" method="post">
                        <div class="form-group">
                            <!-- <label for="bank">Supplier Bank</label> -->
                            <select class="form-control" id="bank" name="bank">
                                <option>Bank</option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->code }}">{{ $bank->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <!-- <label for="account_number">Account Number</label> -->
                            <input class="form-control" id="account_number" name="account_number" type="text" placeholder="Account Number">
                        </div>
                        <div class="form-group">
                            <div id="account_confirm" class="font-weight-bold">
                                <img src="{{ asset('/images/load.gif') }}" alt="loading">
                            </div>
                        </div>
                        <div id="others">
                            
                            <div class="form-group">
                            <div class="input-group left-inner-addon"> 
                                <span>NGN</span>
                                <input type="number" value="{{ number_format($supply->amount, 2, '.', '') }}" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100" class="currency" id="amount" name="amount" />
                            </div>
                            </div>
                            <input type="hidden" name="supply" id="supply" value="{{ $supply->id }}">
                            <input type="hidden" name="account_name" id="account_name">
                            <input type="hidden" name="recipient_code" id="recipient_code">
                            <input type="hidden" name="supplier" id="supplier" value="{{ $supply->supplier->name }}">
                            <input type="hidden" name="reason" id="reason" value="Payment for supply">
                            
                        </div>
                        <input type="submit" class="btn btn-success btn-block" value="Pay Supplier">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/confirm_account.js') }}"></script>
@endsection