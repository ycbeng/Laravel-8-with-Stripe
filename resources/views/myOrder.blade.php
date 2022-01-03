@extends('layout')
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10">
        <br><br>
        <div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2>My Order</h2></div>
                    <div class="col-sm-4">                        
                    </div>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date time</th>                        
                        <th>Amount</th>
                    </tr>
                </thead>                         
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{$order->id}}</td>                        
                        <td>{{$order->created_at}}</td>                        
                        <td>{{$order->amount}}</td>                         
                    </tr>
                    @endforeach
                </tbody>    
            </table>
        </div>
        <a href="{{route('pdfReport')}}" class="btn btn-info btn-xs">Download Report</a>
    </div>
    <div class="col-sm-1"></div>    
</div>
@endsection