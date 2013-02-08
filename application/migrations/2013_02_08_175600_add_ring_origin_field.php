<?php

class Add_Ring_Origin_Field {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('Rings', function($table)
		{
			$table->string('origin');
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
			$table->drop_column('origin');
		});
	}

}
