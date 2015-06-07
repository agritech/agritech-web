<?php

class NegociationRecolteController extends \BaseController {
    public static $statutPropositions = array('PREPARATION' => 'En préparation', 'PUBLIE' => 'Publié');
  
    public function index()
    {
      return  View::make('negociationrecolte.index');
    }

    public function datatable(){

      $draw = \Input::get('draw');
      $start = \Input::get('start', 0);
      $length = \Input::get('length', 10);
      $search = \Input::get('search');
      $order = \Input::get('order');
      $columns = \Input::get('columns');

      $query = DB::table('production')
        ->leftjoin('negociationrecolte', 'negociationrecolte.RecolteID', '=', 'production.ProductionID')
        ->join('produit', 'production.ProduitID', '=', 'produit.ProduitID')
        ->join('utilisateur as agri', 'agri.UtilisateurID', '=', 'production.AgriculteurID')
        ->leftjoin('utilisateur', 'utilisateur.UtilisateurID', '=', 'negociationrecolte.AcheteurID')
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
      $list = $query->select(DB::raw('count(negociationrecolte.RecolteID) as nbr_negociation'), 'negociationrecolte.*', 'production.*', 'agri.Nom as agri_nom', 'agri.Prenom as agri_prenom', 'produit.Ref as produit_ref', 'produit.Nom as produit_nom')->get();

      $datatable = new DataTableResponse($draw, $total, $total_search, $list, null);

      //$queries = DB::getQueryLog();
      //echo $queries[3]['query'];die;
      
      return Response::json($datatable);      
    }

    public function negociationRecolteCreate($productionID)
    {
      $production = Production::find($productionID);

      $negociationrecoltes = NegociationRecolte::where('RecolteID', $productionID)->get();
      
      return View::make('negociationrecolte.create')
        ->with('production', $production)
        ->with('statutPropositions', self::$statutPropositions)
        ->with('negociationrecoltes', $negociationrecoltes);
    }

    public function negociationRecolteStore($productionID){
      Log::info("Début de l'enregistrement d'une négociation de prix", array('RecolteID' => $productionID));
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
          return Redirect::to('negociationrecolte/' . $productionID . '/create')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $dateProposition = \Carbon\Carbon::now();
          
          $negociationrecolte = new NegociationRecolte();
          $negociationrecolte->Prix = \Input::get('Prix');
          $negociationrecolte->AcheteurID = Auth::user()->UtilisateurID;
          $negociationrecolte->RecolteID = $productionID;
          $negociationrecolte->DateProposition = $dateProposition->toDateString();
          $negociationrecolte->StatutProposition = \Input::get('StatutProposition');
          
          $negociationrecolte->save();

          $modifierUrl = URL::to('negociationrecolte/' . $productionID . '/edit/' . $negociationrecolte->NegociationRecolteID);
          
          Log::info("Création d'un prix pour la production effectué avec succès", array('RecolteID' => $productionID, 'RecolteNegociationID' => $negociationrecolte->NegociationRecolteID));
          
          Session::flash('success', "<p>Création de la négociation de récolte effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier la négociation de la récolte</a></p>");
          return Redirect::to('negociationrecolte');
        }
    }

    public function negociationRecolteEdit($productionID, $negociationRecolteID)
    {
      $production = Production::find($productionID);
      $negociationrecolte = NegociationRecolte::find($negociationRecolteID);

      $negociationrecoltes = NegociationRecolte::where('RecolteID', $productionID)->get();
      
      return View::make('negociationrecolte.edit')
        ->with('negociationrecolte', $negociationrecolte)
        ->with('production', $production)
        ->with('statutPropositions', self::$statutPropositions)
        ->with('negociationrecoltes', $negociationrecoltes);
    }

    public function negociationRecolteUpdate($productionID, $negociationRecolteID){
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
          return Redirect::to('negociationrecolte/' . $productionID . '/edit/' . $negociationRecolteID)
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $dateProposition = \Carbon\Carbon::now();
          
          $negociationrecolte = NegociationRecolte::find($negociationRecolteID);
          $negociationrecolte->Prix = \Input::get('Prix');
          $negociationrecolte->AcheteurID = Auth::user()->UtilisateurID;
          $negociationrecolte->RecolteID = $productionID;
          $negociationrecolte->DateProposition = $dateProposition->toDateString();
          $negociationrecolte->StatutProposition = \Input::get('StatutProposition');
          
          $negociationrecolte->save();

          $modifierUrl = URL::to('negociationrecolte/' . $productionID . '/edit/' . $negociationrecolte->NegociationRecolteID);
          Session::flash('success', "<p>Mise-à-jour de la négociation de la récolte effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier la négociation de la récolte</a></p>");
          return Redirect::to('negociationrecolte');
        }
    }

    public function destroy($id)
    {
      $negociationrecolte = NegociationRecolte::find($id);
      $negociationrecolte->delete();

      // redirect
      Session::flash('success', "Négociation de la récolte supprimée avec succès !");
      return Redirect::to('negociationrecolte/' . $negociationrecolte->ProductionID . '/create');
    }

    private function objectsToArray($objs, $key, $val){
      $arr = array();
      foreach($objs as $obj){
        $arr[$obj->$key] = $obj->$val;
      }
      return $arr;
    }
}