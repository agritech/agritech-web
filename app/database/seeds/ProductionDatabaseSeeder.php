<?php
	
class ProductionDatabaseSeeder	extends Seeder {
	
	public function run()
	{
		Eloquent::unguard();

		$this->call('ProdDataSeeder');
		$this->command->info('Database for production seeded!');
	}
}

class ProdDataSeeder extends Seeder {
	
	public function run(){
		
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
}