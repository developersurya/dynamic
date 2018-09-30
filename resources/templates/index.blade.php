@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Templates</div>

				<div class="panel-body">
				 @if ( !$templates->count() )
        			We have no templates
    			@else
       				<ul>
            			@foreach( $templates as $template )
                			<!--<li><a href="{{ route('templates.show', $template->slug) }}">{{ $template->name }}</a></li>-->
           				@endforeach
        			</ul>
			    @endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
