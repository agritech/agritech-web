<?php
use Illuminate\Support\Facades\Facade;

class AlerteController extends \BaseController {
   public static $icones = array('info' => 'Information', 'warning' => 'Attention', 'danger' => 'Danger', 'success' => 'Succès');
  
    public function index()
    {
      return  View::make('alerte.index');
    }

    public function datatable(){

      $draw = \Input::get('draw');
      $start = \Input::get('start', 0);
      $length = \Input::get('length', 10);
      $search = \Input::get('search');
      $order = \Input::get('order');
      $columns = \Input::get('columns');

      $query = DB::table('alerte')
        ->join('evenement', 'evenement.EvenementID', '=', 'alerte.EvenementID')
        ->join('utilisateur', 'utilisateur.UtilisateurID', '=', 'alerte.initiateurID');

      $total = $query->count();

      if($search['value'] != ''){
        $query->where(function($q) use($search){
          $q->where(DB::raw('LOWER(evenement.Nom)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
          $q->where(DB::raw('LOWER(utilisateur.nom)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
          $q->where(DB::raw('LOWER(utilisateur.prenom)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
          
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
      $list = $query->select('alerte.*', DB::raw('CONCAT(utilisateur.Nom, " ", utilisateur.prenom)  as InitiateurNom'), 'evenement.Nom as EvenementNom')->get();

      $datatable = new DataTableResponse($draw, $total, $total_search, $list, null);

      return Response::json($datatable);      
    }

    public function show($id){
        $alerte = Alerte::find($id);
        
        return View::make('alerte.show')
            ->with('alerte', $alerte);
    }
    
    public function create()
    {
      return View::make('alerte.create')
        ->with('evenements', $this->objectsToArray(Evenement::get(), 'EvenementID', 'Nom'))
        ->with('icones', self::$icones);
    }

    public function store(){
      $validation = Validator::make(\Input::all(), 
        array(
          'EvenementID' => 'required|numeric',
          'DateCreation' => 'required|date_format:"d/m/Y"',
          'Message' => 'required',
          'Titre' => 'required'
          ), 
        array(
          'EvenementID.required' => "L'evenement selectionne n'est pas valide",
          'EvenementID.numeric' => "L'evenement selectionne n'est pas valide",
          'DateCreation.date_format' => "La date de création n'est pas une date valide au format (DD/MM/YYYY)",
          'DateCreation.required' => "Merci de remplir le champ Date de creation",
          'Titre.required' => "Le titre de l'alerte est obligatoire"        
        )
      );

      if ($validation->fails()) {
          return Redirect::to('alerte/create')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $dateCreation = \Carbon\Carbon::createFromFormat('d/m/Y', Input::get('DateCreation'));
          
          $alerte = new Alerte();
          $alerte->EvenementID = \Input::get('EvenementID');
          $alerte->DateCreation = $dateCreation->toDateString();
          $alerte->Message = \Input::get('Message');
          $alerte->Icone = \Input::get('Icone');
          $alerte->InitiateurID = Auth::user()->UtilisateurID;
          $alerte->Titre = \Input::get("Titre");
          $alerte->save();

          $modifierUrl = URL::to('alerte/' . $alerte->AlerteID . '/edit');
          Session::flash('success', "<p>Création de l'alerte effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier l'alerte</a></p>");
          return Redirect::to('alerte');
        }
    }

    public function edit($id)
    {
      $alerte = Alerte::find($id);

      return View::make('alerte.edit')
        ->with('alerte', $alerte)
        ->with('evenements', $this->objectsToArray(Evenement::get(), 'EvenementID', 'Nom'))
        ->with('icones', self::$icones);
    }

    public function update($id){

       $validation = Validator::make(\Input::all(), 
        array(
          'EvenementID' => 'required|numeric',
          'DateCreation' => 'required|date_format:"d/m/Y"',
          'Message' => 'required',
          'Titre' => 'required'
          ), 
        array(
          'EvenementID.required' => "L'evenement selectionne n'est pas valide",
          'EvenementID.numeric' => "L'evenement selectionne n'est pas valide",
          'DateCreation.date_format' => "La date de creation n'est pas une date valide au format (DD/MM/YYYY)",
          'DateCreation.required' => "Merci de remplir le champ Date de creation",
          "Titre.required" => "Le titre de l'alerte est obligatoire"        
        )
      );

      if ($validation->fails()) {
          return Redirect::to('alerte/' . $id . '/edit')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $dateCreation = \Carbon\Carbon::createFromFormat('d/m/Y', Input::get('DateCreation'));
          
          $alerte = Alerte::find($id);
          $alerte->EvenementID = \Input::get('EvenementID');
          $alerte->DateCreation = $dateCreation->toDateString();
          $alerte->Message = \Input::get('Message');
          $alerte->Icone = \Input::get('Icone');
          $alerte->Titre = \Input::get('Titre');
          $alerte->save();

          $modifierUrl = URL::to('alerte/' . $alerte->AlerteID . '/edit');
          Session::flash('success', "<p>Mise-à-jour l'alerte effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier l'alerte</a></p>");
          return Redirect::to('alerte');
        }
    }

    public function destroy($id)
    {
      $alerte = Alerte::find($id);
      $alerte->delete();

      // redirect
      Session::flash('success', "Alerte supprimée avec succès !");
      return Redirect::to('alerte');
    }

    private function objectsToArray($objs, $key, $val){
      $arr = array();
      foreach($objs as $obj){
        $arr[$obj->$key] = $obj->$val;
      }
      return $arr;
    }
}