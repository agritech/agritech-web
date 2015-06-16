<?php

class NegociationProductionController extends \BaseController {
    public static $statutPropositions = array('PREPARATION' => 'En préparation', 'PUBLIE' => 'Publié');
  
    public function index()
    {
      return  View::make('negociationproduction.index');
    }

    public function datatable(){

      $draw = \Input::get('draw');
      $start = \Input::get('start', 0);
      $length = \Input::get('length', 10);
      $search = \Input::get('search');
      $order = \Input::get('order');
      $columns = \Input::get('columns');

      $query = DB::table('production')
        ->leftjoin('negociationproduction', 'negociationproduction.ProductionID', '=', 'production.ProductionID')
        ->join('produit', 'production.ProduitID', '=', 'produit.ProduitID')
        ->join('utilisateur as agri', 'agri.UtilisateurID', '=', 'production.AgriculteurID')
        ->leftjoin('utilisateur', 'utilisateur.UtilisateurID', '=', 'negociationproduction.AcheteurID')
        ->groupBy('production.ProductionID');

      $total = $query->count();

      if($search['value'] != ''){
        $query->where(function($q) use($search){
          $q->where(DB::raw('LOWER(produit.Ref)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
          $q->where(DB::raw('LOWER(produit.Nom)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
          $q->where(DB::raw('LOWER(agri.Ref)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
          $q->where(DB::raw('LOWER(agri.Nom)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
          $q->where(DB::raw('LOWER(agri.Prenom)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
        });
      }

      $total_search = $query->count();

      if (!is_null($start) && !is_null($length)) {
        $query = $query->skip($start)->take($length);
      }

      if (is_array($order) && count($order) > 0) {
          for ($i = 0, $c = count($order); $i < $c; $i++) {
              $order_col = (int)$order[$i]['column'];
              if (isset($columns[$order_col])) {
                  if ($columns[$order_col]['orderable'] == "true") {
                      $query->orderBy($columns[$order_col]['name'], $order[$i]['dir']);
                  }
              }
          }
      }
      $list = $query->select(DB::raw('count(negociationproduction.ProductionID) as nbr_negociation'), 'negociationproduction.*', 'production.*', 'agri.Nom as agri_nom', 'agri.Prenom as agri_prenom', 'produit.Ref as produit_ref', 'produit.Nom as produit_nom')->get();

      $datatable = new DataTableResponse($draw, $total, $total_search, $list, null);

      //$queries = DB::getQueryLog();
      //echo $queries[3]['query'];die;
      
      return Response::json($datatable);      
    }

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
          return Redirect::to('negociationproduction');
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
          return Redirect::to('negociationproduction');
        }
    }

    public function destroy($id)
    {
      $negociationproduction = NegociationProduction::find($id);
      $negociationproduction->delete();

      // redirect
      Session::flash('success', "Négociation de la récolte supprimée avec succès !");
      return Redirect::to('negociationproduction/' . $negociationproduction->ProductionID . '/create');
    }

    private function objectsToArray($objs, $key, $val){
      $arr = array();
      foreach($objs as $obj){
        $arr[$obj->$key] = $obj->$val;
      }
      return $arr;
    }
}