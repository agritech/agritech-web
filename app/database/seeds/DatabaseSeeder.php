<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('TestDataSeeder');
		$this->command->info('Database for tests seeded!');
	}

}

class TestDataSeeder extends Seeder {

    public function run()
    {
        TestDataSeeder::create_user_role();
        
        TestDataSeeder::create_ville();
        
        TestDataSeeder::create_campagne_agricole();
        
        TestDataSeeder::create_produit();
        
        TestDataSeeder::create_exploitation();
       
        TestDataSeeder::create_production();
        
		TestDataSeeder::create_evenement();
		
		TestDataSeeder::create_alerte();
		
        TestDataSeeder::create_db_log();
    }

    public static function create_user_role() {
        
        User::create(array('Mail' => 'admin@agritech.com', 'Username' => 'admin', 'password' => Hash::make('admin'), 'nom' => 'Admin', 'prenom' => 'Utilisateur', 'telephone' => '', 'isadmin' => 1));
        User::create(array('Mail' => 'agri1@agritech.com', 'Username' => 'agri1', 'password' => Hash::make('agri1'), 'nom' => 'agri1', 'prenom' => 'agri1', 'telephone' => '22793339999', 'isadmin' => 0, 'pays' => 'Niger', 'ville' => 'Dosso'));
        User::create(array('Mail' => 'agri2@agritech.com', 'Username' => 'agri2', 'password' => Hash::make('agri2'), 'nom' => 'agri2', 'prenom' => 'agri2', 'telephone' => '', 'isadmin' => 0, 'pays' => 'Cameroun', 'ville' => 'Yaoundé'));
		User::create(array('Mail' => 'achat1@agritech.com', 'Username' => 'achat1', 'password' => Hash::make('achat1'), 'nom' => 'achat1', 'prenom' => 'achat1', 'telephone' => '', 'isadmin' => 0, 'pays' => 'Niger', 'ville' => 'Dosso'));
		User::create(array('Mail' => 'part1@agritech.com', 'Username' => 'part1', 'password' => Hash::make('part1'), 'nom' => 'part1', 'prenom' => 'part1', 'telephone' => '', 'isadmin' => 0, 'pays' => 'Niger', 'ville' => 'Dosso'));
        
        $admin = User::where('Username', 'admin')->firstOrFail();
        $part1 = User::where('Username', 'part1')->firstOrFail();
        $agri1 = User::where('Username', 'agri1')->firstOrFail();
        $agri2 = User::where('Username', 'agri2')->firstOrFail();
        $achat1 = User::where('Username', 'achat1')->firstOrFail();
        
        Roles::create(array('Username' => $part1->Username, 'Role' => 'PARTENAIRE'));
        Roles::create(array('Username' => $part1->Username, 'Role' => 'PRODUCTION')); //Le partenaire gère les productions en ligne
        Roles::create(array('Username' => $part1->Username, 'Role' => 'NEGOCIATIONPRODUCTION')); // Le partenaire gÃ¨re les nÃ©gociations en ligne
        Roles::create(array('Username' => $achat1->Username, 'Role' => 'ACHETEUR')); 
        Roles::create(array('Username' => $achat1->Username, 'Role' => 'NEGOCIATIONPRODUCTION')); // L'acheteur gÃ¨re les nÃ©gociations de production en ligne
        Roles::create(array('Username' => $agri1->Username, 'Role' => 'AGRICULTEUR'));
        Roles::create(array('Username' => $agri1->Username, 'Role' => 'PRODUCTION'));
        Roles::create(array('Username' => $agri1->Username, 'Role' => 'EXPLOITATION'));
        Roles::create(array('Username' => $agri2->Username, 'Role' => 'AGRICULTEUR'));
        Roles::create(array('Username' => $agri2->Username, 'Role' => 'PRODUCTION'));
        Roles::create(array('Username' => $agri2->Username, 'Role' => 'EXPLOITATION'));
        
    }
    
    public static function create_ville(){
        //ville
        Ville::create(array('Ref' => 'V01', 'Nom' => 'Niamey'));
        Ville::create(array('Ref' => 'V01', 'Nom' => 'Rabat'));
        Ville::create(array('Ref' => 'V01', 'Nom' => 'Bandjoun'));
        
    }
    
