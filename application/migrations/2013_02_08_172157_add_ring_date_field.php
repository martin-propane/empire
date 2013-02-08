<?php

class Add_Ring_Date_Field {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('Rings', function($table)
		{
			//This isn't a real date field since, more of a century range
			//Example: 13th-15th Century
			//On the old site, some dates seem to be in a slighty different format so
			//that prevents making this into two century fields
			$table->string('date');
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
			$table->drop_column('date');
		});
	}

}
