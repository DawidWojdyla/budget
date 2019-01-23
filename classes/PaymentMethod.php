<?php
class PaymentMethod
{
	private $id;
	private $name;
	private $position

	
	function __construct($id, $name, $position)
	{
		$this -> $id 				= $id;
		$this -> $name		= $name;
		$this -> $position	= $position;
	}
	
	function setId($id)
	{
		$this->id = $id;
	}
	
	function setName($name)
	{
		$this->name = $name;
	}
	
	function setAmount($position)
	{
		$this->position = $position;
	}
	
	function getId()
	{
		return $this->id;
	}
	
	function getName()
	{
		return $this->name;
	}
	
	function getPosition()
	{
		return $this->position;
	}
}
?>