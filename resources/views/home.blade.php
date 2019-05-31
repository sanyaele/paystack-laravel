@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Supplies</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table-hover col-md-12">
                        <thead>
                            <tr>
                                <th>Supplier</th>
                                <th>Item</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($supplies as $supply)
                            <tr>
                                <td>{{ $supply->supplier->name }}</td>
                                <td>{{ $supply->item }}</td>
                                <td>{{ $supply->status }}</td>
                                <td>N{{ number_format($supply->amount,0,".",",") }}</td>
                                <td>{{ $supply->created_at }}</td>
                                <td data-toggle="modal" data-target="#payModal"><a target="pay_frame" href="/pay/{{ $supply->id }}">pay</a></td>
                            <tr>
                        @empty
                            <tr>
                                <td colspan="6">No Supplies to display</td>
                            </tr>
                        @endforelse

                        {{ $supplies->links() }}
                            
                        </tbody>
                            
                        <table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Pay Modal-->
<div class="modal fade" id="payModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="payModalLabel">Pay Supplier</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        </div>
        <div class="modal-body">
        <iframe src="" name="pay_frame" id="pay_frame" frameborder="0"></iframe>
        </div>
        
    </div>
    </div>
</div>
@endsection
