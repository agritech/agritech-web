<?php
/**
 * UserController 
 * {File description}
 * 
 * @author defus
 * @created Nov 13, 2014
 * 
 */

class UserController extends \BaseController {
    
    private $_userModel;

    public function __construct() {
        $this->beforeFilter('auth', array('except' => 'login'));
        $this->beforeFilter('csrf', array('on' => 'post'));
        
        $this->_userModel = new \User();
    }

    public function index() {
        $users = User::get();

        return \View::make('admin.user.index', array(
                    'users' => $users
        ));
    }

    public function create() {
        return \View::make('admin.user.create');
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
          'Username' => 'required|usernameUniqueValide',
          'password' => 'required|min:3|confirmed'
          ), 
        array(
          'Username.required' => "Le login est obligatoire !",
          'Username.username_unique_valide' => 'Le compte existe déja dans le système',
          'password.required' => "Le mot de passe est obligatoire !",
          'password.min' => "Le mot de passe doit avoir au moins 3 caractères !",
          'password.confirmed' => "Les deux mots de passe saisis ne sont pas identiques !"
        )
      );

      if ($validation->fails()) {
          return Redirect::to('admin/user/create')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $user = new User();
          $user->Username = \Input::get('Username');
          $user->isadmin = (\Input::has('isadmin')) ? 1 : 0;
          $user->Mail = \Input::get('Mail');
          $user->nom = \Input::get('nom');
          $user->prenom = \Input::get('prenom');
          $user->date_naissance = \Input::get('date_naissance');
          $user->sexe = \Input::get('sexe');
          $user->telephone = \Input::get('telephone');
          $user->adresse = \Input::get('adresse');
          $user->ville = \Input::get('ville');
          $user->pays = \Input::get('pays');
          $user->fonction = \Input::get('fonction');
          $user->societe = \Input::get('societe');
          $user->password = Hash::make(\Input::get('password'));

          $user->save();

          $modifierUrl = URL::to('admin/user/' . $user->UtilisateurID . '/edit');
          Session::flash('success', "<p>Création effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier</a></p>");
          return Redirect::to('admin/user');  
          
        }
    }


    public function edit($id) {
        $roles = array('SUPERUTILISATEUR' => 'Super utilisateur', 
            'OPERATEUR' => 'Opérateur', 
            'ALERT' => 'Gestion des alertes',
            'RECOLTE' => 'Gestion des récoltes',
            'AGRICULTEUR' => 'Agriculteur',
            'ACHETEUR' => 'Acheteur',
            'PARTENAIRE' => 'Partenaire');

        $user = User::find($id);

        $username = $user->Username; 

        $userroles = Roles::where('Username', $username)->get();

        return \View::make('admin.user.edit', array(
                    'user' => $user,
                    'roles' => $roles,
                    'userroles' => $userroles
        ));
    }

    public function update($id){
      $validation = Validator::make(\Input::all(), 
        array(
          'Username' => 'required',
          'password' => 'confirmed'
          ), 
        array(
          'Username.required' => "Le login est obligatoire !",
          'password.confirmed' => "Les deux mots de passe saisis ne sont pas identiques !"
        )
      );

      if ($validation->fails()) {
          return Redirect::to('admin/user/' . $id . '/edit')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $user = User::find($id);
          $user->Username = \Input::get('Username');
          $user->isadmin = (\Input::has('isadmin')) ? 1 : 0;
          $user->Mail = \Input::get('Mail');
          $user->nom = \Input::get('nom');
          $user->prenom = \Input::get('prenom');
          $user->date_naissance = \Input::get('date_naissance');
          $user->sexe = \Input::get('sexe');
          $user->telephone = \Input::get('telephone');
          $user->adresse = \Input::get('adresse');
          $user->ville = \Input::get('ville');
          $user->pays = \Input::get('pays');
          $user->fonction = \Input::get('fonction');
          $user->societe = \Input::get('societe');
          $password = \Input::get('password');
          if(!empty($password)){
            $user->password = Hash::make(\Input::get('password'));
          }
          
          $user->save();

          $modifierUrl = URL::to('admin/user/' . $user->UtilisateurID . '/edit');
          Session::flash('success', "<p>Mise-à-jour effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier</a></p>");
          return Redirect::to('admin/user');
        }
    }


    public function destroy($id) {
        $user = User::find($id);
        $user->delete();

        return \Redirect::to('admin/user')
                        ->with('message', 'Utilisateur supprimé avec succès');
    }

    public function login() {
        $input = \Input::all();
        if (!empty($input)) {
            $add = $this->_userModel->login(\Input::all());
            if (TRUE === $add) {
                //Enregistrer la date de connexion
                $user = User::where('Username', \Input::get('email'))->firstOrFail();
                $loginDate = \Carbon\Carbon::now();
                $user->login_date = $loginDate->toDateTimeString();
                $user->save();
                //Rediriger vers l'accueil
                return \Redirect::to('');
            } else {
                return \Redirect::to(\Request::url())
                                ->withErrors($add)
                                ->withInput();
            }
        }
        return \View::make('user.login');
    }
    
    public function logout(){
        \Auth::logout();
        return \Redirect::to( '/login' );
    }
    
    public function photoGet($id, $photo){
        $filePath = storage_path() . DIRECTORY_SEPARATOR. 'admin' .DIRECTORY_SEPARATOR. 'user' .DIRECTORY_SEPARATOR. $id . DIRECTORY_SEPARATOR . $photo;
        if ( ! File::exists($filePath) or ( ! $mimeType = $this->getImageContentType($filePath))){
            return Response::make("Le fichier n'existe pas.", 404);
        }
        $fileContents = File::get($filePath);
        return Response::make($fileContents, 200, array('Content-Type' => $mimeType));
    }
    
    public function photoPost($id){
      $validation = Validator::make(\Input::all(), 
        array(
          'photo' => 'required'
          ), 
        array(
          'photo.required' => "La photo est obligatoire"
        )
      );

      if ($validation->fails()) {
          return Redirect::to('admin/user/' . $id . '/edit')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $user = User::find($id);
          $input = \Input::all();
          if (Input::hasFile('photo')){
            $file = Input::file('photo');
            $file_dir = storage_path() . DIRECTORY_SEPARATOR .'admin' . DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . $id;
            $file->move($file_dir, $file->getClientOriginalName());
            if( ! $mimeType = $this->getImageContentType($file_dir . DIRECTORY_SEPARATOR . $file->getClientOriginalName())){
                //supprimer le fichier uploader
                //rediriger vers la page d'accueil
                return Redirect::to('admin/user/' . $id . '/edit')
                  //->withErrors(array('0' => 'Type de fichier non supporté'))
                  ->withInput(\Input::all());
            }
            
            $user->photo = $file->getClientOriginalName();
            $user->save();

            $modifierUrl = URL::to('admin/user/' . $user->UtilisateurID . '/edit');
            Session::flash('success', "<p>Mise-à-jour effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier</a></p>");
            return Redirect::to('admin/user/' . $user->UtilisateurID . '/edit');
          }
        }
    }

    private function objectsToArray($objs, $key, $val){
      $arr = array();
      foreach($objs as $obj){
        $arr[$obj->$key] = $obj->$val;
      }
      return $arr;
    }
    
    private function getImageContentType($file){
        $contentType = false;
        //$mime = exif_imagetype($file);
        $size = getimagesize($file);
        if( $size !== FALSE ){
            if ($size[2] === IMAGETYPE_JPEG) {
                $contentType = 'image/jpeg';    
            } 
            elseif ($size[2] === IMAGETYPE_GIF) {
                $contentType = 'image/gif';    
            }
            else if ($size[2] === IMAGETYPE_PNG){
                $contentType = 'image/png';    
            }    
        } 
        return $contentType;
    }
}