<?php

	// is_blank('abcd')
	function is_blank($value='') {
		
		return !isset($value) || $value=='';
		
	}

	// has_length('abcd', ['min' => 3, 'max' => 5])
	function has_length($value="", $options=array()) {
		  
		return strlen($value) >= $options[0] && strlen($value) <= $options[1];
	  
	}

	// has_valid_email_format('test@test.com')
	function has_valid_email_format($value) {
		
		$pattern = '/^[^0-9.\_][A-Za-z0-9]+[@][A-Za-z0-9_]+[.][a-z]{3}$/';
		
		return preg_match($pattern, $value);
		
	}

?>
