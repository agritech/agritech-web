<?php
	
use OAuth2\OAuth2;
use OAuth2\Token_Access;
use OAuth2\Exception as OAuth2_Exception;

use Illuminate\Support\Facades\Facade;

class OAuthController extends \BaseController {
	private $_userModel;
    
    public function __construct() {
        $this->beforeFilter('auth', array('except' => 'login'));
        $this->beforeFilter('csrf', array('on' => 'post'));
        
        $this->_userModel = new \User();
    }
	
    public function login($providerKey){
        if(!in_array($providerKey, array('google', 'facebook'))){
            return Redirect::to('/login');
        }
        
        $provider = OAuth2::provider($providerKey, array(
            'id' => Config::get('agritech.provider.' . $providerKey . '.id'),
            'secret' => Config::get('agritech.provider.' . $providerKey . '.secret'),
        ));
    
        if ( ! isset($_GET['code'])){
            return $provider->authorize();
        }
        else{
            try{
                $params = $provider->access($_GET['code']);
                $token = new Token_Access(array(
                    'access_token' => $params->access_token
                ));
                $oauthUser = $provider->get_user_info($token);
    
                $userProvider = UserProvider::where('provider_uid', $oauthUser['uid'])->where('provider', $providerKey)->first();
                if($userProvider == null){
                    //créer un nouvel utilisateur agriculteur
                    //par la suite, on fera une fonction de merge au niveau du profil
                    $user = new User();
                    $user->Username = $oauthUser['email'];
                    $user->save();
                    
                    $role = new Roles();
                    $role->Username = $user->Username;
                    $role->Role = 'AGRICULTEUR';
                    $role->save();
                    
                    $userProvider = new UserProvider();
                    $userProvider->UtilisateurID = $user->UtilisateurID;
                    $userProvider->provider = $providerKey;
                    $userProvider->provider_uid = $oauthUser['uid'];
                    $userProvider->email = $oauthUser['email'];
                    $userProvider->save();
                }else{
                    $user = User::find($userProvider->UtilisateurID);
                }
                //Authentifier l'utilisateur sur l'application
                Auth::login($user);
            }
            catch (OAuth2_Exception $e){
                show_error('That didnt work: '.$e);
            }
        }
        
        return Redirect::to('/dashboard');
    }
	
}