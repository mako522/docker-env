@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="jumbotron bg-white">
        <h3>時間編集</h3>
            <form action="{{ route('add.time')}}" method="post">
                @csrf
                <label for='amount'>追加項目</label>
                    <input type='text' class='form-control' name='time_name' value="{{old('time_name')}}"/>
                    <button type='submit' class='btn btn-primary w-25 mt-3'>編集</button>
                
            </form>
    </div>
</div>
@endsection