<div class="top-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <a href="/" class="logo"><img src="/assets/img/new/logo.png" alt="dynamicxx.com" > </a>
            </div>
            <div class="col-md-6">
                <ul class="dropdown top-nav">
                    @if(isset(Auth::user()->email))
                    <li> <span>Welcome: {{Auth::user()->email}}  &nbsp; </span>
                        <a  class="user" href="#"> <i class="fa fa-user"></i>  </a>
                        <ul class="dropdown-menu dropdown-menu-right" >
                            <li class="topangle"> </li>

                                <li class="account"><a href="#">account</a></li>
                                <li  class="template"><a href="#">my templates</a></li>
                                <li class="logout"><a href="{{url('/logout')}}">log out</a></li>
                        </ul>
                    </li>
                        @else
                        <li class="account"><a href="{{ url('/login') }}">login</a></li>
                    @endif
                </ul>
            </div>

        </div>
    </div>
</div>