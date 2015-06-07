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
@section('title') Modifier une proposition de prix pour la production @stop

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
    $('#DateProposition').datepicker( $.datepicker.regional["fr"]);
    $('#Prix').mask('#', {reverse: true});

});
</script>
@stop

{{-- Page content --}}
@section('content')

<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Modifier une proposition de prix pour la production</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Informations sur la production
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">    
                            <div class="form-group">
                                <label>Agriculteur</label>
                                <p class="form-control-static">{{$production->Agriculteur->nom . ' ' . $production->Agriculteur->prenom}}</p>
                            </div>
                            <div class="form-group">
                                <label>Produit</label>
                                <p class="form-control-static">{{$production->Produit->Ref . ' ' . $production->Produit->Nom}}</p>
                            </div>
                            <div class="form-group">
                                <label>Poids de la production (Kg)</label>
                                <p class="form-control-static">{{$production->Poids}}</p>
                            </div>
                            <div class="form-group">
                                <label>Date de la soumission de la production</label>
                                <p class="form-control-static">{{$production->DateSoumission}}</p>
                            </div>
                            <div class="form-group">
                                <label>Statut</label>
                                <p class="form-control-static">{{$production->StatutSoumission}}</p>
                            </div>
                            <div class="form-group">
                                <label>Canal</label>
                                <p class="form-control-static">{{$production->CanalSoumission}}</p>
                            </div>
                        </div>
                        <!-- /.col-lg-6 (nested) -->
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- panel -->
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Merci de remplir le formulaire ci-dessous pour modifier la proposition de prix pour cette production
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
                            {{ Form::open(array('url' => URL::to('negociationproduction/' . $production->ProductionID . '/update/' . $negociationproduction->NegociationProductionID ) , 'role' => 'form')) }}
                                <div class="form-group @if($errors->first('Debutperiode') != '')) has-error @endif">
                                    <label>Date de la proposition</label>
                                    <p class="form-control-static">{{$negociationproduction->DateProposition}}</p>
                                </div>
                                <div class="form-group @if($errors->first('Poids') != '') has-error @endif">
                                    <label>Prix *</label>
                                    {{ Form::text('Prix', $negociationproduction->Prix, array('class' => 'form-control', 'placeholder' => "Prix (FCFA)", 'id' => 'Prix') ) }}
                                    {{ $errors->first('Prix', '<span class="error">:message</span>' ) }}
                                </div>
                                <div class="form-group">
                                    <label>Statut de la proposition</label>
                                    {{ Form::select('StatutProposition', $statutPropositions, $negociationproduction->StatutProposition, array('class' => 'form-control')) }}
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
            <div class="panel panel-default">
                <div class="panel-heading">
                    Liste des propositions de prix pour la production
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
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
                                            <a href="{{ URL::to('negociationproduction/' . $value->ProductionID . '/edit/' . $value->NegociationProductionID) }}" class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i></a> &nbsp;
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
                <!-- /.panel-body -->
            </div>
            <!-- panel -->
        </div>
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->

</div>
<!-- /#page-wrapper -->

@stop