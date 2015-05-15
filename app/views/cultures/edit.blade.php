{{-- Page template --}}
@extends('templates.normal')

{{-- Page title --}}
@section('title') Modifier une culture @endsection

{{-- Page specific CSS files --}}
{{-- {{ HTML::style('--Path to css--') }} --}}
@section('css')
@endsection

{{-- Page specific JS files --}}
{{-- {{ HTML::script('--Path to js--') }} --}}
@section('scripts')
@endsection

{{-- Page content --}}
@section('content')

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Modifier {{ $culture->name }} </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
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
                              {{ Form::open(array('url' => URL::to('culture/update') , 'role' => 'form')) }}
                                <div class="form-group @if($errors->first('name') != '') has-error @endif">
                                    <label>Nom *</label>
                                    {{ Form::text('name', $culture->name, array('class' => 'form-control', 'autofocus' => '' ) ) }}
                                    {{ $errors->first('name', '<span class="error">:message</span>' ) }}
                                </div>
                               
                                <div class="form-group">
                                    <label>Image</label>
                                    {{ Form::text('image', $culture->image, array('class' => 'form-control')) }}
                                </div>
                                
                                <div class="form-group">
                                    <label>Description</label>
                                    {{ Form::textarea('description', $culture->description, array('class' => 'form-control')) }}
                                </div>
                                 {{ Form::hidden('id', $culture->id) }}
                                {{ Form::submit('Modifier', array('class'=>'btn btn-primary')) }}
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
    </div>
    <!-- /.row -->

</div>
<!-- /#page-wrapper -->

@endsection