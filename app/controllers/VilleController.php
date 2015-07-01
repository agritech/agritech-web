<?php

class VilleController extends \BaseController {

    public function index()
    {
      return  View::make('admin.ville.index');
    }

    public function select2($paysID){

      $page = \Input::get('page', 0);
      $length = \Input::get('length', 10);
      $search = \Input::get('q');
      $order = \Input::get('order', 'Ref');
      
      $query = Ville::getQuery()
        ->where('PaysID', '=', $paysID);
      
      $total = $query->count();
      
      if($search != ''){
        $query->where(function($q) use($search){
          $q->where(DB::raw('LOWER(Ref)'), 'LIKE', Str::lower('%' . trim($search) . '%' ));
          $q->orwhere(DB::raw('LOWER(Nom)'), 'LIKE', Str::lower('%' . trim($search) . '%' ));
        });
      }
      $total_search = $query->count();
      if (!is_null($page) && !is_null($length)) {
        $start = (int)(($page-1) * $length);
        $query = $query->skip($start)->take($length);
      }
      
      $query->orderBy($order, 'ASC');
      
      $list = $query->select('ville.*')->get();

      $datatable = new DataTableResponse(1, $total, $total_search, $list, null);

      return Response::json($datatable);      
    }

    public function datatable(){

      $draw = \Input::get('draw');
      $start = \Input::get('start', 0);
      $length = \Input::get('length', 10);
      $search = \Input::get('search');
      $order = \Input::get('order');
      $columns = \Input::get('columns');


      $query = DB::table('ville')
            ->join('pays', 'pays.PaysID', '=', 'ville.PaysID');

      $total = $query->count();

      if($search['value'] != ''){
        $query->where(function($q) use($search){
          $q->where(DB::raw('LOWER(ville.Ref)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
          $q->where(DB::raw('LOWER(ville.Nom)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
          $q->where(DB::raw('LOWER(pays.Ref)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
          $q->where(DB::raw('LOWER(pays.Nom)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
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
      $list = $query->select('ville.*', DB::raw('pays.Ref as pays_ref'), DB::raw('pays.Nom as pays_nom'))->get();

      $datatable = new DataTableResponse($draw, $total, $total_search, $list, null);

      return Response::json($datatable);      
    }

    
    public function show($id){
        $ville = Ville::find($id);
        
        return View::make('admin.ville.show')
            ->with('ville', $ville);
    }
    
    public function create()
    {
      return View::make('admin.ville.create');
    }

    public function store(){
      $validation = Validator::make(\Input::all(), 
        array(
          'Ref' => 'required',
          'Nom' => 'required',
          'PaysID' => 'required'
          ), 
        array(
          'Ref.required' => "Merci de renseigner la référence",
          'Nom.required' => "Merci de renseigner le nom",
          'PaysID.required' => "Merci de renseigner le pays"
        )
      );

      if ($validation->fails()) {
          $messages = $validation->messages();
          
          $paysJson = "";
          if (!$messages->has('PaysID')){
              $paysID = \Input::get('PaysID');
              $pays = Pays::find($paysID);
              $paysJson = json_encode($pays);
          }
          
          return Redirect::to('admin/ville/create')
              ->with('paysJson', $paysJson)
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          
          $ville = new Ville();
          $ville->Ref = \Input::get('Ref');
          $ville->Nom = \Input::get('Nom');
          $ville->PaysID = \Input::get('PaysID');
          $ville->Description = \Input::get('Description');
          
          $ville->save();

          $modifierUrl = URL::to('admin/ville/' . $ville->VilleID . '/edit');
          Session::flash('success', "<p>Création de la ville effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier la ville</a></p>");
          return Redirect::to('admin/ville');
        }
    }

    public function edit($id)
    {
      $ville = Ville::find($id);

      return View::make('admin.ville.edit')
        ->with('ville', $ville);
    }

    public function update($id){

      $validation = Validator::make(\Input::all(), 
        array(
          'Ref' => 'required',
          'Nom' => 'required',
          'PaysID' => 'required'
          ), 
        array(
          'Ref.required' => "Merci de renseigner la référence",
          'Nom.required' => "Merci de renseigner le nom",
          'PaysID.required' => "Merci de renseigner le pays"
        )
      );

      if ($validation->fails()) {
          return Redirect::to('admin/ville/' . $id . '/edit')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          
          $ville = Ville::find($id);
          $ville->Ref = \Input::get('Ref');
          $ville->Nom = \Input::get('Nom');
          $ville->PaysID = \Input::get('PaysID');
          $ville->Description = \Input::get('Description');
          
          $ville->save();

          $modifierUrl = URL::to('admin/ville/' . $ville->VilleID . '/edit');
          Session::flash('success', "<p>Mise-à-jour de la ville effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier la ville</a></p>");
          return Redirect::to('admin/ville');
        }
    }

    public function destroy($id)
    {
      $ville = Ville::find($id);
      $ville->delete();

      // redirect
      Session::flash('success', "Ville supprimée avec succès !");
      return Redirect::to('admin/ville');
    }

    private function objectsToArray($objs, $key, $val){
      $arr = array();
      foreach($objs as $obj){
        $arr[$obj->$key] = $obj->$val;
      }
      return $arr;
    }
    
}