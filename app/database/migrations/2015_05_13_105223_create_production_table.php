<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('campagne_agricole')){
			Schema::create('campagne_agricole', function($table){
				$table->increments('CampagneAgricoleID');
				$table->string('Ref');
				$table->string('Nom');
				$table->timestamps();
			});
			
		}
		
		if(!Schema::hasTable('produit')){
	      Schema::create('produit', function($table)
	      {
	        $table->increments('ProduitID');
	        $table->string('Ref', 200);
			$table->string('Nom', 2000);
	      });
	    }
		
		if(!Schema::hasTable('exploitation')){
			Schema::create('exploitation', function($table){
				$table->increments('ExploitationID');
				$table->string('Ref');
				$table->string('Nom');
				$table->integer('AgriculteurID')->unsigned();
				$table->timestamps();
			});
			
			Schema::table('exploitation', function($table){
				$table->foreign('AgriculteurID')->references('UtilisateurID')->on('utilisateur');
		  });
		}
		
		if(!Schema::hasTable('exploitation_produit')){
			Schema::create('exploitation_produit', function($table){
				$table->increments('ExploitationProduitID');
				$table->integer('ExploitationID')->unsigned();
				$table->integer('ProduitID')->unsigned();
			});
			
			Schema::table('exploitation_produit', function($table){
				$table->foreign('ExploitationID')->references('ExploitationID')->on('exploitation');
				$table->foreign('ProduitID')->references('ProduitID')->on('produit');
		  });
		}
		
		if(!Schema::hasTable('production')){
	      Schema::create('production', function($table)
	      {
	        $table->increments('ProductionID');
	        $table->double('Poids', 15, 2);
			$table->integer('ProduitID')->unsigned();
			$table->integer('AgriculteurID')->unsigned();
			$table->date('DateSoumission');
			$table->enum('StatutSoumission', ['SOUMIS', 'VALIDE']);
			$table->enum('CanalSoumission', ['INTERNET', 'SMS', 'TELEPHONE']);
			$table->integer('InitiateurID')->unsigned();
			$table->integer('CampagneAgricoleID')->unsigned();
			$table->integer('ExploitationID')->unsigned();
			$table->timestamps();
	      });
		  
		  Schema::table('production', function($table){
			$table->foreign('ProduitID')->references('ProduitID')->on('produit');
			$table->foreign('AgriculteurID')->references('UtilisateurID')->on('utilisateur');
			$table->foreign('InitiateurID')->references('UtilisateurID')->on('utilisateur');
			$table->foreign('CampagneAgricoleID')->references('CampagneAgricoleID')->on('campagne_agricole');
			$table->foreign('ExploitationID')->references('ExploitationID')->on('exploitation');
		  });
	    }
		
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('production');
		Schema::dropIfExists('exploitation_produit');
		Schema::dropIfExists('exploitation');
		Schema::dropIfExists('produit');
		Schema::dropIfExists('campagne_agricole');
	}

}
