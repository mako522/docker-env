@extends('layouts.layout')

@section('content')
<div class="container">
    <div class="jumbotron bg-white">
        <h3>時間選択</h3>

        <table class="table table-striped">
        <thead>
            <tr>
            <th>時間</th>
            <th>編集</th>
            <th>削除</th>
            </tr>
        </thead>
        <tbody>
            @foreach($times as $time)
                <tr>
                <td scope='col'>{{$time['time_name']}}</td>
                <td><a href="{{route('add.time',['id'=>$time['id']])}}" class="btn btn-primary">編集</a></td>
                <td>
                    <form action="{{ route('time.destroy', ['id'=>$time->id]) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">削除</button>
                    </form>
                </td>
                </tr>
            @endforeach
            
        </tbody>
        </table>

        <a href="{{route('add.time')}}" class="btn btn-warning">時間追加</a>
    </div>
</div>
@endsection