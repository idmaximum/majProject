<?php

class BaseController extends Controller {

	 public $timestamp = FALSE;
	 
	 protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
	
	
	
	 
 
}