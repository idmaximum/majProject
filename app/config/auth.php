<?php

return array( 

	'driver' => 'eloquent',
	'model' => 'Staff',
	'table' => 'movie_staff', 
	
	'reminder' => array( 
		'email' => 'emails.auth.reminder', 
		'table' => 'password_reminders', 
		'expire' => 60, 
	),

);
