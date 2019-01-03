<?php
class Expense
{
	private $id;
	private $userId;
	private $categoryId;
	private $paymentMethodId;
	private $amount;
	private $expenseDate;
	private $comment;
	
	function __construct($id, $userId, $amount, $expenseDate, $paymentMethodId, $categoryId, $comment = "")
	{ 
		$this -> id 							= $id;
		$this -> userId 					= $userId;
		$this -> paymentMethodId	= $paymentMethodId;
		$this -> categoryId 			= $categoryId;
		$this -> amount 					= $amount;
		$this -> expenseDate			= $expenseDate;
		$this -> comment 				= $comment;
	}
	
	function setId($id)
	{
		$this->id = $id;
	}
	
	function setUserId($userId)
	{
		$this->userId = $userId;
	}
	
	function setExpenseDate($expenseDate)
	{
		$this->expenseDate = $expenseDate;
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
	
	function setPaymentMethodId($paymentMethodId)
	{
		$this->paymentMethodId = $paymentMethodId;
	}
	
	function getId()
	{
		return $this->id;
	}
	
	function getUserId()
	{
		return $this->userId;
	}
	
	function getExpenseDate()
	{
		return $this->expenseDate;
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
	
	function getPaymentMethodId()
	{
		return $this->paymentMethodId;
	}
	
}
?>