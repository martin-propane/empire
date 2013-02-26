<?php

class Create_RingPictures_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('RingPictures', function($table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id'); //Ring Number, laravel requires field name to be id for functionality

			//the following values are nullable for when the picture entry is first created, and it hasn't been populated with the img data or ring yet
			$table->integer('order')->unsigned()->nullable();
			$table->string('url')->nullable();
			$table->integer('ring_id')->unsigned()->nullable();

			$table->foreign('ring_id')->references('id')->on('Rings')->on_update('cascade')->on_delete('cascade');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('RingPictures');
	}

}
