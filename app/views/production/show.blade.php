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
@extends('templates.normal')

{{-- Page title --}}
@section('title') Consulter une production @stop

{{-- Page specific CSS files --}}
{{-- {{ HTML::style('--Path to css--') }} --}}
@section('css')
{{ HTML::style('assets/select2-3.5.2/select2.css') }}
{{ HTML::style('assets/select2-3.5.2/select2-bootstrap.css') }}
{{ HTML::style('assets/jquery-ui-1.11.2/themes/base/all.css') }}
@stop

{{-- Page specific JS files --}}
{{-- {{ HTML::script('--Path to js--') }} --}}
@section('scripts')
{{ HTML::script('assets/select2-3.5.2/select2.min.js') }}
{{ HTML::script('assets/select2-3.5.2/select2_locale_fr.js') }}
{{ HTML::script('assets/jQuery-Mask-Plugin-1.11.2/dist/jquery.mask.min.js') }}
{{ HTML::script('assets/jquery-ui-1.11.2/ui/core.js') }}
{{ HTML::script('assets/jquery-ui-1.11.2/ui/widget.js') }}
{{ HTML::script('assets/jquery-ui-1.11.2/ui/datepicker.js') }}
{{ HTML::script('assets/jquery-ui-1.11.2/demos/datepicker/datepicker-fr.js') }}
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
            <h1 class="page-header">Consulter les informations de la production <a href="{{ URL::to('negociationproduction/' . $production->ProductionID . '/create') }}" class="btn btn-success pull-right">Proposez un prix</a></h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    COnsultation des informations sur la production
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Success-Messages -->
                            {{ Form::model($production, array('route' => array('production.update', $production->ProductionID), 'method' => 'put', 'role' => 'form', 'class' => 'form-horizontal')) }}
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Campagne agricole</label>
                                    <div class="col-lg-9">
                                    <p class="form-control-static">{{$production->CampagneAgricole->Nom}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Agriculteur</label>
                                    <div class="col-lg-9">
                                        <p class="form-control-static">{{$production->Agriculteur->nom . ' ' . $production->Agriculteur->prenom}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Exploitation</label>
                                    <div class="col-lg-9">
                                        <p class="form-control-static">{{$production->Exploitation->Ref . ' ' . $production->Exploitation->Nom}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Produit</label>
                                    <div class="col-lg-9">
                                        <p class="form-control-static">{{$production->Produit->Ref . ' ' . $production->Produit->Nom}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Poids</label>
                                    <div class="col-lg-9">
                                        <p class="form-control-static">{{$production->Poids}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Date de soumission</label>
                                    <div class="col-lg-9">
                                        <p class="form-control-static">{{$production->datesoumission_f}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Statut de la production</label>
                                    <div class="col-lg-9">
                                        <p class="form-control-static">{{$production->StatutSoumission}}</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-3 control-label">Canal de soumission de la production</label>
                                    <div class="col-lg-9">
                                        <p class="form-control-static">{{$production->CanalSoumission}}</p>
                                    </div>
                                </div>
                                <div class="col-lg-offset-3 col-lg-9">
                                {{ link_to(URL::previous(), 'Annuler', ['class' => 'btn btn-default']) }}
                                </div>
                            {{ Form::close() }}
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- panel -->
        </div>
        <!-- /.col-lg-6 -->
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Liste des prix proposés par des acheteurs pour la production
                    <div class="pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                Actions
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu pull-right" role="menu">
                                <li>
                                    <a href="{{ URL::to('negociationproduction/' . $production->ProductionID . '/create') }}">Proposer un prix</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            {{ $message }}
                        </div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>
                                    <th>Acheteur&nbsp;</th>
                                    <th>Prix&nbsp;</th>
                                    <th>Date&nbsp;</th>
                                    <th>Statut&nbsp;</th>
                                    <th class="no-sort" style="width:100px;min-width:100px;max-width:100px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($negociationproductions as $key => $value)
                                <tr>
                                    <td>{{ $value->Acheteur->nom . ' ' . $value->Acheteur->prenom }}</td>
                                    <td>{{$value->Prix}}</td>
                                    <td>{{$value->DateProposition}}</td>
                                    <td>{{$value->StatutProposition}}</td>
                                    <td nowrap="nowrap">
                                        <div class="pull-right">
                                            <a href="{{ URL::to('negociationproduction/' . $value->ProductionID . '/edit/' . $value->NegociationProductionID) }}" class="btn btn-sm btn-success"> <i class="fa fa-edit"></i></a> &nbsp;
                                            {{ Form::open(array('url' => 'negociationproduction/' . $value->NegociationProductionID , 'class' => 'pull-right')) }}
                                                {{ Form::hidden('_method', 'DELETE') }}
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            {{ Form::close() }}
                                        </div>
                                      </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--/.panel-body -->
            </div>
            <!-- /.panel -->
       </div>
       <!-- /.col-lg-6 -->
    </div>
    <!-- /.row -->

</div>
<!-- /#page-wrapper -->

@stop