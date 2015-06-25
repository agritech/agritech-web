<?php

class ProduitController extends \BaseController {

    public function index()
    {
      return  View::make('produit.index');
    }

    public function select2($exploitationID){

      $page = \Input::get('page', 0);
      $length = \Input::get('length', 10);
      $search = \Input::get('q');
      $order = \Input::get('order', 'Ref');
      
      $query = Produit::getQuery()
        ->join('exploitation_produit', 'exploitation_produit.ProduitID', '=', 'produit.ProduitID')
        ->where('exploitation_produit.ExploitationID', '=', $exploitationID);
      
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
      
      $list = $query->select('produit.*')->get();

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


      $query = DB::table('produit');

      $total = $query->count();

      if($search['value'] != ''){
        $query->where(function($q) use($search){
          $q->where(DB::raw('LOWER(produit.Ref)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
          $q->where(DB::raw('LOWER(produit.Nom)'), 'LIKE', Str::lower('%' . trim($search['value']) . '%' ));
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
      $list = $query->select('produit.*')->get();

      $datatable = new DataTableResponse($draw, $total, $total_search, $list, null);

      return Response::json($datatable);      
    }

    
    public function show($id){
        $produit = Produit::find($id);
        
        return View::make('produit.show')
            ->with('produit', $produit);
    }
    
    public function create()
    {
      return View::make('produit.create');
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
          return Redirect::to('produit/create')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          
          $produit = new Produit();
          $produit->Ref = \Input::get('Ref');
          $produit->Nom = \Input::get('Nom');
          $produit->Description = \Input::get('Description');
          
          $produit->save();

          $modifierUrl = URL::to('produit/' . $produit->ProduitID . '/edit');
          Session::flash('success', "<p>Création du produit effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier le produit</a></p>");
          return Redirect::to('produit');
        }
    }

    public function edit($id)
    {
      $produit = Produit::find($id);

      return View::make('produit.edit')
        ->with('produit', $produit);
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
          return Redirect::to('produit/' . $id . '/edit')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          
          $produit = Produit::find($id);
          $produit->Ref = \Input::get('Ref');
          $produit->Nom = \Input::get('Nom');
          $produit->Description = \Input::get('Description');
          
          $produit->save();

          $modifierUrl = URL::to('produit/' . $produit->ProduitID . '/edit');
          Session::flash('success', "<p>Mise-à-jour du produit effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier le produit</a></p>");
          return Redirect::to('produit');
        }
    }

    public function destroy($id)
    {
      $produit = Produit::find($id);
      $produit->delete();

      // redirect
      Session::flash('success', "Produit supprimée avec succès !");
      return Redirect::to('produit');
    }

    private function objectsToArray($objs, $key, $val){
      $arr = array();
      foreach($objs as $obj){
        $arr[$obj->$key] = $obj->$val;
      }
      return $arr;
    }
    
}