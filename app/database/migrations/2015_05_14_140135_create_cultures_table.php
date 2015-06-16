<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCulturesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::beginTransaction();
		
		Schema::create('cultures', function($t)
		{
			$t->increments('id');
			$t->string('name', 200);
			$t->string('description', 500);
			$t->string('image',100);
			$t->timestamps();
		
		});
		
		 DB::table('cultures')
        ->insert(
            array(
                array('name' => 'ble', 'description'=> 'Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', 'image'=> 'ble.jpg','created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')),
                array('name' => 'mil', 'description'=> 'Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', 'image'=> 'mil.jpg','created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')),
                array('name' => 'fonio', 'description'=> 'Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', 'image'=> 'fonio.jpg','created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')),
				array('name' => 'mais', 'description'=> 'Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', 'image'=> 'mais.jpg','created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s')),
				array('name' => 'riz', 'description'=> 'Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.', 'image'=> 'riz.jpg','created_at'=>date('Y-m-d H:m:s'),'updated_at'=>date('Y-m-d H:m:s'))
            )
        );
		
		 DB::commit();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('cultures');
		
	}

}
