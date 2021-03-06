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
@extends('templates.normal')

{{-- Page title --}}
@section('title') Profile de l'utilisateur @stop

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

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Profile de <small>{{(isset($user->prenom)) ? $user->prenom : $user->Username}}</small>
                @if($user->UtilisateurID == Auth::user()->UtilisateurID)  
                <a href="{{ URL::to('profile/' . $user->UtilisateurID . '/edit') }}" class="btn btn-success pull-right">Modifier le porfile</a>
                @endif
            </h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Informations de base
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Login</label>
                                    <div class="col-lg-6">
                                        <p class="form-control-static">{{$user->Username}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Nom</label>
                                    <div class="col-lg-6">
                                        <p class="form-control-static">{{$user->nom}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Prénom</label>
                                    <div class="col-lg-6">
                                        <p class="form-control-static">{{$user->prenom}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Date de naissance</label>
                                    <div class="col-lg-6">
                                        <p class="form-control-static">{{$user->date_naissance}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Sexe</label>
                                    <div class="col-lg-6">
                                        <p class="form-control-static">{{$user->sexe}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Email</label>
                                    <div class="col-lg-6">
                                        <p class="form-control-static">{{$user->Mail}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Téléphone</label>
                                    <div class="col-lg-9">
                                        <p class="form-control-static">{{$user->telephone}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Adresse</label>
                                    <div class="col-lg-9">
                                        <p class="form-control-static">{{$user->adresse}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Ville</label>
                                    <div class="col-lg-9">
                                        <p class="form-control-static">{{$user->ville}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Pays</label>
                                    <div class="col-lg-9">
                                        <p class="form-control-static">{{$user->pays}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Fonction</label>
                                    <div class="col-lg-9">
                                        <p class="form-control-static">{{$user->fonction}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Société</label>
                                    <div class="col-lg-9">
                                        <p class="form-control-static">{{$user->societe}}</p>
                                    </div>
                                </div>
                            </form>
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
                    Photo
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="center-block">
                    @if(isset($user->photo))
                        <img src="{{ URL::to('profile/'. $user->UtilisateurID . '/photo/' . $user->photo) }}" alt="Photo" class="center-block img-responsive img-circle"/>
                    @else
                        <i class="fa fa-user fa-fw fa-5x"></i>
                    @endif
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- panel -->
            @if(Auth::user()->UtilisateurID == $user->UtilisateurID)
            <div class="panel panel-default">
                <div class="panel-heading">
                    Réseaux
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <tr>
                                <td style="vertical-align: middle;"><i class="fa fa-facebook-official fa-3x"></i></td>
                                <td style="vertical-align: middle;">Facebook</td>
                                <td style="vertical-align: middle;">{{$userProvider->facebookLogin}}</td>
                                <td style="vertical-align: middle;">
                                    <a href="{{URL::to('oauth/provider/facebook')}}" _target="_new">Associer</a>
                                    <a href="{{URL::to('oauth/provider/facebook/delete')}}">Dissocier</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="vertical-align: middle;"><i class="fa fa-google-plus fa-3x"></i></td>
                                <td style="vertical-align: middle;">Google</td>
                                <td style="vertical-align: middle;">{{$userProvider->googleLogin}}</td>
                                <td style="vertical-align: middle;">
                                    <a href="{{URL::to('oauth/provider/google')}}" _target="_new">Associer</a>
                                    <a href="{{URL::to('oauth/provider/google/delete')}}">Dissocier</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- panel -->
            @endif
        </div>
        <!-- /.col-lg-4 -->
    </div>
    
</div>
<!-- /#page-wrapper -->

@stop