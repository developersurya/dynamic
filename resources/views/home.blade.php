@extends('app')

@section('content')
    <div class="viewPort">
        @if(isset(Auth::user()->email))
        <div class="row">
            <div class="col-md-12 text-right undo-redo">
                <a href="#" class="redo" data-toggle="tooltip" title="REDO"> <img src="/assets/img/new/redo.png" alt=""  ></a>
                <a href="#" class="undo" data-toggle="tooltip" title="UNDO"> <img src="/assets/img/new/undo.png" alt=""  ></a>
            </div>
        </div>
        <iframe src=" {{base_path()}}/templates/Business/index.html"  class="template-load" width="100%" height="100%"></iframe>
    </div>
    @else
        <div class="row">
            <div class="col-md-12 text-center">
                <h3>Please login to access features.<br/>You can register <a href="{{url('/register')}}">here</a> for login detail.</h3>
            </div>
        </div>
    @endif
@endsection
