<?php
	/* *********************************************************************
	*Session Class
	*For User session management
	*@Author:	Kevin Oyowe
	 ***********************************************************************/
	class Session{
		#Constructor
		function __construct(){
			session_start();
		}
		
		#Setters
		function setUserId($uid){
			$_SESSION['userid'] = $uid;
		}
		function setAccountType($accounttype){
			$_SESSION['accounttype'] = $accounttype;
		}
		function setPiLowerLimit($lower){
      $_SESSION['piLowerLimit'] = $lower;
		}
			function setPiUpperLimit($upper){
      $_SESSION['piUpperLimit'] = $upper;
		}
		
		#Getters
		function getUserId(){
			if(isset($_SESSION['userid'])){
				return $_SESSION['userid'];
			}
		}
		function getAccountType(){
			if(isset($_SESSION['accounttype'])){
				return $_SESSION['accounttype'];
			}
		}
		function getPiLowerLimit(){
			if(isset($_SESSION['piLowerLowerLimit'])){
				return $_SESSION['piLowerLowerLimit'];
			}
		}
		function getPiUpperLimit(){
			if(isset($_SESSION['piUpperLowerLimit'])){
				return $_SESSION['piUpperLowerLimit'];
			}
		}
		
		
		#Checks and stops any non-session access.
		function Check(){
			if(isset($_SESSION['userid'])){
				if($_SESSION['userid']<1){
					$err=3;
					header("location:../index.php?err=".$err);
				}
			}else{
				$err=3;
				header("location:../index.php?err=".$err);
			}
		}
		
		//Logout after 20 minutes of no activity.
		function Timeout(){
			if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1200)) {
				session_unset();
				session_destroy();
				$err = 2;
				
				header("location:../index.php?err=".$err);
			}
			$_SESSION['last_activity'] = time();
		}
		
		//Destroy Session.
		function Destroy(){
			session_unset(); 
			$_SESSION = array();
			
			if (ini_get("session.use_cookies")) {
				$params = session_get_cookie_params();
				setcookie(session_name(), '', time() - 42000,
					$params["path"], $params["domain"],
					$params["secure"], $params["httponly"]
				);
			}
			
			session_destroy();
			header("location:../index.php");
		}
	}
?>