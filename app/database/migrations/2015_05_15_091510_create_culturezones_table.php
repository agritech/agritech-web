<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCulturezonesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::beginTransaction();
		
		Schema::create('culturezones', function($t)
		{
			$t->increments('id');
			$t->string('name', 200);
			$t->string('longitude', 100);
			$t->string('latitude', 100);
			$t->string('description',500);
			$t->timestamps();
		
		});
		
		 DB::table('culturezones')
        ->insert(
            array(
                array('name' => 'Zinder', 'description'=> 'La zone de Zinder', 'longitude'=> '13.805609', 'latitude' =>'8.988161','created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')),
                array('name' => 'Niamey', 'description'=> 'La zone de Niamey', 'longitude'=> '13.525120', 'latitude' =>'2.107531','created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')),
                array('name' => 'Maradi', 'description'=> 'La zone de Maradi', 'longitude'=> '13.482263', 'latitude' =>'7.103409','created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s'))
            )
        );
		
		Schema::create('culturezonecultureperiods', function($t)
		{
			$t->increments('id');
			$t->integer('zoneid');
			$t->integer('cultureid');
			$t->date('from');
			$t->date('to');
			$t->timestamps();
		
		});
		
		 DB::commit();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('culturezones');
		Schema::drop('culturezonecultureperiods');
	}

}
