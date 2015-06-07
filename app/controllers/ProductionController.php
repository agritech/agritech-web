<?php
use Illuminate\Support\Facades\Facade;

class ProductionController extends \BaseController {
    public static $statutSoumissions = array('SOUMIS' => 'Soumis', 'VALIDE' => 'Valide');
    public static $canalSoumissions = array('INTERNET' => 'Internet', 'SMS' => 'SMS', 'TELEPHONE' => 'Téléphone');
  
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
        ->leftJoin('produit', 'produit.ProduitID', '=', 'production.ProduitID')
        ->leftJoin('utilisateur', 'utilisateur.UtilisateurID', '=', 'production.AgriculteurID');

      $total = $query->count();

      if($search['value'] != ''){
        $query->where(function($q) use($search){
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
      $list = $query->select('production.*', 'utilisateur.Nom as agri_nom', 'produit.Nom as prod_nom')->get();

      $datatable = new DataTableResponse($draw, $total, $total_search, $list, null);

      return Response::json($datatable);      
    }

    public function create()
    {
      return View::make('production.create')
        ->with('statutSoumissions', self::$statutSoumissions)
        ->with('canalSoumissions', self::$canalSoumissions);
    }

    public function store(){
      $validation = Validator::make(\Input::all(), 
        array(
          'Poids' => 'required|numeric',
          'ProduitID' => 'required|numeric',
          'AgriculteurID' => 'required|numeric',
          'DateSoumission' => 'required|date_format:"d/m/Y"',
          'StatutSoumission' => 'required',
          'CanalSoumission' => 'required'
          ), 
        array(
          'Poids.required' => "Merci de renseigner le poids",
          'Poids.numeric' => "Le poids doit-être au format (#0,00) avec deux chiffres après la virgule",
          'DateSoumission.date_format' => "La date de soumission n'est pas une date valide au format (DD/MM/YYYY)",
          'DateSoumission.required' => "Merci de remplir le champ Date de soumission",
          'AgriculteurID.numeric' => "L'agriculteur sélectionné n'est pas valide",
          'AgriculteurID.required' => "L'agriculteur sélectionné n'est pas valide",
          'ProduitID.numeric' => "Le produit sélectionné n'est pas valide",
          'ProduitID.required' => "Le produit sélectionné n'est pas valide"
        )
      );

      if ($validation->fails()) {
          return Redirect::to('production/create')
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
          
          $production->save();

          $modifierUrl = URL::to('production/' . $production->ProductionID . '/edit');
          Session::flash('success', "<p>Création de la production effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier la production</a></p>");
          return Redirect::to('production');
        }
    }

    public function storeSMS(){
    	
    	$sender = \Input::get('sender');
    	$keyword = \Input::get('keyword');
    	$sendtime = new Datetime( \Input::get('sendtime') );
    	$param = \Input::get('param');    	
    	$paramArray = explode(' ', $param);
    	
    	$user = User::where('telephone', $sender)->firstOrFail();
    	$produit = Produit::where('Nom', $paramArray[0])->firstOrFail();
    	
    	$submissionData = array(
    		'Poids' => $paramArray[1],
    		'ProduitID' => $produit->ProduitID,
    		'AgriculteurID' => $user->UtilisateurID,
    		'DateSoumission' => $sendtime->format('d/m/Y'),
    		'StatutSoumission' => 'SOUMIS',
    		'CanalSoumission' => 'SMS'
    	);
    	
    	$validation = Validator::make($submissionData,
    			array(
    					'Poids' => 'required|numeric',
    					'ProduitID' => 'required|numeric',
    					'AgriculteurID' => 'required|numeric',
    					'DateSoumission' => 'required|date_format:"d/m/Y"',
    					'StatutSoumission' => 'required',
    					'CanalSoumission' => 'required'
    			),
    			array(
    					'Poids.required' => "Merci de renseigner le poids",
    					'Poids.numeric' => "Le poids doit-être au format (#0,00) avec deux chiffres après la virgule",
    					'DateSoumission.date_format' => "La date de soumission n'est pas une date valide au format (DD/MM/YYYY)",
    					'DateSoumission.required' => "Merci de remplir le champ Date de soumission",
    					'AgriculteurID.numeric' => "L'agriculteur sélectionné n'est pas valide",
    					'AgriculteurID.required' => "L'agriculteur sélectionné n'est pas valide",
    					'ProduitID.numeric' => "Le produit sélectionné n'est pas valide",
    					'ProduitID.required' => "Le produit sélectionné n'est pas valide"
    			)
    	);
    
    	if ($validation->fails()) {
    		return Redirect::to('production/create')
    		->withErrors($validation)
    		->withInput(\Input::all());
    	} else {
    		$dateSoumission = \Carbon\Carbon::createFromFormat('d/m/Y', $submissionData['DateSoumission']);
    
    		$production = new Production();
    		$production->Poids = $submissionData['Poids'];
    		$production->ProduitID = $submissionData['ProduitID'];
    		$production->AgriculteurID = $submissionData['AgriculteurID'];
    		$production->DateSoumission = $dateSoumission->toDateString();
    		$production->StatutSoumission = $submissionData['StatutSoumission'];
    		$production->CanalSoumission = $submissionData['CanalSoumission'];
    		//$production->InitiateurID = Auth::user()->UtilisateurID;
        $production->InitiateurID = $user->UtilisateurID;

    		$production->save();
    		
    		$wsf = new SMSWebServicesFactory(Facade::getFacadeApplication());
        $ws = $wsf->getSMSWebServices(Config::get('agritech.app.sms.gateway'));
    		$msg = "Votre production de " . $submissionData['Poids'] . " KG de " . $submissionData['ProduitID'] . " a bien ete enregistree. Merci."; 
    		$ws->sendmsg($sender, $msg);
    
    		$modifierUrl = URL::to('production/' . $production->ProductionID . '/edit');
    		Session::flash('success', "<p>Création de la production effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier la production</a></p>");
    		return Redirect::to('');
    	}
    }
    
    public function edit($id)
    {
      $production = Production::find($id);

      return View::make('production.edit')
        ->with('production', $production)
        ->with('statutSoumissions', self::$statutSoumissions)
        ->with('canalSoumissions', self::$canalSoumissions);

    }

    public function update($id){

      $validation = Validator::make(\Input::all(), 
        array(
          'Poids' => 'required|numeric',
          'ProduitID' => 'required|numeric',
          'AgriculteurID' => 'required|numeric',
          'DateSoumission' => 'required|date_format:"d/m/Y"',
          'StatutSoumission' => 'required',
          'CanalSoumission' => 'required'
          ), 
        array(
          'Poids.required' => "Merci de renseigner le poids",
          'Poids.numeric' => "Le poids doit-être au format (#0,00) avec deux chiffres après la virgule",
          'DateSoumission.date_format' => "La date de soumission n'est pas une date valide au format (DD/MM/YYYY)",
          'DateSoumission.required' => "Merci de remplir le champ Date de soumission",
          'AgriculteurID.numeric' => "L'agriculteur sélectionné n'est pas valide",
          'AgriculteurID.required' => "L'agriculteur sélectionné n'est pas valide",
          'ProduitID.numeric' => "Le produit sélectionné n'est pas valide",
          'ProduitID.required' => "Le produit sélectionné n'est pas valide"
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

    private function objectsToArray($objs, $key, $val){
      $arr = array();
      foreach($objs as $obj){
        $arr[$obj->$key] = $obj->$val;
      }
      return $arr;
    }
}