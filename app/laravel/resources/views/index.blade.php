@extends('layouts.layout')
@section('js')
<script src="{{ asset('js/like.js') }}" defer></script>
@endsection
@section('content')
<link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('stylesheet')
<div class="container">
    <div class="row ml-5">
    
    <form method="get">
    <div class="input-group col-12 m-4">
    @foreach ($request as $key=>$value)
        @if ($key!="keyword")
            <input type="hidden" name="{{$key}}" value="{{$value}}" />
        @endif
    @endforeach
    <input type="text" class="form-control" name="keyword" class="form-control input-group-prepend" placeholder="キーワードを入力" value="{{$request["keyword"] ?? ""}}">
    <button type="submit" class = "btn btn-outline-primary">検索</button>
    </div>
    </form>

    
    <div class="col-4">
        <a href="{{route('new')}}">
            <button type='button' class='btn btn-outline-secondary m-4'>口コミを書く</button>
        </a>
    </div>
</div>
</div>

@foreach ($reviews as $review) 
  <div class="col-md-8 col-md-2 mx-auto">
    <div class="card-wrap">
      <div class="card">
        <div class="card-header align-items-center d-flex">
          
          <a class="black-color no-text-decoration" title="{{ $review->user->name }}" href="/users/{{ $review->user->id }}">
            <strong>{{ $review->user->name }}</strong>
          </a>
        </div>

        <a href="/users/{{ $review->user->id }}">
          <img src="/storage/post_images/{{ $review->id }}.jpg" class="card-img-top" />
        </a>
        
        <div class="card-body">
          <div class="row parts">
            <div id="like-icon-post-{{ $review->id }}">
            
            
            @if($like_model->like_exist(Auth::user()->id,$review->id))
              <p class="favorite-marke">
                <div class="js-like-toggle loved" href="" data-reviewid="{{ $review->id }}"><i class="fas fa-4x fa-heart"></i></div>
              </p>
              @else
              <p class="favorite-marke">
                <div class="js-like-toggle" href="" data-postid="{{ $review->id }}"><i class="fas fa-4x fa-heart"></i></div>
              </p>
              @endif​
              
            </div>
            <a class="comment" href="#"></a>
          </div>
          <div id="like-text-post-{{ $review->id }}">
          @include('like_text')
          </div>
          <div>
            <span><strong>{{ $review->user->name }}</strong></span>
            <span>{{ $review->caption }}</span>
          </div>
        </div>
      </div>
    </div>
</div>

@endforeach
@endsection

