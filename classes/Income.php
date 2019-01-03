<?php
class Income
{
	private $id;
	private $userId;
	private $categoryId;
	private $amount;
	private $incomeDate;
	private $comment;
	
	function __construct($id, $userId, $amount, $incomeDate, $categoryId, $comment = "")
	{
		$this -> id 					= $id;
		$this -> categoryId 	= $categoryId;
		$this -> amount 			= $amount;
		$this -> incomeDate	= $incomeDate;
		$this -> comment 		= $comment;
		$this -> userId			= $userId;
	}
	
	function setId($id)
	{
		$this->id = $id;
	}
	
	function setUserId($userId)
	{
		$this->userId = $userId;
	}
	
	function setIncomeDate($incomeDate)
	{
		$this->incomeDate = $incomeDate;
	}
	
	function setAmount($amount)
	{
		$this->amount = $amount;
	}
	
	function setComment($comment)
	{
		$this->comment = $comment;
	}
	
	function setCategoryId($categoryId)
	{
		$this->categoryId = $categoryId;
	}
	
	function getId()
	{
		return $this->id;
	}
	
	function getUserId()
	{
		return $this->userId;
	}
	
	function getIncomeDate()
	{
		return $this->incomeDate;
	}
	
	function getAmount()
	{
		return $this->amount;
	}
	
	function getComment()
	{
		return $this->comment;
	}
	
	function getCategoryId()
	{
		return $this->categoryId;
	}
	
	
	
}
?>