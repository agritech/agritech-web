<?php

class DashboardController extends BaseController {
  
  public function showDashboard(){
    $nbproductions = Production::count();
    $nbexploitations = Exploitation::count();
    $nbalertes = Alerte::count();
    $alertes = Alerte::get();

    return \View::make('dashboard')
        ->with('nbalertes', $nbalertes)
        ->with('nbexploitations', $nbexploitations)
        ->with('nbproductions', $nbproductions)
        ->with('alertes', $alertes);
  }

  
}