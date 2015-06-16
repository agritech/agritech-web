<?php

class ProduitTest extends TestCase {

  public function testCrudProduit()
  {
    $user = new User();
    $user->login(array('email' => 'admin', 'password' => 'admin'));

    $produit = array();
    $produit['Ref'] = 'PP1'; //Référence du produit
    $produit['Nom'] = 'PP1'; //Nom du produit
    
    //Création entité
    $response = $this->call('POST', '/admin/produit', $produit);

    //Vérifier la redirection vers la vue
    $this->assertRedirectedTo('admin/produit');
    $this->assertSessionHas('success');
    
    //Vérifier que la réponse contient l'url  pour modification
    $message = $response->getSession()->get('success');
    $content = $response->getContent();
    $pattern = "/admin\/produit\/([\d]+)\//";
    $this->assertRegExp($pattern, $message);
    preg_match_all($pattern, $message, $produitIdFinded);
    $this->assertCount(2, $produitIdFinded, "Après la création, la vue qui suit doit contenir le numero de l'entité dans le lien de modification");

    $produitId = $produitIdFinded[1][0];;

    //modification des informations 
    $produit = array();
    $produit['Ref'] = 'PP1'; //Référence du produit
    $produit['Nom'] = 'PP1'; //Nom du produit
    
    $response = $this->call('PUT', '/admin/produit/' . $produitId, $produit);

    $this->assertRedirectedTo('admin/produit');
    $this->assertSessionHas('success');
    
    //Vérifier que la réponse contient l'url  pour modification
    $message = $response->getSession()->get('success');
    $content = $response->getContent();
    $pattern = "/admin\/produit\/([\d]+)\//";
    $this->assertRegExp($pattern, $message);
    preg_match_all($pattern, $message, $produitIdFinded);
    $this->assertCount(2, $produitIdFinded, "Après la modification, la vue qui suit doit contenir le numero dans le lien de modification");

    //Suppression
    $response = $this->call('DELETE', '/admin/produit/' . $produitId);

  }

}
