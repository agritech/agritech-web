<?php
/**
 * view.blade.php 
 * {File description}
 * 
 * @author defus
 * @created Nov 13, 2014
 * 
 */
?>
{{-- Page template --}}
@extends('templates.login')

{{-- Page title --}}
@section('title') Créer votre compte utilisateur (agriculteur) @stop

{{-- Page specific CSS files --}}
{{-- {{ HTML::style('--Path to css--') }} --}}
@section('css')
<!-- DataTables CSS -->
{{ HTML::style('assets/css/plugins/dataTables.bootstrap.css') }}
@stop

{{-- Page specific JS files --}}
{{-- {{ HTML::script('--Path to js--') }} --}}
@section('scripts')
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
$(document).ready(function() {
    
});
</script>
@stop

{{-- Page content --}}
@section('content')

<div class="container">
    <div class="row" style="margin-top:10%">
        <div class="col-md-6 hidden-sm hidden-xs">
            <div class="jumbotron" >
                <h1 class="text-center" style="margin-top: 10%">AGRITECH</h1>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a href="{{ URL::to('/') }}">
                            <img src="{{ URL::to('/') }}/assets/images/agritech-logo.png" alt="AGRITECH" />
                        </a>
                    </div>
                </div>
                <p class="lead text-center">Plateforme d'échange entre les agriculteurs, les acheteurs et les pouvoirs publiques</p>
            </div>
        </div>
        <div class="col-md-6 visible-xs-block visible-sm-block">
            <img src="{{ URL::to('/') }}/assets/images/agritech-logo.png" class="img-responsive center-block" alt="AGRITECH" />
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Agriculteur ? Créer votre compte
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
                            {{ Form::open(array('url' => URL::to('register') , 'role' => 'form', 'class' => 'form-horizontal')) }}
                                <div class="form-group @if($errors->first('email') != '')) has-error @endif">
                                    <label class="col-lg-3 control-label">Email *</label>
                                    <div class="col-lg-9">
                                        {{ Form::text('email', Input::old('email'), array('class' => 'form-control', 'placeholder' => "email") ) }}
                                        {{ $errors->first('email', '<span class="error">:message</span>' ) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Nom</label>
                                    <div class="col-lg-9">
                                        {{ Form::text('nom', Input::old('nom'), array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Prénom</label>
                                    <div class="col-lg-9">
                                        {{ Form::text('prenom', Input::old('prenom'), array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Téléphone</label>
                                    <div class="col-lg-9">
                                        {{ Form::text('telephone', Input::old('telephone'), array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                <div class="form-group @if($errors->first('password') != '')) has-error @endif">
                                    <label class="col-lg-3 control-label">Mot de passe *</label>
                                    <div class="col-lg-9">
                                        {{ Form::password('password', array('class' => 'form-control')) }}
                                        {{ $errors->first('password', '<span class="error">:message</span>' ) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Vérifier le mot de passe *</label>
                                    <div class="col-lg-9">
                                        {{ Form::password('password_confirmation', array('class' => 'form-control')) }}
                                    </div>
                                </div>
                                {{ Form::submit('Nous rejoindre !', array('class'=>'btn btn-success btn-block')) }}
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
</div>
<!-- /#container -->

@stop