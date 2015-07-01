<?php
	
class ProductionDatabaseSeeder	extends Seeder {
	
	public function run()
	{
		Eloquent::unguard();

		$this->call('ProdDataSeeder');
		$this->command->info('Database for production seeded!');
	}
}

class ProdDataSeeder extends TestDataSeeder {
	
	public function create_pays(){
		if (($handle = fopen(app_path() . '/database/seeds/Production_Cultures_F_Afrique_1.csv', "r")) === FALSE) {
			dd('Impossible de trouver le fichier contenant les données pays à importer');
		}
		
		$tableau_head = array();
		$ligneNombre = 0;
		while(($data = fgetcsv($handle, 0, ",")) !== FALSE){
			if(empty($tableau_head)){
				$tableau_head = $data;
			}else{
				$paysNbr = Pays::where('Ref', $data[0])->count();
				if($paysNbr == 0){
					Pays::create(array('Ref' => $data[0], 'Nom' => $data[1]));
					echo("Pays : " . $data[1] . " ajouté avec succès\n");
				}
			}
		}
		fclose($handle);
	}
	
	public function create_produit(){
		if (($handle = fopen(app_path() . '/database/seeds/Production_Cultures_F_Afrique_1.csv', "r")) === FALSE) {
			dd('Impossible de trouver le fichier contenant les données pays à importer');
		}
		
		$tableau_head = array();
		$ligneNombre = 0;
		while(($data = fgetcsv($handle, 0, ",")) !== FALSE){
			if(empty($tableau_head)){
				$tableau_head = $data;
			}else{
				$produitNbr = Produit::where('Ref', $data[2])->count();
				if($produitNbr == 0){
					Produit::create(array('Ref' => $data[2], 'Nom' => $data[3]));
					echo("Produit : " . $data[3] . " ajouté avec succès\n");
				}
			}
		}
		fclose($handle);
	}
}