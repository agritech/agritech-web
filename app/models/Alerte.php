<?php
class Alerte extends Eloquent
{
  protected $table = 'alerte';
    
  protected $primaryKey = 'AlerteID';   
  
  public function __construct() {
    parent::__construct();
    \Carbon\Carbon::setToStringFormat('d-m-Y');
  }
  
  public function Destinataires() {
    return $this->hasMany('AlerteDestinataire', 'AlerteID', 'AlerteID');
  }
  
  public function Evenement()
  {
    return $this->belongsTo('Evenement', 'EvenementID');
  }
  
  public function getDatecreationFAttribute(){
    $dt = new \Carbon\Carbon($this->attributes['DateCreation']);
    return $dt->format('d/m/Y');
  }
} 