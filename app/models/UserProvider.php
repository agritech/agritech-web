<?php
    class UserProvider extends Eloquent
    {
      protected $table = 'user_provider';
      
      protected $primaryKey = 'UserProviderID';

      public $incrementing = true;

      public $timestamps = true;
      
    }   