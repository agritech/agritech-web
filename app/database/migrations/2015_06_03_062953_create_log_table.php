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
				'RECOLTE_LIST', 'RECOLTE_VIEW','RECOLTE_EDIT', 'RECOLTE_NEW', 'RECOLTE_CREATE', 'RECOLTE_UPDATE', 'RECOLTE_DELETE',
				'NEGOCIATIONRECOLTE_LIST', 'NEGOCIATIONRECOLTE_VIEW','NEGOCIATIONRECOLTE_EDIT', 'NEGOCIATIONRECOLTE_NEW', 'NEGOCIATIONRECOLTE_CREATE', 'NEGOCIATIONRECOLTE_UPDATE', 'NEGOCIATIONRECOLTE_DELETE'
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
