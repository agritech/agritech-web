<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('logs', function(Blueprint $table)
		{
			$table->increments('DBLogID');
			$table->enum('log_type', ['USER_LIST','USER_VIEW','USER_EDIT','USER_NEW','USER_CREATE','USER_UPDATE', 'USER_DELETE',
				'PROFILE_VIEW',
				'AGRICULTEUR_LOGIN','AGRICULTEUR_LOGOUT',
				'ACHETEUR_LOGIN','ACHETEUR_LOGOUT',
				'PARTENAIRE_LOGIN','PARTENAIRE_LOGOUT',
				'PRODUCTION_LIST', 'PRODUCTION_VIEW','PRODUCTION_EDIT', 'PRODUCTION_NEW', 'PRODUCTION_CREATE', 'PRODUCTION_UPDATE', 'PRODUCTION_DELETE',
				'NEGOCIATIONPRODUCTION_LIST', 'NEGOCIATIONPRODUCTION_VIEW','NEGOCIATIONPRODUCTION_EDIT', 'NEGOCIATIONPRODUCTION_NEW', 'NEGOCIATIONPRODUCTION_CREATE', 'NEGOCIATIONPRODUCTION_UPDATE', 'NEGOCIATIONPRODUCTION_DELETE'
				]);
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('logs');
	}

}
