<?php

class Add_Ring_Source_Field {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('Rings', function($table)
		{
			$table->text('source');
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
			$table->drop_column('source');
		});
	}

}
