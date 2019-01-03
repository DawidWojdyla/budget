<?php
class Amount
{
	//public $amount;

	//function __construct($amount)
	//{
		//$this -> amount  = $amount;
//	}
	
	function checkAmount($amount)
	{
		$amount = str_replace(",",".",$amount);
		$amountInArray = str_split($amount);
		$find = array('0','1','2','3','4','5','6','7','8','9','.');
		$isNumber = true;
		foreach ($amountInArray as $digit) 
		{
			if (!in_array($digit, $find)) 
			{
				$isNumber = false;
				break;
			}
		}
		
		if (substr_count($amount, ".") >1 || !$isNumber)
			return false;
		return true;
		
	}
}

?>