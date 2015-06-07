<?php

class ProductionSMSTest extends TestCase {

  public function testCrudProduction()
  {
    $user = new User();
    $user->login(array('email' => 'part1', 'password' => 'part1'));
    
    
	//La collecte des production par SMS se fait en envoyant par SMS 
    $dataSubmission = array();
    $dataSubmission['sender'] = '22793339999'; // Envoye par la gateway en meme temps que le SMS
    $dataSubmission['sendtime'] = '2015-05-15'; // De meme
    $dataSubmission['param'] = 'Mangue 50'; // Contenu du message
    
    //Création entité
    $response = $this->call('GET', '/production/addsms/ajax', $dataSubmission);

    //Vérifier la redirection vers la vue
    $this->assertRedirectedTo('');
    $this->assertSessionHas('success');
    
    //Vérifier que la réponse contient l'url  pour modification
    $message = $response->getSession()->get('success');
    $content = $response->getContent();
    $pattern = "/production\/([\d]+)\//";
    $this->assertRegExp($pattern, $message);
    preg_match_all($pattern, $message, $productionIdFinded);
    $this->assertCount(2, $productionIdFinded, "Après la création, la vue qui suit doit contenir le numero de l'entité dans le lien de modification");

    $productionId = $productionIdFinded[1][0];;

    //Suppression
    $response = $this->call('DELETE', '/production/' . $productionId);

  }

}
