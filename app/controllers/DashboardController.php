<?php

class DashboardController extends BaseController {
  
  public function showDashboard(){
    $negociationproductions = NegociationProduction::take(10)->get();
    $produits = Produit::take(10)->get();
    $alertes = Alerte::orderBy('DateCreation', 'DESC')->take(10)->get();

    return \View::make('dashboard')
        ->with('produits', $produits)
        ->with('negociationproductions', $negociationproductions)
        ->with('alertes', $alertes);
  }

  
}