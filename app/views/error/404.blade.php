<?php
/**
 * login.blade.php 
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
@section('title') Erreur 404 @stop

{{-- Page specific CSS files --}}
{{-- {{ HTML::style('--Path to css--') }} --}}
@section('css')
@stop

{{-- Page specific JS files --}}
{{-- {{ HTML::script('--Path to js--') }} --}}
@section('scripts')
@stop

{{-- Page content --}}
@section('content')

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header text-danger"> Erreur 404 : Page inexistante sur le serveur</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-1">
            <i class="fa fa-warning fa-5x"></i> 
        </div>
        <div class="col-lg-11">
            <p class="text-danger">
                Impossible d'afficher la page que vous demandez. 
                Nous en sommes désolé !
            </p>
            <p class="text-danger">
                Nous faisons de nôtre mieux pour que cette page soit à nouveau disponible.
            </p>
            <p class="text-success">
              Peut-être souhaitez-vous aller à <a href="{{{ URL::to('/') }}}" >l'acceil de l'application</a>?
            </p>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /#page-wrapper -->

@stop

