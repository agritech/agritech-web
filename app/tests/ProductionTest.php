<?php

class ProductionTest extends TestCase {

  public function testCrudProduction()
  {
    $user = new User();
    $user->login(array('email' => 'part1', 'password' => 'part1'));

    $production1 = array();
    $production1['Poids'] = 100; //Poids de la production (kg)
    $production1['ProduitID'] = 1; //Reference au produit produit
    $production1['AgriculteurID'] = 1; //C'est la reference vers la personne qui a appartient la culture ou l'elevage
    $production1['DateSoumission'] = '10/05/2015';
    $production1['StatutSoumission'] = 'SOUMIS'; // SOUMIS, VALIDE
    $production1['CanalSoumission'] = 'INTERNET'; //INTERNET, SMS, TELEPHONE
    
    //Création entité
    $response = $this->call('POST', '/production', $production1);

    //Vérifier la redirection vers la vue
    $this->assertRedirectedTo('production');
    $this->assertSessionHas('success');
    
    //Vérifier que la réponse contient l'url  pour modification
    $message = $response->getSession()->get('success');
    $content = $response->getContent();
    $pattern = "/production\/([\d]+)\//";
    $this->assertRegExp($pattern, $message);
    preg_match_all($pattern, $message, $productionIdFinded);
    $this->assertCount(2, $productionIdFinded, "Après la création, la vue qui suit doit contenir le numero de l'entité dans le lien de modification");

    $productionId = $productionIdFinded[1][0];;

    //modification des informations 
    $production1 = array();
    $production1['Poids'] = 100; //Poids de la production (kg)
    $production1['ProduitID'] = 1; //Reference au produit produit
    $production1['AgriculteurID'] = 1; //C'est la reference vers la personne qui a soumis la culture ou l'elevage
    $production1['DateSoumission'] = '10/05/2015';
    $production1['StatutSoumission'] = 'SOUMIS'; // SOUMIS, VALIDE
    $production1['CanalSoumission'] = 'INTERNET'; //INTERNET, SMS, TELEPHONE
    
    $response = $this->call('PUT', '/production/' . $productionId, $production1);

    $this->assertRedirectedTo('production');
    $this->assertSessionHas('success');
    
    //Vérifier que la réponse contient l'url  pour modification
    $message = $response->getSession()->get('success');
    $content = $response->getContent();
    $pattern = "/production\/([\d]+)\//";
    $this->assertRegExp($pattern, $message);
    preg_match_all($pattern, $message, $productionIdFinded);
    $this->assertCount(2, $productionIdFinded, "Après la modification, la vue qui suit doit contenir le numero dans le lien de modification");

    //Suppression
    $response = $this->call('DELETE', '/production/' . $productionId);

  }

}