    public static function create_campagne_agricole(){
        //Charger les campagnes agricoles
        CampagneAgricole::create(array('Ref' => 'C01', 'Nom' => 'Campagne Agricole 2014', 'created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')));
        CampagneAgricole::create(array('Ref' => 'C02', 'Nom' => 'Campagne Agricole 2015', 'created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')));
        
    }
    
    public static function create_produit(){
        // Charger les produits
        Produit::create(array('Ref' => 'PAPAYE', 'Nom' => 'Papaye', 'created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')));
        Produit::create(array('Ref' => 'MANGUE', 'Nom' => 'Mangue', 'created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')));
        
    }
    
    public static function create_exploitation(){
        $admin = User::where('Username', 'admin')->firstOrFail();
        $part1 = User::where('Username', 'part1')->firstOrFail();
        $agri1 = User::where('Username', 'agri1')->firstOrFail();
        $agri2 = User::where('Username', 'agri2')->firstOrFail();
        $achat1 = User::where('Username', 'achat1')->firstOrFail();
        
        $mangue = Produit::where('Ref', 'MANGUE')->firstOrFail();
        $papaye = Produit::where('Ref', 'PAPAYE')->firstOrFail();
        
        $niamey = Ville::where('Ref', 'V01')->firstOrFail();
        
        //Exploitation
        Exploitation::create(array('Ref' => 'E01', 'Nom' => 'Exploitation 1 agri1', 'AgriculteurID'=>$agri1->UtilisateurID, 'VilleID' =>$niamey->VilleID, 'created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')));
        Exploitation::create(array('Ref' => 'E02', 'Nom' => 'Exploitation 2 agri1', 'AgriculteurID'=>$agri1->UtilisateurID, 'VilleID' =>$niamey->VilleID, 'created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')));
        
        $exploitation1 = Exploitation::where('Ref', 'E01')->firstOrFail();
        $exploitation2 = Exploitation::where('Ref', 'E02')->firstOrFail();
        
        //Exploitation produit
        ExploitationProduit::create(array('ProduitID' => $mangue->ProduitID, 'ExploitationID' => $exploitation1->ExploitationID));
        ExploitationProduit::create(array('ProduitID' => $papaye->ProduitID, 'ExploitationID' => $exploitation2->ExploitationID));        
    }
    
    public static function create_production(){
        $admin = User::where('Username', 'admin')->firstOrFail();
        $part1 = User::where('Username', 'part1')->firstOrFail();
        $agri1 = User::where('Username', 'agri1')->firstOrFail();
        $agri2 = User::where('Username', 'agri2')->firstOrFail();
        $achat1 = User::where('Username', 'achat1')->firstOrFail();
        
        $campagne2015 = CampagneAgricole::where('Ref', 'C02')->firstOrFail();
        
        $mangue = Produit::where('Ref', 'MANGUE')->firstOrFail();
        $papaye = Produit::where('Ref', 'PAPAYE')->firstOrFail();
        
        $exploitation1 = Exploitation::where('Ref', 'E01')->firstOrFail();
        $exploitation2 = Exploitation::where('Ref', 'E02')->firstOrFail();
        
        //Charger les productions pour les produit
        $production = new Production();
        $production->Poids = 10;
        $production->ProduitID = $mangue->ProduitID;
        $production->AgriculteurID = $agri1->UtilisateurID;
        $production->DateSoumission = '2015-10-10';
        $production->StatutSoumission = 'VALIDE';
        $production->CanalSoumission = 'INTERNET';
        $production->InitiateurID = $agri1->UtilisateurID;
        $production->CampagneAgricoleID = $campagne2015->CampagneAgricoleID;
        $production->ExploitationID = $exploitation1->ExploitationID;
        $production->save();
        
        //Charger les négociations de productions
        $negociationproduction = new NegociationProduction();
        $negociationproduction->Prix = 10;
        $negociationproduction->AcheteurID = $achat1->UtilisateurID;
        $negociationproduction->ProductionID = $production->ProductionID;
        $negociationproduction->DateProposition = '2015-10-10';
        $negociationproduction->StatutProposition = 'PREPARATION';
        $negociationproduction->save();

    }
    
    public static function create_evenement(){
        // Charger les evenements
		Evenement::create(array('Nom' => 'Meteo', 'Description' => 'Evenement meteorologique (tempête, pluie, vent, sècheresse...)'));
		Evenement::create(array('Nom' => 'Travaux', 'Description' => 'Travaux de chantiers...'));
		Evenement::create(array('Nom' => 'Sanitaire', 'Description' => 'Problèmes santaires'));
		Evenement::create(array('Nom' => 'Engrais', 'Description' => 'Conseil engrais'));
		Evenement::create(array('Nom' => 'Invasion', 'Description' => 'Invasions de criquets et autre, ...'));
		
    }
    
    public static function create_alerte(){
        $admin = User::where('Username', 'admin')->firstOrFail();
        $part1 = User::where('Username', 'part1')->firstOrFail();
        $agri1 = User::where('Username', 'agri1')->firstOrFail();
        $agri2 = User::where('Username', 'agri2')->firstOrFail();
        $achat1 = User::where('Username', 'achat1')->firstOrFail();
        
        $evenementTempete = Evenement::where('Nom','Meteo')->firstOrFail();
        
        // Charger les alertes
		$alerte = new Alerte();
        $alerte->Titre = "Tempête de sable sur Dogondoutchi";
		$alerte->DateCreation = '2015-05-11';
		$alerte->Message = 'Tempête de sable prevue dans la zone de Dogondoutchi du 18/05 au 21/05 avec tres faible visibilite';
		$alerte->EvenementID = $evenementTempete->EvenementID;
		$alerte->InitiateurID = $admin->UtilisateurID;
        $alerte->Icone = 'info';
        $alerte->save();
        $alerte->Destinataires()->saveMany(array(
            new AlerteDestinataire(array('DestinataireType' => 'PAYS','DestinataireID' => 1, 'MoyenEnvoie' => 'EMAIL', 'StatutEnvoie' => 'BROUILLON')),
            new AlerteDestinataire(array('DestinataireType' => 'REGION','DestinataireID' => 1, 'MoyenEnvoie' => 'SLACK', 'StatutEnvoie' => 'BROUILLON')))
        );
		
    }
    
    public static function create_db_log(){
        // Charger les logs
        $log = new DBLog();
        $log->log_type = 'USER_LIST';
        $log->save();
    }
}
