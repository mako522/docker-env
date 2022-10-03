@extends('layouts.layout')

@section('content')

    <main>
        <div class="container">
            <div class="jumbotron bg-white">
                <h1 class="text-center">商品情報</h1>
                <h3 class="my-4 text-center">
                    @if(isset($bread->bread_name))
                        {{ $bread->bread_name }}
                    @endif
                </h3>
                <div class="offset-sm-3">
                    
                    <p class="mt-4 mb-5">価格：
                        @if(isset($bread->price))
                            {{ $bread->price }}
                        @endif
                        円
                    </p>
                </div>

                {!! Form::open(['route' => ['addcart.get', 'class' => 'd-inline']]) !!}

                    {{-- 画面遷移時にPOST送信 session保存に使用 --}}
                    {{ Form::hidden('bread_id', $bread->id) }}
                    

                    <div class="form-row justify-content-center">
                        {!! Form::label('prodqty', '購入個数', ['class' => 'mt-1']) !!}
                        <div class="form-group col-sm-1">
                            <div class="ml-1">
                                <input type="number" name="product_quantity" class="form-control" id="prodqty" pattern="[1-9][0-9]*" min="1" required autofocus>
                            </div>
                        </div>
                        {!! Form::label('', '個', ['class' => 'mt-1 mr-3']) !!}
                        <div class="form-group">
                            {!! Form::submit('カートへ', ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>
                {!! Form::close() !!}

            </div>
        </div>
    </main>

@endsection