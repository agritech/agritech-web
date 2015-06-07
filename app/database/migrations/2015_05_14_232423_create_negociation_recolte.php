<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNegociationRecolte extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('negociationrecolte')){
	      Schema::create('negociationrecolte', function($table)
	      {
	        $table->increments('NegociationRecolteID');
	        $table->double('Prix', 15, 0);
			$table->integer('AcheteurID')->unsigned();
			$table->integer('RecolteID')->unsigned();
			$table->date('DateProposition');
			$table->enum('StatutProposition', ['PREPARATION', 'PUBLIE']);
			$table->timestamps();
	      });
		  
		  Schema::table('negociationrecolte', function($table){
			$table->foreign('AcheteurID')->references('UtilisateurID')->on('utilisateur');
			$table->foreign('RecolteID')->references('ProductionID')->on('production');			
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
		Schema::dropIfExists('negociationrecolte');
	}

}
