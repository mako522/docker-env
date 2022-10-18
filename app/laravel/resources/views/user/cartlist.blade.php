@extends('layouts.layout')

@section('content')

    <main>

        <div class="container">
            <div class="row">
                <div class="col-12 card border-dark mt-5">
                    <div class="cord-body ml-3 mb-2">
                        
                        <h4 class="mt-4">注文者</h4>
                            <p class="mb-2" style="padding-left: 20px;">
                                
                            </p>
                            
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <table class="table mt-5 ml-3 border-dark">
                    <thead>
                        <tr class="text-center">
                            <th class="border-bottom border-dark" style="width:13%;">No</th>
                            <th class="border-bottom border-dark" style="width:18%;">商品名</th>
                            <th class="border-bottom border-dark" style="width:15%;">値段</th>
                            <th class="border-bottom border-dark" style="width:15%;">個数</th>
                            <th class="border-bottom border-dark" style="width:15%;">小計</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($cartData as $key => $data)
                            
                                <tr class="text-center">
                                    <th class="align-middle">{{ $key += 1 }}</th>
                                    <td class="align-middle">
                                        {{ $data['bread_name'] }}
                                    </td>
                                    <td class="align-middle">
                                        {{ number_format($data['price']) }} 円
                                    </td>
                                    <td class="align-middle">
                                        <button type="button" class="btn btn-outline-dark">
                                            {{ $data['session_quantity'] }}
                                        </button>
                                        個
                                    </td>
                                    <td class="align-middle">
                                        {{ number_format($data['session_quantity'] * $data['price']) }} 円
                                    </td>

                                    <td class="border-0 align-middle">
                                        {!! Form::open(['route' => ['itemRemove', 'method' => 'post', $data['session_products_id']]]) !!}
                                            {{ Form::submit('削除', ['name' => 'delete_products_id', 'class' => 'btn btn-danger']) }}
                                            {{ Form::hidden('product_id', $data['session_products_id']) }}
                                            {{ Form::hidden('product_quantity', $data['session_quantity']) }}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach

                            <tr class="text-center">
                                <th class="border-bottom-0 align-middle"></th>
                                <td class="border-bottom-0 align-middle"></td>
                                <td class="border-bottom-0 align-middle"></td>
                                <td class="border-bottom-0 align-middle">合計</td>
                                @php
                                    $totalPrice = number_format(array_sum(array_column($cartData, 'itemPrice')))
                                @endphp
                                    <td class="border-bottom-0 align-middle">
                                        {{ $totalPrice }}円
                                    </td>
                            </tr>
                            <tr class="text-center">
                                <th class="border-bottom-0 align-middle"></th>
                                <td class="border-bottom-0 align-middle"></td>
                                <td class="border-bottom-0 align-middle"></td>
                                <td class="border-bottom-0 align-middle"></td>
                                <td class="border-bottom-0 align-middle">
                                <div class="form-group">
                                {!! Form::open(['route' => ['orderFinalize', 'method' => 'post', $data['session_products_id']]]) !!}
                                <label for="time_name">{{ __('受け取り時間選択') }}</label>
                                <select class="form-control" id="category-id" name="time_name">
                                @foreach ($times as $time)
                                    <option value="{{ $time->time_name }}">{{ $time->time_name }}</option>
                                @endforeach
                                </select>
                            </div>
                            </th>
                            </tr>

                        <tr class="text-right">
                            <th class="border-0"></th>
                            <td class="border-0">
                                <a class="btn btn-success" href="{{ url('/') }}" role="button">
                                    買い物を続ける
                                </a>
                            </td>
                            <td class="border-0"></td>
                            <td class="border-0"></td>
                            <td class="border-0">
                                
                                    {{ Form::submit('注文を確定する', ['name' => 'orderFinalize', 'class' => 'btn btn-primary']) }}
                                {!! Form::close() !!}
                            </td>
                            <td class="border-0 align-middle"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

@endsection