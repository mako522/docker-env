
@extends('layouts.layout')
@section('content')
<div class="card-header">
    
    <div style="width:700px;height:300px;background:#ced;border:1px solid #a7e;">スライド</div>
</div>

<div class="card-body">
    
    <div class="links">
        <p>Today's Bread</p>
        @foreach($products as $product)
        <p>{{$product->bread_name}}</p>
            
            <a href="{{ route('bread.detail',$product->id) }}">選択</a>
            
        @endforeach

    </div>
</div>
@endsection