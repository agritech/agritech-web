<?php

class PublicController extends BaseController {
  
  public function showPublic(){
    return \View::make('public');
  }

  
}