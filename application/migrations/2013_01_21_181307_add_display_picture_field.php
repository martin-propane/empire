<?php

class Add_Display_Picture_Field {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('Rings', function($table)
		{
			$table->string('display_picture')->nullable();
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
			$table->drop_column('display_picture');
		});
	}

}
