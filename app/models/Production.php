<?php
    class Production extends Eloquent
    {
      protected $table = 'production';

      protected $primaryKey = 'ProductionID';

      public function __construct() {
        parent::__construct();

        //Set the format used by Carbon when converting date to string
        \Carbon\Carbon::setToStringFormat('d-m-Y');
        //all dates like 2014-03-25 17:37:54 look like 25-03-2014 17:37:54 now
      }

      public function CampagneAgricole()
      {
        return $this->belongsTo('CampagneAgricole', 'CampagneAgricoleID');
      }
      
      public function Agriculteur()
      {
        return $this->belongsTo('Agriculteur', 'AgriculteurID');
      }
      
      public function Exploitation()
      {
        return $this->belongsTo('Exploitation', 'ExploitationID');
      }

      public function Produit()
      {
        return $this->belongsTo('Produit', 'ProduitID');
      }

      public function getDatesoumissionFAttribute(){
        $dt = new \Carbon\Carbon($this->attributes['DateSoumission']);
        return $dt->format('d/m/Y');
      }

      public function getEditUrlAttribute()
      {
        return URL::to('production/' .  $this->attributes['ProductionID'] . '/edit');
      }

      public function getDeleteUrlAttribute()
      {
          return URL::to('production/' . $this->attributes['ProductionID'] );
      }

      protected $appends = array('datesoumission_f', 'edit_url', 'delete_url');
    }