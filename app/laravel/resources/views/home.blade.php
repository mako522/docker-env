
@extends('layouts.layout')
@section('content')
<div class="card-header">
    
    <div style="width:700px;height:300px;background:#ced;border:1px solid #a7e;">スライド</div>
</div>
<div class="card-body">
    
    <div class="links">
        <p>Today's Bread</p>
        <p>パン１</p>
            @foreach($products as $product)
                <a href="/product/detail/{{$product->id}}">選択</a>
                <p>パン２</p>
                <a href="">選択</a>
                <p>パン３</p>
                <a href="">選択</a>
            @endforeach
            <form id="logout-form" action="" method="POST" style="display: none;">
                @csrf
            </form>
        
    </div>
</div>
@endsection