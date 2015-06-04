<?php
    class DBLog extends Eloquent
    {
      protected $table = 'logs';
      
      protected $primaryKey = 'DBLogID';

      public $incrementing = true;

      public $timestamps = true;
      
    }   