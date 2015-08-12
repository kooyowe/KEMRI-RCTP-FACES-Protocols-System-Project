<?php
	/* *********************************************************************
	*Global Variables.
	*Compiles variables and constants being used through out the application
	*@Author:	Kevin Oyowe
	 ***********************************************************************/
	 
	#Required Classes
	include "../classes/Session.php";
	include "../classes/DbObject.php";
	include "../classes/Account.php";
	include "../classes/Protocol.php";
	include "../classes/Transaction.php";
	include "../classes/Report.php";
	
	#Gets Global variables(account id,protocol id, transaction id, co-investigator id, page id, protocol_page id)
	if(isset($_GET['id'])){
		$accid=$_GET['id'];
	}
	if(isset($_GET['proid'])){
		$proid=$_GET['proid'];
	}
	if(isset($_GET['transid'])){
		$transid=$_GET['transid'];
	}
	if(isset($_GET['coid'])){
		$coid=$_GET['coid'];
	}
	if(isset($_GET['page'])){
		$page=$_GET['page'];
	}else{
		$page=1;
	}
	if(isset($_GET['protocol_page'])){
		$protocol_page=$_GET['protocol_page'];
	}else{
		$protocol_page=1;
	}
	
	#Instantiate Account, Protocol, Transaction, Session, Report objects
	$session = new Session;
	$account = new Account;
	$protocol = new Protocol;
	$transaction = new Transaction;
	$report = new Report;
	
	#Fetch object properties(Account, Protocol, Transaction)
	if(isset($_GET['id'])){
		$account->Fetch($accid);
	}
	if(isset($_GET['proid'])){
		$protocol->Fetch($proid);
	}
	if(isset($_GET['transid'])){
		$transaction->Fetch($transid);
	}
	
	#Manage Session
	$session->Check();
	$session->Timeout();
?>