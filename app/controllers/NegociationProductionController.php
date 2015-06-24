<?php

class NegociationProductionController extends \BaseController {
    public static $statutPropositions = array('PREPARATION' => 'En préparation', 'PUBLIE' => 'Publié');
  
    public function negociationProductionCreate($productionID)
    {
      $production = Production::find($productionID);

      $negociationproductions = NegociationProduction::where('ProductionID', $productionID)->get();
      
      return View::make('negociationproduction.create')
        ->with('production', $production)
        ->with('statutPropositions', self::$statutPropositions)
        ->with('negociationproductions', $negociationproductions);
    }

    public function negociationProductionStore($productionID){
      Log::info("Début de l'enregistrement d'une négociation de prix", array('ProductionID' => $productionID));
      $validation = Validator::make(\Input::all(), 
        array(
          'Prix' => 'required|numeric',
          'StatutProposition' => 'required'
          ), 
        array(
          'Prix.required' => "Merci de renseigner le prix",
          'Prix.numeric' => "Le prix doit-être sans chiffre après la virgule",
          'StatutProposition.required' => 'Le status de la proposition est obligatoire'
        )
      );

      if ($validation->fails()) {
          return Redirect::to('negociationproduction/' . $productionID . '/create')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $dateProposition = \Carbon\Carbon::now();
          
          $negociationproduction = new NegociationProduction();
          $negociationproduction->Prix = \Input::get('Prix');
          $negociationproduction->AcheteurID = Auth::user()->UtilisateurID;
          $negociationproduction->ProductionID = $productionID;
          $negociationproduction->DateProposition = $dateProposition->toDateString();
          $negociationproduction->StatutProposition = \Input::get('StatutProposition');
          
          $negociationproduction->save();

          $modifierUrl = URL::to('negociationproduction/' . $productionID . '/edit/' . $negociationproduction->NegociationProductionID);
          
          Log::info("Création d'un prix pour la production effectué avec succès", array('ProductionID' => $productionID, 'ProductionNegociationID' => $negociationproduction->NegociationProductionID));
          
          Session::flash('success', "<p>Création de la négociation de récolte effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier la négociation de la récolte</a></p>");
          return Redirect::to('production/' . $productionID);
        }
    }

    public function negociationProductionEdit($productionID, $negociationProductionID)
    {
      $production = Production::find($productionID);
      $negociationproduction = NegociationProduction::find($negociationProductionID);

      $negociationproductions = NegociationProduction::where('ProductionID', $productionID)->get();
      
      return View::make('negociationproduction.edit')
        ->with('negociationproduction', $negociationproduction)
        ->with('production', $production)
        ->with('statutPropositions', self::$statutPropositions)
        ->with('negociationproductions', $negociationproductions);
    }

    public function negociationProductionUpdate($productionID, $negociationProductionID){
      $validation = Validator::make(\Input::all(), 
        array(
          'Prix' => 'required|numeric',
          'StatutProposition' => 'required'
          ), 
        array(
          'Prix.required' => "Merci de renseigner le prix",
          'Prix.numeric' => "Le prix doit-être sans chiffre après la virgule",
          'StatutProposition.required' => 'Le status de la proposition est obligatoire'
        )
      );

      if ($validation->fails()) {
          return Redirect::to('negociationproduction/' . $productionID . '/edit/' . $negociationProductionID)
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $dateProposition = \Carbon\Carbon::now();
          
          $negociationproduction = NegociationProduction::find($negociationProductionID);
          $negociationproduction->Prix = \Input::get('Prix');
          $negociationproduction->AcheteurID = Auth::user()->UtilisateurID;
          $negociationproduction->ProductionID = $productionID;
          $negociationproduction->DateProposition = $dateProposition->toDateString();
          $negociationproduction->StatutProposition = \Input::get('StatutProposition');
          
          $negociationproduction->save();

          $modifierUrl = URL::to('negociationproduction/' . $productionID . '/edit/' . $negociationproduction->NegociationProductionID);
          Session::flash('success', "<p>Mise-à-jour de la négociation de la récolte effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier la négociation de la récolte</a></p>");
          return Redirect::to('production/' . $productionID);
        }
    }

    public function destroy($id)
    {
      $negociationproduction = NegociationProduction::find($id);
      $negociationproduction->delete();

      // redirect
      Session::flash('success', "Négociation de la récolte supprimée avec succès !");
      return Redirect::to('production/' . $negociationproduction->ProductionID);
    }

    private function objectsToArray($objs, $key, $val){
      $arr = array();
      foreach($objs as $obj){
        $arr[$obj->$key] = $obj->$val;
      }
      return $arr;
    }
}