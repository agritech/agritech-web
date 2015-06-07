<?php
/**
 * SettingsController 
 * {File description}
 * 
 * @author defus
 * @created Nov 13, 2014
 * 
 */

class SettingsController extends \BaseController {
    
    public function index() {
        $settings = new Settings();
        $settings->SMSGateway = Config::get('agritech.app.sms.gateway');
        
        return \View::make('admin.settings.index')
            ->with('settings', $settings);
    }

    public function update($id){

      $validation = Validator::make(\Input::all(), 
        array(
          ), 
        array(
        )
      );

      if ($validation->fails()) {
          return Redirect::to('settings')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $modifierUrl = URL::to('settings');
          Session::flash('success', "<p>Mise-à-jour des paramètres effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier la récolte</a></p>");
          return Redirect::to('settings');
        }
    }
    
    private function objectsToArray($objs, $key, $val){
      $arr = array();
      foreach($objs as $obj){
        $arr[$obj->$key] = $obj->$val;
      }
      return $arr;
    }
}