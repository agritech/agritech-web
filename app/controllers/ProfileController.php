<?php
/**
 * UserController 
 * {File description}
 * 
 * @author defus
 * @created Nov 13, 2014
 * 
 */
class ProfileController extends \BaseController {
    
    private $_userModel;

    public function __construct() {
        $this->beforeFilter('auth', array('except' => 'login'));
        $this->beforeFilter('csrf', array('on' => 'post'));
        
        $this->_userModel = new \User();
    }

    public function show($id) {
        $user = User::find($id);
        
        $userProvider = new stdClass;
        $userProvider->facebookLogin = null;
        $userProvider->twitterLogin = null;
        $userProvider->yahooLogin = null;
        $userProvider->googleLogin = null;
        
        return \View::make('profile.show', array(
            'user' => $user, 'userProvider'=> $userProvider
        ));
    }

    public function edit($id) {
        if($id != Auth::user()->UtilisateurID){
        return Redirect::to('profile/' . $id)
            ->withError("Impossible de modifier le profile d'un autre utilisateur");
        }
        
        $user = User::find($id);

        return \View::make('profile.edit', array(
            'user' => $user
        ));
    }

    public function update($id){
      if($id != Auth::user()->UtilisateurID){
          return Redirect::to('profile/' . $id)
              ->withError("Impossible de modifier le profile d'un autre utilisateur");
      }
      
      $validation = Validator::make(\Input::all(), 
        array(
          'password' => 'confirmed'
          ), 
        array(
          'password.confirmed' => "Les deux mots de passe saisis ne sont pas identiques !"
        )
      );

      if ($validation->fails()) {
          return Redirect::to('profile/' . $id . '/edit')
              ->withErrors($validation)
              ->withInput(\Input::all());
        } else {
          $user = User::find($id);
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
            $user->password = Hash::make($password);
          }
          
          $user->save();

          $modifierUrl = URL::to('profile/' . $user->UtilisateurID . '/edit');
          Session::flash('success', "<p>Mise-à-jour effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier</a></p>");
          return Redirect::to('profile/' . $user->UtilisateurID );
        }
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
          return Redirect::to('profile/' . $id . '/edit')
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
                return Redirect::to('profile/' . $id . '/edit')
                  //->withErrors(array('0' => 'Type de fichier non supporté'))
                  ->withInput(\Input::all());
            }
            
            $user->photo = $file->getClientOriginalName();
            $user->save();

            $modifierUrl = URL::to('profile/' . $user->UtilisateurID . '/edit');
            Session::flash('success', "<p>Mise-à-jour effectuée avec succès ! <a href='{$modifierUrl}' class='btn btn-success'>Modifier</a></p>");
            return Redirect::to('profile/' . $user->UtilisateurID);
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