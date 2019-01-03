<?php
class Category
{
	public $id;
	public $name;
	public $position;
	
	function __construct($id, $name, $position)
	{
		$this -> id 			= $id;
		$this -> name		= $name;
		$this -> position	= $position;
	}
	
	function setId($id)
	{
		$this->id = $id;
	}
	
	function setName($name)
	{
		$this->name = $name;
	}
	
	function setPosition($position)
	{
		$this->position = $position;
	}
	
	function getId()
	{
		return $this->id;
	}
	
	function geName()
	{
		return $this->name;
	}
	
	function getPosition()
	{
		return $this->position;
	}
	
}
?>