<?php
use Illuminate\Support\Facades\Facade;

class ProductionController extends \BaseController {
    public static $statutSoumissions = array('SOUMIS' => 'Soumis', 'VALIDE' => 'Valide');
    public static $canalSoumissions = array('INTERNET' => 'Internet', 'SMS' => 'SMS', 'TELEPHONE' => 'Téléphone');
    public static $statutPropositions = array('PREPARATION' => 'En préparation', 'PUBLIE' => 'Publié');
  
    public function index()
    {
      return  View::make('production.index');
    }

    public function datatable(){

      $draw = \Input::get('draw');
      $start = \Input::get('start', 0);
      $length = \Input::get('length', 10);
      $search = \Input::get('search');
      $order = \Input::get('order');
      $columns = \Input::get('columns');


      $query = DB::table('production')
        ->join('produit', 'produit.ProduitID', '=', 'production.ProduitID')
        ->join('campagne_agricole', 'campagne_agricole.CampagneAgricoleID', '=', 'production.CampagneAgricoleID')
        ->join('exploitation', 'exploitation.ExploitationID', '=', 'production.ExploitationID')
        ->join('utilisateur', 'utilisateur.UtilisateurID', '=', 'production.AgriculteurID');

      $total = $query->count();

      if($search['value'] != ''){
        $query->where(function($q) use($search){
          $q->where(DB::raw('LOWER(campagne_agricole.Nom)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
          $q->where(DB::raw('LOWER(exploitation.Ref)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
          $q->where(DB::raw('LOWER(exploitation.Nom)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
          $q->where(DB::raw('LOWER(produit.Ref)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
          $q->where(DB::raw('LOWER(produit.Nom)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
          $q->where(DB::raw('LOWER(utilisateur.Ref)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
          $q->where(DB::raw('LOWER(utilisateur.Nom)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
          $q->where(DB::raw('LOWER(utilisateur.Prenom)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
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
      $list = $query->select('production.*', DB::raw('CONCAT(utilisateur.nom, " ", utilisateur.prenom) AS agriculteur_nom'), DB::raw('CONCAT(exploitation.Ref, " ", exploitation.Nom) AS exploitation_nom'), DB::raw('CONCAT(produit.Ref, " ", produit.Nom) AS produit_nom'), 'campagne_agricole.Nom as campagne_agricole_nom')->get();

      $datatable = new DataTableResponse($draw, $total, $total_search, $list, null);

      return Response::json($datatable);      
    }

    public function show($id)
    {
      $production = Production::find($id);
      $negociationproductions = NegociationProduction::where('ProductionID', $id)->get();
      
      return View::make('production.show')
        ->with('production', $production)
        ->with('statutPropositions', self::$statutPropositions)
        ->with('negociationproductions', $negociationproductions);

    }
    
    public function create()
    {
      $campagneAgricoles = CampagneAgricole::get();
      $campagneAgricoles = $this->objectsToArray($campagneAgricoles, 'CampagneAgricoleID', 'Nom');
       
      return View::make('production.create')
        ->with('statutSoumissions', self::$statutSoumissions)
        ->with('canalSoumissions', self::$canalSoumissions)
        ->with('campagneAgricoles', $campagneAgricoles);
    }

    public function store(){
      $validation = Validator::make(\Input::all(), 
        array(
          'Poids' => 'required|numeric',
          'ProduitID' => 'required|numeric',
          'AgriculteurID' => 'required|numeric',
          'DateSoumission' => 'required|date_format:"d/m/Y"',
          'StatutSoumission' => 'required',
          'CanalSoumission' => 'required',
          'CampagneAgricoleID' => 'required',
          'ExploitationID' => 'required'
          ), 
        array(
          'Poids.required' => "Merci de renseigner le poids",
          'Poids.numeric' => "Le poids doit-être au format (#0,00) avec deux chiffres après la virgule",
          'DateSoumission.date_format' => "La date de soumission n'est pas une date valide au format (DD/MM/YYYY)",
          'DateSoumission.required' => "Merci de remplir le champ Date de soumission",
          'AgriculteurID.numeric' => "L'agriculteur sélectionné n'est pas valide",
          'AgriculteurID.required' => "L'agriculteur sélectionné n'est pas valide",
          'ProduitID.numeric' => "Le produit sélectionné n'est pas valide",
          'ProduitID.required' => "Le produit sélectionné n'est pas valide",
          'CampagneAgricoleID.required' => "Merci de renseigner la campagne agricole",
          'ExploitationID.required' => "Merci de renseigner l'exploitation concernée"
        )
      );

      if ($validation->fails()) {
          $messages = $validation->messages();
          
          $produitJson = "";
          if (!$messages->has('ProduitID')){
              $produitID = \Input::get('ProduitID');
              $produit = Produit::find($produitID);
              $produitJson = json_encode($produit);
          }
          
          $agriculteurJson = "";
          if (!$messages->has('AgriculteurID')){
              $agriculteurID = \Input::get('AgriculteurID');
              $agriculteur = Agriculteur::find($agriculteurID);
              $agriculteurJson = json_encode($agriculteur);
          }
          
          $exploitationJson = "";
          if (!$messages->has('ExploitationID')){
              $exploitationID = \Input::get('ExploitationID');
              $exploitation = Exploitation::find($exploitationID);
              $exploitationJson = json_encode($exploitation);
          }
          
          return Redirect::to('production/create')
              ->with('produitJson', $produitJson)
              ->with('agriculteurJson', $agriculteurJson)
              ->with('exploitationJson', $exploitationJson)
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $dateSoumission = \Carbon\Carbon::createFromFormat('d/m/Y', Input::get('DateSoumission'));
          
          $production = new Production();
          $production->Poids = \Input::get('Poids');
          $production->ProduitID = \Input::get('ProduitID');
          $production->AgriculteurID = \Input::get('AgriculteurID');
          $production->DateSoumission = $dateSoumission->toDateString();
          $production->StatutSoumission = \Input::get('StatutSoumission');
          $production->CanalSoumission = \Input::get('CanalSoumission');
          $production->InitiateurID = Auth::user()->UtilisateurID;
          $production->CampagneAgricoleID = \Input::get('CampagneAgricoleID');
          $production->ExploitationID = \Input::get('ExploitationID');
          
          $production->save();

          $modifierUrl = URL::to('production/' . $production->ProductionID . '/edit');
          Session::flash('success', "<p>Création de la production effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier la production</a></p>");
          return Redirect::to('production');
        }
    }

    public function edit($id)
    {
      $campagneAgricoles = CampagneAgricole::get();
      $campagneAgricoles = $this->objectsToArray($campagneAgricoles, 'CampagneAgricoleID', 'Nom');
      
      $production = Production::find($id);

      return View::make('production.edit')
        ->with('production', $production)
        ->with('statutSoumissions', self::$statutSoumissions)
        ->with('canalSoumissions', self::$canalSoumissions)
        ->with('campagneAgricoles', $campagneAgricoles);

    }

    public function update($id){

      $validation = Validator::make(\Input::all(), 
        array(
          'Poids' => 'required|numeric',
          'ProduitID' => 'required|numeric',
          'AgriculteurID' => 'required|numeric',
          'DateSoumission' => 'required|date_format:"d/m/Y"',
          'StatutSoumission' => 'required',
          'CanalSoumission' => 'required',
          'CampagneAgricoleID' => 'required',
          'ExploitationID' => 'required'
          ), 
        array(
          'Poids.required' => "Merci de renseigner le poids",
          'Poids.numeric' => "Le poids doit-être au format (#0,00) avec deux chiffres après la virgule",
          'DateSoumission.date_format' => "La date de soumission n'est pas une date valide au format (DD/MM/YYYY)",
          'DateSoumission.required' => "Merci de remplir le champ Date de soumission",
          'AgriculteurID.numeric' => "L'agriculteur sélectionné n'est pas valide",
          'AgriculteurID.required' => "L'agriculteur sélectionné n'est pas valide",
          'ProduitID.numeric' => "Le produit sélectionné n'est pas valide",
          'ProduitID.required' => "Le produit sélectionné n'est pas valide",
          'CampagneAgricoleID.required' => "Merci de renseigner la campagne agricole",
          'ExploitationID.required' => "Merci de renseigner l'exploitation concernée"
        )
      );

      if ($validation->fails()) {
          return Redirect::to('production/' . $id . '/edit')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $dateSoumission = \Carbon\Carbon::createFromFormat('d/m/Y', Input::get('DateSoumission'));
          
          $production = Production::find($id);
          $production->Poids = \Input::get('Poids');
          $production->ProduitID = \Input::get('ProduitID');
          $production->AgriculteurID = \Input::get('AgriculteurID');
          $production->DateSoumission = $dateSoumission->toDateString();
          $production->StatutSoumission = \Input::get('StatutSoumission');
          $production->CanalSoumission = \Input::get('CanalSoumission');
          $production->CampagneAgricoleID = \Input::get('CampagneAgricoleID');
          $production->ExploitationID = \Input::get('ExploitationID');
          
          $production->save();

          $modifierUrl = URL::to('production/' . $production->ProductionID . '/edit');
          Session::flash('success', "<p>Mise-à-jour de la production effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier la production</a></p>");
          return Redirect::to('production');
        }
    }

    public function destroy($id)
    {
      $production = Production::find($id);
      $production->delete();

      // redirect
      Session::flash('success', "Production supprimée avec succès !");
      return Redirect::to('production');
    }

    
    public function storeSMS(){
    	
    	$sender = \Input::get('sender');
    	$keyword = \Input::get('keyword');
    	$sendtime = new Datetime( \Input::get('sendtime') );
    	$param = \Input::get('param');    	
    	$paramArray = explode(' ', $param);
        
        if(count($paramArray) != 3){
            return Response::make("La requête doit-être de la forme <REFERENCE Exploitation> <REFERENCE Produit> <Quantité produite>", 500);
        }
    	
        //Avoir l'agrculteur avec le numero de telephone utilisé
    	$users = User::where('telephone', $sender);
        if($users->count() <= 0){
            return Response::make("Le numero de telephone est inexistant", 500);
        }
        $user = $users->firstOrFail();
        
        //Avoir l'exloitation de l'agriculteur qui a la reference
        $exploitationRef = $paramArray[0];
        $exploitations = Exploitation::where('Ref', $exploitationRef)->where('AgriculteurID', $user->UtilisateurID);
        if($exploitations->count() <= 0 ){
            return Response::make("La référence de l'exploitation n'est pas valide", 500);
        }
        $exploitation = $exploitations->firstOrfail();
        
        //Avoir le produit de l'agriculteur qui a la reference
    	$produitRef = $paramArray[1];
        $produits = Produit::where('Ref', $produitRef);
        if($produits->count() <= 0 ){
            return Response::make("La référence du produit n'est pas valide", 500);
        }
        $produit = $produits->firstOrfail();
        
        //Avoir la camapgne agricole actuelle
        $campagneAgricoleID = Config::get('agritech.app.campagneAgricole');
        
    	//Valider les données
    	$submissionData = array(
    		'Poids' => $paramArray[2],
    		'ProduitID' => $produit->ProduitID,
    		'AgriculteurID' => $user->UtilisateurID,
    		'DateSoumission' => $sendtime->format('d/m/Y'),
    		'StatutSoumission' => 'SOUMIS',
    		'CanalSoumission' => 'SMS',
            'CampagneAgricoleID' => $campagneAgricoleID,
            'ExploitationID' => $exploitation->ExploitationID
    	);
    	
    	$validation = Validator::make($submissionData,
			array(
				'Poids' => 'required|numeric',
				'ProduitID' => 'required|numeric',
				'AgriculteurID' => 'required|numeric',
				'DateSoumission' => 'required|date_format:"d/m/Y"',
				'StatutSoumission' => 'required',
				'CanalSoumission' => 'required',
                'CampagneAgricoleID' =>'required',
                'ExploitationID' => 'required'
			),
			array(
				'Poids.required' => "Merci de renseigner le poids",
				'Poids.numeric' => "Le poids doit-être au format (#0,00) avec deux chiffres après la virgule",
				'DateSoumission.date_format' => "La date de soumission n'est pas une date valide au format (DD/MM/YYYY)",
				'DateSoumission.required' => "Merci de remplir le champ Date de soumission",
				'AgriculteurID.numeric' => "L'agriculteur sélectionné n'est pas valide",
				'AgriculteurID.required' => "L'agriculteur sélectionné n'est pas valide",
				'ProduitID.numeric' => "Le produit sélectionné n'est pas valide",
				'ProduitID.required' => "Le produit sélectionné n'est pas valide",
                'CampagneAgricoleID.required' => "La campagne agricole est obligatoire",
                "ExploitationID.required" => "L'exploitation est obligatoire"
			)
    	);
    
    	if ($validation->fails()) {
    		return Response::make(json_encode($validation->messages()), 500);
    	} else {
    		$dateSoumission = \Carbon\Carbon::createFromFormat('d/m/Y', $submissionData['DateSoumission']);
    
    		$production = new Production();
    		$production->Poids = $submissionData['Poids'];
    		$production->ProduitID = $submissionData['ProduitID'];
    		$production->AgriculteurID = $submissionData['AgriculteurID'];
    		$production->DateSoumission = $dateSoumission->toDateString();
    		$production->StatutSoumission = $submissionData['StatutSoumission'];
    		$production->CanalSoumission = $submissionData['CanalSoumission'];
    		$production->InitiateurID = $submissionData['AgriculteurID'];
            $production->CampagneAgricoleID = $submissionData['CampagneAgricoleID'];
            $production->ExploitationID = $submissionData['ExploitationID'];

    		$production->save();
    		
    		$wsf = new SMSWebServicesFactory(Facade::getFacadeApplication());
            $ws = $wsf->getSMSWebServices(Config::get('agritech.app.sms.gateway'));
    		$msg = "Votre production de " . $production->Poids . "  du produit (" . $produit->Nom . ") de votre exploitation (" . $exploitation->Nom . ") a bien été enregistrée. Merci !"; 
    		$ws->sendmsg($sender, $msg);
    
    	   return Response::make($msg);
    	}
    }
    
    private function objectsToArray($objs, $key, $val){
      $arr = array();
      foreach($objs as $obj){
        $arr[$obj->$key] = $obj->$val;
      }
      return $arr;
    }
}