<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::group(array('prefix','/'), function() {

  Route::match(array('GET','POST'),'/login','UserController@login');

  Route::get('logout','UserController@logout');

  Route::get('production/addsms/ajax', 'ProductionController@storeSMS');
  
  Route::get('oauth/provider/{provider}', 'OAuthController@login');
  
  Route::get('register', 'RegisterController@create');
  Route::post('register', 'RegisterController@store');
  
  // Secure-Routes
  Route::group(array('before' => array('auth')), function()
  {
      Route::get('', 'DashboardController@showDashboard');
      
      Route::get('report/users', 'ReportController@showUsersDashboard');
      Route::get('jsonp', 'ReportController@jsonp');
      
      Route::resource('profile', 'ProfileController');
      Route::post('profile/{user}/photo', 'ProfileController@photoPost');
      Route::get('profile/{user}/photo/{photo}', 'ProfileController@photoGet');
      
      Route::resource('production', 'ProductionController');  
      Route::get('production/datatable/ajax', 'ProductionController@datatable');
      
      Route::resource('exploitation', 'ExploitationController');
      Route::get('exploitation/select2/ajax/{agriculteurID}', 'ExploitationController@select2');
      Route::get('exploitation/datatable/ajax', 'ExploitationController@datatable');
      
	     Route::resource('admin/produit', 'ProduitController');
       Route::get('admin/produit/datatable/ajax', 'ProduitController@datatable');
	     Route::get('produit/select2/ajax/{exploitationID}', 'ProduitController@select2');
      
      Route::resource('negociationproduction', 'NegociationProductionController');
      Route::get('negociationproduction/{productionID}/create', 'NegociationProductionController@negociationProductionCreate');
      Route::post('negociationproduction/{productionID}/store', 'NegociationProductionController@negociationProductionStore');
      Route::get('negociationproduction/{productionID}/edit/{negociationRecoleID}', 'NegociationProductionController@negociationProductionEdit');
      Route::post('negociationproduction/{productionID}/update/{negociationProductionID}', 'NegociationProductionController@negociationProductionUpdate');

      Route::get('agriculteur/select2/ajax', 'AgriculteurController@select2');

  	  // Alerte controller.
  	  Route::resource('alerte', 'AlerteController');
  	  Route::get('alerte/datatable/ajax', 'AlerteController@datatable');
      Route::get('alerte/addsms/ajax', 'AlerteController@storeSMS');
      
      // Admin
      Route::resource('admin/user', 'UserController');
      Route::post('admin/user/{user}/photo', 'UserController@photoPost');
      Route::get('admin/user/{user}/photo/{photo}', 'UserController@photoGet');

      Route::resource('admin/role', 'RoleController');
      
      Route::resource('admin/settings', 'SettingsController');
      
      // Cultures 
      Route::resource('cultures', 'CultureController@index');
      Route::resource('culture/new', 'CultureController@create');
      Route::resource('culture/save', 'CultureController@store');
      Route::get('culture/{id}', array('as'=>'culturedetail', 'uses'=> 'CultureController@show'));
      Route::get('culture/{id}/modify', array('as'=>'cultureedit', 'uses'=> 'CultureController@edit'));
      Route::resource('culture/update', 'CultureController@update');
      
       //Zone de  Cultures 
      Route::resource('culturezones', 'CultureZoneController@index');
      Route::resource('culturezone/new', 'CultureZoneController@create');
      Route::resource('culturezone/save', 'CultureZoneController@store');
      Route::get('culturezone/{id}', array('as'=>'culturezonedetail', 'uses'=> 'CultureZoneController@show'));
      Route::get('culturezone/{id}/modify', array('as'=>'culturezoneedit', 'uses'=> 'CultureZoneController@edit'));
      Route::resource('culturezone/update', 'CultureZoneController@update');

  });

});
