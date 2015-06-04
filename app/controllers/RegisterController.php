<?php
/**
 * UserController 
 * {File description}
 * 
 * @author defus
 * @created Nov 13, 2014
 * 
 */
class RegisterController extends \BaseController {
    
    public function __construct() {
        $this->beforeFilter('csrf', array('on' => 'post'));
    }

    public function create() {
        return \View::make('register.create');
    }

    public function store(){
        Validator::extend('usernameUniqueValide', function($attribute, $value, $parameters){
            if(empty($value)){
                return false;
            }
            $user = User::where('Username', $value)->first();
            if($user != null){
                return false;
            }
            return true;
        });
        
        $validation = Validator::make(\Input::all(), 
            array(
                'email' => 'required|usernameUniqueValide',
                'password' => 'required|confirmed'
            ), 
            array(
                'email.required' => "Le login est obligatoire",
                'email.username_unique_valide' => 'Le compte existe déja dans le système',
                'password.required' => "Le mot de passe est obligatoire",
                'password.confirmed' => "Les deux mots de passe saisis ne sont pas identiques !"
            )
        );

        if ($validation->fails()) {
            return Redirect::to('register')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
            try{
                $user = new User();
                $user->Username = \Input::get('email');
                $user->Mail = \Input::get('email');
                $user->nom = \Input::get('nom');
                $user->prenom = \Input::get('prenom');
                $user->telephone = \Input::get('telephone');
                $password = \Input::get('password');
                if(!empty($password)){
                $user->password = Hash::make($password);
                }
                
                $user->save();
                
                $role = new Roles();
                $role->Username = $user->Username;
                $role->Role = 'AGRICULTEUR';
                $role->save();
                
            }catch(\Exception $e){
                Log::error($e);
                return Redirect::to('register')
                    ->withInput(\Input::all());        
            }
            Session::flash('success', "<p>Votre compte (agriculteur) a été créé avec succès !<br><small>Si vous souhaitez avoir les fonctionnalités acheteurs, partenaire et professionnels, prière de nous contacter</small></p>");
            return Redirect::to('login');
            
        }
    }
    
}