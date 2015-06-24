{{-- Page template --}}
@extends('templates.normal')

{{-- Page title --}}
@section('title') Modifier une zone de culture @endsection

{{-- Page specific CSS files --}}
{{-- {{ HTML::style('--Path to css--') }} --}}
@section('css')
{{ HTML::style('assets/css/plugins/jquery-gmaps-latlon-picker.css') }}
<style>
.entry:not(:first-of-type)
{
    margin-top: 10px;
}

.glyphicon
{
    font-size: 12px;
}
.datetimefrom
{
    
    
}

.datetimeto
{
    
    
}
</style> 
@endsection

{{-- Page specific JS files --}}
{{-- {{ HTML::script('--Path to js--') }} --}}
@section('scripts')
{{ HTML::script('assets/js/plugins/maps/jquery-gmaps-latlon-picker.js') }}
{{ HTML::script('assets/js/plugins/maps/moment.js') }}
{{ HTML::script('assets/js/plugins/maps/bootstrap-datetimepicker.js') }}
<script>
$(document).ready(function() 
{
    $(document).on('click', '.btn-add', function(e)
    {
       
        e.preventDefault();

        var controlForm = $('.controls');
            currentEntry = $(this).parents('.entry:first');
            newEntry = $(currentEntry.clone()).appendTo(controlForm);
 
        newEntry.find('input').val('');
        //Enable Date
        newEntry.find('#datetimefrom').datetimepicker({format: 'DD/MM/YYYY'});
        newEntry.find('#datetimeto').datetimepicker({format: 'DD/MM/YYYY'});
        
        newEntry.find('#datetimefrom').on("dp.change", function (e) {
            newEntry.find('#datetimeto').data("DateTimePicker").minDate(e.date);
        });
        newEntry.find('#datetimeto').on("dp.change", function (e) {
            newEntry.find('#datetimefrom').data("DateTimePicker").maxDate(e.date);
        });

        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span>');
            
    }).on('click', '.btn-remove', function(e)
    {
		$(this).parents('.entry:first').remove();

		e.preventDefault();
		return false;
	});
    
      $('#datetimefrom').datetimepicker({
                 
                format: 'DD/MM/YYYY'
            });
      $('#datetimeto').datetimepicker({
                 
                format: 'DD/MM/YYYY'
            });
       $("#datetimefrom").on("dp.change", function (e) {
            $('#datetimeto').data("DateTimePicker").minDate(e.date);
        });
        $("#datetimeto").on("dp.change", function (e) {
            $('#datetimefrom').data("DateTimePicker").maxDate(e.date);
        });
});

</script>
@endsection

{{-- Page content --}}
@section('content')

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Modifier la zone  {{ $culturezone->name }} </h1>
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
                              {{ Form::open(array('url' => URL::to('culturezone/update') , 'role' => 'form')) }}
                                <div class="form-group @if($errors->first('name') != '') has-error @endif">
                                    <label>Nom *</label>
                                    {{ Form::text('name', $culturezone->name, array('class' => 'form-control', 'autofocus' => '' ) ) }}
                                    {{ $errors->first('name', '<span class="error">:message</span>' ) }}
                                </div>
                               
                                <div class="form-group">
                                    <label>Longitude</label>
                                    {{ Form::text('longitude', $culturezone->longitude, array('class' => 'form-control gllpLongitude','readonly'=>'true')) }}
                                </div>
                                
                                   <div class="form-group">
                                    <label>Latitude</label>
                                    {{ Form::text('latitude', $culturezone->latitude, array('class' => 'form-control gllpLatitude','readonly'=>'true')) }}
                                </div>
                                
                                <div class="form-group">
                                    <label>Description</label>
                                    {{ Form::textarea('description', $culturezone->description, array('class' => 'form-control')) }}
                                </div>
                                
                                  <div class="control-group" id="fields">
            <label class="control-label" for="field1">Periode de Culture </label>
            <div class="controls"> 
                 
                    
                    @if (count($culturezone->CultureZonePeriods) > 0)
                        @foreach($culturezone->CultureZonePeriods as $periodkey => $periodvalue)
                                          
                            <div class="entry input-group col-xs-12">
                       <div class="row">
                            <div class="col-xs-4">
                                
                                {{ Form::select('cultureid[]', $cultures, $periodvalue->cultureid, array('class' => 'form-control' ) ) }}
                             </div>
                            <div class="col-xs-3">
                                 <div class='input-group date datetimefromclass' id='datetimefrom'>
                                    <input type='text' class="form-control" name="datefrom[]" value='{{ date("d/m/Y",strtotime($periodvalue->from))}}'' />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class='input-group date datetimetoclass' id='datetimeto'>
                                    <input type='text' class="form-control" name="dateto[]" value='{{ date("d/m/Y",strtotime($periodvalue->to))}}'' />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    	<span class="input-group-btn">
                            <button class="btn  @if(count($culturezone->CultureZonePeriods) == ($periodkey + 1)) btn-success btn-add @else btn-danger btn-remove @endif" type="button">
                                <span class="glyphicon @if(count($culturezone->CultureZonePeriods) == ($periodkey + 1)) glyphicon-plus @else glyphicon-minus @endif "></span>
                            </button>
                        </span>
                    </div>
                        @endforeach
            
                    @else
                        <div class="entry input-group col-xs-12">
                       <div class="row">
                            <div class="col-xs-4">
                                
                                {{ Form::select('cultureid[]', $cultures, Input::old('cultureid'), array('class' => 'form-control' ) ) }}
                             </div>
                            <div class="col-xs-3">
                                 <div class='input-group date datetimefromclass' id='datetimefrom'>
                                    <input type='text' class="form-control" name="datefrom[]" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col-xs-3">
                                <div class='input-group date datetimetoclass' id='datetimeto'>
                                    <input type='text' class="form-control" name="dateto[]"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    	<span class="input-group-btn">
                            <button class="btn btn-success btn-add" type="button">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </span>
                    </div>
                
                    @endif
            	     
               
            </div>
             <br>
            <small>Cliquer sur <span class="glyphicon glyphicon-plus gs"></span> pour ajouter une nouvelle p&eacute;riode</small>
             <br><br><br><br>
        </div>
                                
                                 {{ Form::hidden('id', $culturezone->id) }}
                                {{ Form::submit('Modifier', array('class'=>'btn btn-success')) }}
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