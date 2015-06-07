<?php 

use Illuminate\Support\Facades\Config;
use Symfony\Component\Process\Exception\InvalidArgumentException;

trait HasRole
{
    public function roles()
    {
        return $this->hasMany('Roles', 'Username', 'Username');
    }

    public function hasRole($name)
    {
        if($this->isadmin){
            return true;
        }

        foreach ($this->roles as $role) {
            //Vériier par rapport aux roles dun super utilisayeur
            if(in_array($name, array('ALERT', 'AGRICULTEUR', 'PRODUCTION'))){
                if ($role->Role == 'SUPERUTILISATEUR') {
                    return true;
                }
            }

            //Vérifier par rapport à un opérateur
            if(in_array($name, array('ALERT', 'AGRICULTEUR', 'PRODUCTION'))){
                if ($role->Role == 'OPERATEUR') {
                    return true;
                }
            }

            //rechercher le role spécifique
            if ($role->Role == $name) {
                return true;
            }
        }

        return false;
    }

}
