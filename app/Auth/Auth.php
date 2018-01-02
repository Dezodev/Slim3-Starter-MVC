<?php

namespace App\Auth;
use App\Models\User;

class Auth {
	public function attempt($email, $password){
		// Get user by email
		$user = User::where('email', $email)->first();

		// Check if user exist
		if (!$user) return false;

		// Check password
		if (password_verify($password, $user->password)) {
			// Set user id in Session
			$_SESSION['user'] = $user->id;

			return true;
		}

		return false;
	}
}
