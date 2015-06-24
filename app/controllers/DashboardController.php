<?php

class DashboardController extends BaseController {
  
  public function showDashboard(){
    $negociationproductions = NegociationProduction::get();
    $produits = Produit::get();
    $alertes = Alerte::get();

    return \View::make('dashboard')
        ->with('produits', $produits)
        ->with('negociationproductions', $negociationproductions)
        ->with('alertes', $alertes);
  }

  
}