<?php

class NegociationProductionTest extends TestCase {

  public function testCrudNegociationProduction()
  {
    $user = new User();
    $user->login(array('email' => 'achat1', 'password' => 'achat1'));

    $negociationproduction1 = array();
    $negociationproduction1['Prix'] = 100; //Prix proposé par l'acheteur
    $negociationproduction1['ProductionID'] = 1; //C'est la reference vers la personne qui a appartient la culture ou l'elevage
    $negociationproduction1['StatutProposition'] = 'PREPARATION'; // PREPARATION, PUBLIE Une proposition peut-etre validée par une persone autorisée. Dans ce cas, elle est pousée vers l'agriculteur' 
    
    //Création entité
    $response = $this->call('POST', '/negociationproduction/1/store', $negociationproduction1);
    $this->assertResponseStatus(302);
  
    //Vérifier la redirection vers la vue
    $this->assertRedirectedTo('production/1');
    $this->assertSessionHas('success');
    
    //Vérifier que la réponse contient l'url  pour modification
    $message = $response->getSession()->get('success');
    $content = $response->getContent();
    $pattern = "/negociationproduction\/1\/edit\/([\d]+)/";
    $this->assertRegExp($pattern, $message);
    preg_match_all($pattern, $message, $negociationproductionIdFinded);
    $this->assertCount(2, $negociationproductionIdFinded, "Après la création, la vue qui suit doit contenir le numero de l'entité dans le lien de modification");

    $negociationproductionId = $negociationproductionIdFinded[1][0];;
    
    //modification des informations 
    $negociationproduction1 = array();
    $negociationproduction1['Prix'] = 100; //Prix proposé par l'acheteur
    $negociationproduction1['StatutProposition'] = 'PREPARATION'; // PREPARATION, PUBLIE Une proposition peut-etre validée par une persone autorisée. Dans ce cas, elle est pousée vers l'agriculteur'
    
    $response = $this->call('POST', '/negociationproduction/1/update/' . $negociationproductionId, $negociationproduction1);
    $this->assertResponseStatus(302);

    $this->assertRedirectedTo('production/1');
    $this->assertSessionHas('success');
    
    //Vérifier que la réponse contient l'url  pour modification
    $message = $response->getSession()->get('success');
    $content = $response->getContent();
    $pattern = "/negociationproduction\/([\d]+)\//";
    $this->assertRegExp($pattern, $message);
    preg_match_all($pattern, $message, $productionIdFinded);
    $this->assertCount(2, $negociationproductionIdFinded, "Après la modification, la vue qui suit doit contenir le numero dans le lien de modification");

    //Suppression
    $response = $this->call('DELETE', '/negociationproduction/' . $negociationproductionId);
    $this->assertResponseStatus(302);

  }

}
