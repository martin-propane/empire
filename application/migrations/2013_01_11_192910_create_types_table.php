<?php

class Create_Types_Table
{

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Types', function($table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->text('description');
			$table->text('short_description');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('Types');
	}

}
