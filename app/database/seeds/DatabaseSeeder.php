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
        DB::table('negociationrecolte')->delete();
        DB::table('recolte')->delete();
        DB::table('produit')->delete();
        DB::table('roles')->delete();
        DB::table('utilisateur')->delete();

        User::create(array('Mail' => 'admin@agritech.com', 'Username' => 'admin', 'password' => Hash::make('admin'), 'nom' => 'Admin', 'prenom' => 'Utilisateur', 'telephone' => '22793339999', 'isadmin' => 1));
        User::create(array('Mail' => 'agri1@agritech.com', 'Username' => 'agri1', 'password' => Hash::make('agri1'), 'nom' => 'agri1', 'prenom' => 'agri1', 'telephone' => '22790339999', 'isadmin' => 0, 'pays' => 'Niger', 'ville' => 'Dosso'));
        User::create(array('Mail' => 'agri2@agritech.com', 'Username' => 'agri2', 'password' => Hash::make('agri2'), 'nom' => 'agri2', 'prenom' => 'agri2', 'telephone' => '22790339999', 'isadmin' => 0, 'pays' => 'Cameroun', 'ville' => 'Yaoundé'));
		User::create(array('Mail' => 'achat1@agritech.com', 'Username' => 'achat1', 'password' => Hash::make('achat1'), 'nom' => 'achat1', 'prenom' => 'achat1', 'telephone' => '22794339999', 'isadmin' => 0, 'pays' => 'Niger', 'ville' => 'Dosso'));
		User::create(array('Mail' => 'part1@agritech.com', 'Username' => 'part1', 'password' => Hash::make('part1'), 'nom' => 'part1', 'prenom' => 'part1', 'telephone' => '22797339999', 'isadmin' => 0, 'pays' => 'Niger', 'ville' => 'Dosso'));
        
        $admin = User::where('Username', 'admin')->firstOrFail();
        $part1 = User::where('Username', 'part1')->firstOrFail();
        $agri1 = User::where('Username', 'agri1')->firstOrFail();
        $agri2 = User::where('Username', 'agri2')->firstOrFail();
        $achat1 = User::where('Username', 'achat1')->firstOrFail();
        
        Roles::create(array('Username' => $part1->Username, 'Role' => 'PARTENAIRE'));
        Roles::create(array('Username' => $part1->Username, 'Role' => 'RECOLTE')); //Le partenaire gÃ¨re les recoltes en ligne
        Roles::create(array('Username' => $part1->Username, 'Role' => 'NEGOCIATIONRECOLTE')); // Le partenaire gÃ¨re les nÃ©gociations en ligne
        Roles::create(array('Username' => $achat1->Username, 'Role' => 'ACHETEUR')); 
        Roles::create(array('Username' => $achat1->Username, 'Role' => 'NEGOCIATIONRECOLTE')); // L'acheteur gÃ¨re les nÃ©gociations de recolte en ligne
        Roles::create(array('Username' => $agri1->Username, 'Role' => 'AGRICULTEUR'));
        Roles::create(array('Username' => $agri2->Username, 'Role' => 'AGRICULTEUR'));
        
        // Charger les produits
        Produit::create(array('Ref' => 'PAPAYE', 'Nom' => 'Papaye'));
        Produit::create(array('Ref' => 'MANGUE', 'Nom' => 'Mangue'));
        
        $mangue = Produit::where('Ref', 'MANGUE')->firstOrFail();
       
        //Charger les recoltes pour les produit
        $recolte = new Recolte();
        $recolte->Poids = 10;
        $recolte->ProduitID = $mangue->ProduitID;
        $recolte->AgriculteurID = $agri1->UtilisateurID;
        $recolte->DateSoumission = '2015-10-10';
        $recolte->StatutSoumission = 'VALIDE';
        $recolte->CanalSoumission = 'INTERNET';
        $recolte->InitiateurID = $agri1->UtilisateurID;
        $recolte->save();
        
        //Charger les négociations de recoltes
        $negociationrecolte = new NegociationRecolte();
        $negociationrecolte->Prix = 10;
        $negociationrecolte->AcheteurID = $achat1->UtilisateurID;
        $negociationrecolte->RecolteID = $recolte->RecolteID;
        $negociationrecolte->DateProposition = '2015-10-10';
        $negociationrecolte->StatutProposition = 'PREPARATION';
        $negociationrecolte->save();

		// Charger les evenements
		Evenement::create(array('Nom' => 'Meteo', 'Description' => 'Evenement meteorologique (tempête, pluie, vent, ...)'));
		Evenement::create(array('Nom' => 'Travaux', 'Description' => 'Travaux de chantiers...'));
		Evenement::create(array('Nom' => 'Veto', 'Description' => 'Visite veterinaire....'));
		Evenement::create(array('Nom' => 'Entretien', 'Description' => 'Conseil entretien betail'));
		Evenement::create(array('Nom' => 'Service regulation', 'Description' => 'Prix des semences, ...'));
		
		$evenementTempete = Evenement::where('Nom','Meteo')->firstOrFail();
		
		// Charger les alertes
		$alerte = new Alerte();
		$alerte->DateCreation = '2015-05-11';
		$alerte->Message = 'Tempête de sable prevue dans la zone de Dogondoutchi du 18/05 au 21/05 avec tres faible visibilite';
		$alerte->EvenementID = $evenementTempete->EvenementID;
		$alerte->InitiateurID = $admin->UtilisateurID;
		$alerte->save();
		
        // Charger les logs
        $log = new DBLog();
        $log->log_type = 'USER_LIST';
        $log->save();
    }

}
