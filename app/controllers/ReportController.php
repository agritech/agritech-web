<?php

class ReportController extends BaseController {
  
  public function showUsersDashboard(){
    return \View::make('report.users');
  }

  public function jsonp(){
    $query = DB::table('Utilisateur as user')
        ->join('roles as role', 'role.Username', '=', 'user.Username')
        ->groupBy('user.pays')
        ->groupBy('user.ville')
        ->groupBy('role.role')
        ->orderBy('user.pays', 'ASC')
        ->orderBy('user.ville', 'ASC')
        ->orderBy('role.role', 'ASC')
        ->whereNotNull('user.pays')
        ->whereNotNull('user.ville');
        
    /*$query->where(function($q){
          $q->where('user.pays', '=', 'NULL');
          $q->where('user.ville', '=', 'NULL');
    });*/
    
    
    $list = $query->select('user.pays', 'user.ville', 'role.role', DB::raw('count(role.role) as nbr_role') )->get();

    $result = new stdClass;
    $result->series = array();
    
    $data = array();
    foreach($list as $key => $row){
        $data[$row->ville . '(' . $row->pays . ')'][$row->role] = $row->nbr_role;    
    }
    
    foreach($data as $key => $row){
        $stats = array();
        
        if(array_key_exists('AGRICULTEUR', $row)){
            $stats[] = $row['AGRICULTEUR'];
        }else{
            $stats[] = 0;
        }
        
        if(array_key_exists('ACHETEUR', $row)){
            $stats[] = $row['ACHETEUR'];
        }else{
            $stats[] = 0;
        }
        
        if(array_key_exists('PARTENAIRE', $row)){
            $stats[] = $row['PARTENAIRE'];
        }else{
            $stats[] = 0;
        }
        
        if(array_key_exists('PROFESSIONNEL', $row)){
            $stats[] = $row['PROFESSIONNEL'];
        }else{
            $stats[] = 0;
        }
        
        $result->series[] = array('name' => $key, 
            'data' => $stats, 
            'stack' => 'ville');    
    } 
    
    return Response::json($result)->setCallback(Input::get('callback'));
    
  }
}