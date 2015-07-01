<?php

class PaysController extends \BaseController {

    public function index()
    {
      return  View::make('admin.pays.index');
    }

    public function select2(){

      $page = \Input::get('page', 0);
      $length = \Input::get('length', 10);
      $search = \Input::get('q');
      $order = \Input::get('order', 'Ref');
      
      $query = Pays::getQuery();
      
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
      
      $list = $query->select('pays.*')->get();

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


      $query = DB::table('pays');

      $total = $query->count();

      if($search['value'] != ''){
        $query->where(function($q) use($search){
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
      $list = $query->select('pays.*')->get();

      $datatable = new DataTableResponse($draw, $total, $total_search, $list, null);

      return Response::json($datatable);      
    }

    
    public function show($id){
        $pays = Pays::find($id);
        
        return View::make('admin.pays.show')
            ->with('pays', $pays);
    }
    
    public function create()
    {
      return View::make('admin.pays.create');
    }

    public function store(){
      $validation = Validator::make(\Input::all(), 
        array(
          'Ref' => 'required',
          'Nom' => 'required'
          ), 
        array(
          'Ref.required' => "Merci de renseigner la référence",
          'Nom.required' => "Merci de renseigner le nom"
        )
      );

      if ($validation->fails()) {
          return Redirect::to('admin/pays/create')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          
          $pays = new Pays();
          $pays->Ref = \Input::get('Ref');
          $pays->Nom = \Input::get('Nom');
          $pays->Description = \Input::get('Description');
          
          $pays->save();

          $modifierUrl = URL::to('admin/pays/' . $pays->PaysID . '/edit');
          Session::flash('success', "<p>Création du pays effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier le pays</a></p>");
          return Redirect::to('admin/pays');
        }
    }

    public function edit($id)
    {
      $pays = Pays::find($id);

      return View::make('admin.pays.edit')
        ->with('pays', $pays);
    }

    public function update($id){

      $validation = Validator::make(\Input::all(), 
        array(
          'Ref' => 'required',
          'Nom' => 'required'
          ), 
        array(
          'Ref.required' => "Merci de renseigner la référence",
          'Nom.required' => "Merci de renseigner le nom"
        )
      );

      if ($validation->fails()) {
          return Redirect::to('admin/pays/' . $id . '/edit')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          
          $pays = Pays::find($id);
          $pays->Ref = \Input::get('Ref');
          $pays->Nom = \Input::get('Nom');
          $pays->Description = \Input::get('Description');
          
          $pays->save();

          $modifierUrl = URL::to('admin/pays/' . $pays->PaysID . '/edit');
          Session::flash('success', "<p>Mise-à-jour du pays effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier le pays</a></p>");
          return Redirect::to('admin/pays');
        }
    }

    public function destroy($id)
    {
      $pays = Pays::find($id);
      $pays->delete();

      // redirect
      Session::flash('success', "Pays supprimé avec succès !");
      return Redirect::to('admin/pays');
    }

    private function objectsToArray($objs, $key, $val){
      $arr = array();
      foreach($objs as $obj){
        $arr[$obj->$key] = $obj->$val;
      }
      return $arr;
    }
    
}