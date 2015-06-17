<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvenementAlerteTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('evenement')){
	      Schema::create('evenement', function($table)
	      {
	        $table->increments('EvenementID');
	        $table->string('Nom', 200);
			$table->string('Description', 2000);
			$table->timestamps();
	      });
	    }
		
		if(!Schema::hasTable('alerte')){
	      Schema::create('alerte', function($table)
	      {
	        $table->increments('AlerteID');
			$table->string('Titre');
			$table->date('DateCreation');
			$table->string('Message', 5000);
			$table->enum('Icone', ['info', 'warning', 'danger', 'success'])->nullable();
			$table->integer('EvenementID')->unsigned();			
			$table->integer('InitiateurID')->unsigned();	
			$table->timestamps();
	      });
		  
		  Schema::table('alerte', function($table){
			$table->foreign('EvenementID')->references('EvenementID')->on('evenement');
			$table->foreign('InitiateurID')->references('UtilisateurID')->on('utilisateur');					
		  });
	    }
		
		if(!Schema::hasTable('alerte_destinataire')){
	      Schema::create('alerte_destinataire', function($table)
	      {
	        $table->increments('AlerteDestinataireID');
			$table->integer('AlerteID')->unsigned();
			$table->enum('DestinataireType', ['UTILISATEUR', 'PAYS', 'REGION', 'VILLE', 'VILLAGE']);
			$table->integer('DestinataireID')->unsigned();
			$table->enum('MoyenEnvoie', ['EMAIL', 'SLACK', 'SMS', 'TELEPHONE', 'TWITTER', 'FACEBOOK']);
			$table->enum('StatutEnvoie', ['BROUILLON', 'ENCOURS', 'ENVOYE']);
			$table->timestamps();
	      });
		  
		  Schema::table('alerte_destinataire', function($table){
			$table->foreign('AlerteID')->references('AlerteID')->on('alerte');			
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
		Schema::dropIfExists('alerte_destinataire');
		Schema::dropIfExists('alerte');
		Schema::dropIfExists('evenement');
	}

}
