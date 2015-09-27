<?php
return array( 
	'driver' => 'smtp', 
	'host' => 'smtp.gmail.com', 
	'port' => 587,	 
	
	'from' => array('address' => 'noreply@embassycineplex.com', 'name' => 'Embassy Cineplex Online Ticket'), 
	'encryption' => 'tls', 
	
	'username' => 'noreply@embassycineplex.com', 
	'password' => 'embassy@2014',  
	
	'sendmail' => '/usr/sbin/sendmail -bs', 
	'pretend' => false,
);