<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersRoleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		
		if(!Schema::hasTable('pays')){
	      Schema::create('pays', function($table)
	      {
	        $table->increments('PaysID');
	        $table->string('Ref');
			$table->string('Nom');
			$table->string('Description')->nullable();
	      });
		  
	    }
		
		if(!Schema::hasTable('ville')){
	      Schema::create('ville', function($table)
	      {
	        $table->increments('VilleID');
	        $table->string('Ref');
			$table->string('Nom');
			$table->string('Description')->nullable();
			$table->integer('PaysID')->unsigned();
	      });
		  
		  Schema::table('ville', function($table){
			$table->foreign('PaysID')->references('PaysID')->on('pays');
		  });
	    }
		
		if(!Schema::hasTable('utilisateur')){
          Schema::create('utilisateur', function($table)
          {
			$table->increments('UtilisateurID');
			$table->string('Username')->unique();
			$table->string('Mail')->nullable();
			$table->string('password');
			$table->string('nom')->nullable();
			$table->string('prenom')->nullable();
			$table->date('date_naissance')->nullable();
			$table->enum('sexe', ['MASCULIN', 'FEMININ'])->nullable();
			$table->string('telephone')->nullable();
			$table->string('adresse')->nullable();
			$table->string('ville')->nullable();
			$table->string('pays')->nullable();
			$table->string('fonction')->nullable();
			$table->string('societe')->nullable();
			$table->string('photo')->nullable();
			$table->string('isadmin', 1)->default(0);
			$table->string('remember_token', 100)->nullable();
			$table->timestamp('login_date')->nullable();
          });
		}
		
		if(!Schema::hasTable('roles')){
	      Schema::create('roles', function($table)
	      {
	        $table->increments('RoleID');
	        $table->string('Username');
			$table->enum('Role', ['OPERATEUR','SUPERUTILISATEUR','ALERT','AGRICULTEUR','ACHETEUR','PARTENAIRE', 'PRODUCTION', 'NEGOCIATIONPRODUCTION'])
				->default('OPERATEUR');
	      });
		  
		  Schema::table('roles', function($table){
			$table->foreign('Username')->references('Username')->on('utilisateur')->onDelete('cascade')->onUpdate('cascade');
		  });
		}
		  
		if(!Schema::hasTable('user_provider')){
	      Schema::create('user_provider', function($table)
	      {
	        $table->increments('UserProviderID');
			$table->integer('UtilisateurID')->unsigned();
	        $table->enum('provider', ['FACEBOOK', 'TWITTER', 'GOOGLE', 'YAHOO']);
			$table->string('provider_uid');
			$table->string('email');
			$table->timestamps();
	      });
	  
		  
		  Schema::table('user_provider', function($table){
			$table->foreign('UtilisateurID')->references('UtilisateurID')->on('utilisateur');
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
		Schema::dropIfExists('user_provider');
		Schema::dropIfExists('roles');
		Schema::dropIfExists('utilisateur');
		Schema::dropIfExists('ville');
		Schema::dropIfExists('pays');
	}

}
