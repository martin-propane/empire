<?php

use Laravel\Database;

class CreateUser_Task
{
        public function run($arguments)
        {
			$email = $arguments[0];
			$password = $arguments[1];
			$admin = $arguments[2];

			$password = Hash::make($password);
			Database::table('Users')->insert(array('email' => $email, 'password' => $password, 'admin' => $admin));
        }
}
