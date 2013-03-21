<?php

class Add_Ringsize_Field {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('Rings', function($table)
		{
			$table->text('ring_size');
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('Rings', function($table)
		{
			$table->drop_column('ring_size');
		});
	}

}

