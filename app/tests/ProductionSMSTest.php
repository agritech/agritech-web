<?php

class ProductionSMSTest extends TestCase {
  
  public function testSendSmsKoMessageIncorrect(){
    //La collecte des production par SMS se fait en envoyant par SMS 
    $dataSubmission = array();
    $dataSubmission['sender'] = '22793339999'; // Envoye par la gateway en meme temps que le SMS
    $dataSubmission['sendtime'] = '2015-05-15'; // De meme
    $dataSubmission['param'] = 'PAPAYE 500'; // Contenu du message incorrect
    
    //Execution
    $this->call('GET', '/production/addsms/ajax', $dataSubmission);
    
    $this->assertResponseStatus(500);
    
     $this->assertEquals("La requête doit-être de la forme <REFERENCE Exploitation> <REFERENCE Produit> <Quantité produite>", $this->client->getResponse()->getContent());
  }
  
  public function testSendSmsKoExploitationIncorrect(){
    //La collecte des production par SMS se fait en envoyant par SMS 
    $dataSubmission = array();
    $dataSubmission['sender'] = '22793339999'; // Envoye par la gateway en meme temps que le SMS
    $dataSubmission['sendtime'] = '2015-05-15'; // De meme
    $dataSubmission['param'] = 'E100 PAPAYE 500'; // Contenu du message incorrect
    
    //Création entité
    $response = $this->call('GET', '/production/addsms/ajax', $dataSubmission);
    
    $this->assertResponseStatus(500);
    
    $this->assertEquals("La référence de l'exploitation n'est pas valide", $this->client->getResponse()->getContent());
  }
  
  public function testSendSmsKoProduitIncorrect(){
    //La collecte des production par SMS se fait en envoyant par SMS 
    $dataSubmission = array();
    $dataSubmission['sender'] = '22793339999'; // Envoye par la gateway en meme temps que le SMS
    $dataSubmission['sendtime'] = '2015-05-15'; // De meme
    $dataSubmission['param'] = 'E01 FAKE 500'; // Contenu du message incorrect
    
    //Appel
    $response = $this->call('GET', '/production/addsms/ajax', $dataSubmission);
    
    //Validation
    $this->assertResponseStatus(500);
    
    //Test contenu
    $this->assertEquals("La référence du produit n'est pas valide", $this->client->getResponse()->getContent());
  }
  
  public function testSendSmsKoTelephoneIncorrect(){
    //La collecte des production par SMS se fait en envoyant par SMS 
    $dataSubmission = array();
    $dataSubmission['sender'] = 'FAKE'; // Envoye par la gateway en meme temps que le SMS
    $dataSubmission['sendtime'] = '2015-05-15'; // De meme
    $dataSubmission['param'] = 'E01 PAPAYE 500'; // Contenu du message incorrect
    
    //Création entité
    $response = $this->call('GET', '/production/addsms/ajax', $dataSubmission);
    
    $this->assertResponseStatus(500);
    
    $this->assertEquals("Le numero de telephone est inexistant", $this->client->getResponse()->getContent());
  }
  
  public function testSendSmsKoValidationErrorIncorrect(){
    //La collecte des production par SMS se fait en envoyant par SMS 
    $dataSubmission = array();
    $dataSubmission['sender'] = '22793339999'; // Envoye par la gateway en meme temps que le SMS
    $dataSubmission['sendtime'] = '2015-05-15'; // De meme
    $dataSubmission['param'] = 'E01 PAPAYE 500,60'; // Contenu du message incorrect
    
    //Création entité
    $response = $this->call('GET', '/production/addsms/ajax', $dataSubmission);
    
    $this->assertResponseStatus(500);
    
    $this->assertEquals('{"Poids":["Le poids doit-\u00eatre au format (#0,00) avec deux chiffres apr\u00e8s la virgule"]}', $this->client->getResponse()->getContent());
  }
  
  public function testSendSmsOk()
  {
    //La collecte des production par SMS se fait en envoyant par SMS 
    $dataSubmission = array();
    $dataSubmission['sender'] = '22793339999'; // Envoye par la gateway en meme temps que le SMS
    $dataSubmission['sendtime'] = '2015-05-15'; // De meme
    $dataSubmission['param'] = 'E02 PAPAYE 500'; // Contenu du message
    
    //Création entité
    $response = $this->call('GET', '/production/addsms/ajax', $dataSubmission);
    
    $this->assertEquals("Votre production de 500  du produit (Papaye) de votre exploitation (Exploitation 2 agri1) a bien été enregistrée. Merci !", $this->client->getResponse()->getContent());
    
    $this->assertResponseOk();
  }

}
