<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNegociationProduction extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if(!Schema::hasTable('negociationproduction')){
	      Schema::create('negociationproduction', function($table)
	      {
	        $table->increments('NegociationProductionID');
	        $table->double('Prix', 15, 0);
			$table->integer('AcheteurID')->unsigned();
			$table->integer('ProductionID')->unsigned();
			$table->date('DateProposition');
			$table->enum('StatutProposition', ['PREPARATION', 'PUBLIE']);
			$table->timestamps();
	      });
		  
		  Schema::table('negociationproduction', function($table){
			$table->foreign('AcheteurID')->references('UtilisateurID')->on('utilisateur');
			$table->foreign('ProductionID')->references('ProductionID')->on('production');			
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
		Schema::dropIfExists('negociationproduction');
	}

}
