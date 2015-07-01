<?php

class VilleTest extends TestCase {

  public function testCrudVille()
  {
    $user = new User();
    $user->login(array('email' => 'admin', 'password' => 'admin'));

    $ville = array();
    $ville['Ref'] = 'V1'; 
    $ville['Nom'] = 'Yaoundé';
    $ville['PaysID'] = 1;
    $ville['Description'] = "test test test";
    
    //Création entité
    $response = $this->call('POST', '/admin/ville', $ville);

    //Vérifier la redirection vers la vue
    $this->assertRedirectedTo('admin/ville');
    $this->assertSessionHas('success');
    
    //Vérifier que la réponse contient l'url  pour modification
    $message = $response->getSession()->get('success');
    $content = $response->getContent();
    $pattern = "/admin\/ville\/([\d]+)\//";
    $this->assertRegExp($pattern, $message);
    preg_match_all($pattern, $message, $villeIdFinded);
    $this->assertCount(2, $villeIdFinded, "Après la création, la vue qui suit doit contenir le numero de l'entité dans le lien de modification");

    $villeId = $villeIdFinded[1][0];;

    //modification des informations 
    $ville = array();
    $ville['Ref'] = 'V1'; 
    $ville['Nom'] = 'Yaoundé';
    $ville['PaysID'] = 1;
    $ville['Description'] = "test test test";
    
    $response = $this->call('PUT', '/admin/ville/' . $villeId, $ville);

    $this->assertRedirectedTo('admin/ville');
    $this->assertSessionHas('success');
    
    //Vérifier que la réponse contient l'url  pour modification
    $message = $response->getSession()->get('success');
    $content = $response->getContent();
    $pattern = "/admin\/ville\/([\d]+)\//";
    $this->assertRegExp($pattern, $message);
    preg_match_all($pattern, $message, $villeIdFinded);
    $this->assertCount(2, $villeIdFinded, "Après la modification, la vue qui suit doit contenir le numero dans le lien de modification");

    //Suppression
    $response = $this->call('DELETE', '/admin/ville/' . $villeId);

  }

}
