<?php

class Helper {
	
	
	
	function cleanInput($input){
		
		$input = trim($input);
		$input = stripslashes($input);
		$input = htmlspecialchars($input);
		
		return $input;
		
	}
		
	function arrayToString($arr){
		
		$string = "";
		
		for($i = 0; $i < count($arr); $i++){
			
			$string .= $arr[$i];
			
			if($i != count($arr)-1){
				$string .= ", ";
			}
		}
		
		return $string;
	}
	
	
	
}	
	
?>