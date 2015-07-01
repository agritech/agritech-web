<?php

class PaysTest extends TestCase {

  public function testCrudPays()
  {
    $user = new User();
    $user->login(array('email' => 'admin', 'password' => 'admin'));

    $pays = array();
    $pays['Ref'] = 'P1'; 
    $pays['Nom'] = 'Tanzanie';
    $pays['Description'] = "test test test";
    
    //Création entité
    $response = $this->call('POST', '/admin/pays', $pays);

    //Vérifier la redirection vers la vue
    $this->assertRedirectedTo('admin/pays');
    $this->assertSessionHas('success');
    
    //Vérifier que la réponse contient l'url  pour modification
    $message = $response->getSession()->get('success');
    $content = $response->getContent();
    $pattern = "/admin\/pays\/([\d]+)\//";
    $this->assertRegExp($pattern, $message);
    preg_match_all($pattern, $message, $paysIdFinded);
    $this->assertCount(2, $paysIdFinded, "Après la création, la vue qui suit doit contenir le numero de l'entité dans le lien de modification");

    $paysId = $paysIdFinded[1][0];;

    //modification des informations 
    $pays = array();
    $pays['Ref'] = 'P1'; 
    $pays['Nom'] = 'Portugal';
    $pays['Description'] = "test test test";
    
    $response = $this->call('PUT', '/admin/pays/' . $paysId, $pays);

    $this->assertRedirectedTo('admin/pays');
    $this->assertSessionHas('success');
    
    //Vérifier que la réponse contient l'url  pour modification
    $message = $response->getSession()->get('success');
    $content = $response->getContent();
    $pattern = "/admin\/pays\/([\d]+)\//";
    $this->assertRegExp($pattern, $message);
    preg_match_all($pattern, $message, $paysIdFinded);
    $this->assertCount(2, $paysIdFinded, "Après la modification, la vue qui suit doit contenir le numero dans le lien de modification");

    //Suppression
    $response = $this->call('DELETE', '/admin/pays/' . $paysId);

  }

}
