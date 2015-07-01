<?php
class Ville extends Eloquent
{
  protected $table = 'ville';
  
  protected $primaryKey = 'VilleID';

  public $timestamps = false;
  
  public function Pays()
  {
    return $this->belongsTo('Pays', 'PaysID');
  }
}   