{{-- Page template --}}
@extends('templates.normal')

{{-- Page title --}}
@section('title') Ajouter une zone de culture @endsection

{{-- Page specific CSS files --}}
{{-- {{ HTML::style('--Path to css--') }} --}}
@section('css')

 {{ HTML::style('assets/css/plugins/jquery-gmaps-latlon-picker.css') }}
 
@endsection

{{-- Page specific JS files --}}
{{-- {{ HTML::script('--Path to js--') }} --}}
@section('scripts')

{{ HTML::script('assets/js/plugins/maps/jquery-gmaps-latlon-picker.js') }}
@endsection

{{-- Page content --}}
@section('content')

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Ajouter une zone de  culture </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                     Merci de remplir le formulaire ci-dessous
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            @if ( $errors->count() > 0 )
                                @foreach( $errors->all() as $message )
                                    <div class="alert alert-warning">
                                        {{$message}}
                                    </div>
                                @endforeach
                            @endif
                            {{ Form::open(array('url' => URL::to('culturezone/save') , 'role' => 'form')) }}
                                <div class="form-group @if($errors->first('name') != '') has-error @endif">
                                    <label>Nom *</label>
                                    {{ Form::text('name', Input::old('name'), array('class' => 'form-control', 'autofocus' => '' ) ) }}
                                    {{ $errors->first('name', '<span class="error">:message</span>' ) }}
                                </div>
                               
                                 <div class="form-group">
                                    <label>Longitude</label>
                                    {{ Form::text('longitude',  '2.107531', array('class' => 'form-control gllpLongitude','readonly'=>'true')) }}
                                </div>
                                
                                   <div class="form-group">
                                    <label>Latitude</label>
                                    {{ Form::text('latitude',  '13.525120', array('class' => 'form-control gllpLatitude','readonly'=>'true')) }}
                                </div>
                                
                                <div class="form-group">
                                    <label>Description</label>
                                    {{ Form::textarea('description', Input::old('description'), array('class' => 'form-control')) }}
                                </div>
                                
                                {{ Form::submit('Enregistrer', array('class'=>'btn btn-primary')) }}
                                {{ link_to(URL::previous(), 'Annuler', ['class' => 'btn btn-default']) }}
                            {{ Form::close() }}
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- panel -->
        </div>
        <!-- /.col-lg-4 -->
         <!-- /.col-lg-4 -->
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Localisation Geographique
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                             <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
                              
                                   <fieldset class="gllpLatlonPicker">
		 
		<div class="gllpMap">Google Maps</div>
		<br/>
		 
	 <input type="hidden" class="gllpZoom" value="9"/>
		 
		<br/>
	</fieldset>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- panel -->
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /#page-wrapper -->

@endsection