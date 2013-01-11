<?php

class Create_Rings_Table
{

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Rings', function($table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id'); //Ring Number, laravel requires field name to be id for functionality
			$table->string('name');
			$table->integer('type_id')->unsigned();
			$table->text('description')->nullable();
			$table->decimal('price', 10, 2);

			$table->foreign('type_id')->references('id')->on('Types');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Rings');
	}

}

