<?php
    class Produit extends Eloquent
    {
      protected $table = 'produit';
      
      protected $primaryKey = 'ProduitID';
      
      public function getEditUrlAttribute()
      {
        return URL::to('admin/produit/' .  $this->attributes['ProduitID'] . '/edit');
      }

      public function getDeleteUrlAttribute()
      {
          return URL::to('admin/produit/' . $this->attributes['ProduitID'] );
      }
    }   