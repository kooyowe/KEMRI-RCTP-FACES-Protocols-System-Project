<?php
	/* *********************************************************************
	*Login Form
	*Handles user login
	*@Author:	Kevin Oyowe
	 ***********************************************************************/	
	
	#
	#If the form is not submitted, then
	#If there is an error, Get the error.
	#
	#err 1 = incorrect login
	#err 2 = timed logout
	#err 3 = unauthorised access
	#err 34= lost database connection
	#
	#Display the Form
	#
	if( !(isset( $_POST['login'] ) ) ) {
		if(isset($_GET['err'])||isset($_GET['url'])){
			if($_GET['err']==1){
				$msg = "Login Error, Please try again";
			}elseif($_GET['err']==2){
				$msg = "Logged out, please re-login to proceed";
			}elseif($_GET['err']==3){
				$msg = "Denied, Unauthorised Access Attempt!";
			}elseif($_GET['err']==4){
				$msg = "Sorry, lost connection to the database";
			}else{
				$msg = "Sorry, application could not service the request";
			}
		}else{
			$msg = "Welcome! Login to proceed";
		}
	?>
		<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http-equiv="content-type" content="text/html; charset=UTF-8">
				<link rel="icon" type="image/png" href="images/picon1.ico">
				<title>ProMS</title>
				<link rel="stylesheet" media="screen" href="shared/style.css" type="text/css">
			</head>
			<body>
				<div id="container">
					<table width="100%"style="background-color:black;height:44px;width:100%;position:relative;color:#fff">
						<tr style="height:44px">
							<td  valign="center" width="250px">
								<table width="" style="border:1px solid green;height:40px;">
									<tr>
										<td>
											<a href="index.php" style="color:white;font-size:16px;font-weight:bold;text-decoration:none">Protocols Management System</a>
										</td>
									</tr>
								</table>
								
							</td>
						</tr>
					</table>

					<div style="margin-top:10px;text-align:center">
						
						<br>
						<span class="message-text">
						<?php
							//login message
							if(isset($_GET['err'])){
								if($_GET['err']==3){
									echo '<strong class="error-text">'.$msg.'</strong>';
								}else{
									echo $msg;
								}
							}else{
								echo $msg;
							}
						?>
						</span>
						<div class="">
						<div class="login-body">
							<div class="footer">
							<form action="" method="post">
								<fieldset class="inputs">
									<div class="login-container">
										<div class="login-field">
											<input autocapitalize="off" autocorrect="off" class="login-input" id="username" name="username" placeholder="username" type="text" autofocus>
										</div>
									</div>
									<div class="login-container">
										<div class="login-field">
											<input class="login-input" id="password" name="password" placeholder="Password" type="password">
										</div>
									</div>
								</fieldset>
								<div class="login-button">
									<button class="login button" id="loginbutton" name="login"> Log in </button>
								</div>
							</form>
							</div>
						</div>
						</div>
						<div class="footer">
						<a href="">Forgot your password?</a>
						</div>
					</div>
				</div>
			</body>
		</html>
	<?php 
	#
	#Else process the login request
	#
	} else {
		//Required classes
		
		require_once("classes/DBObject.php");
		
		require_once("classes/account.php");
		
		require_once("classes/protocol.php");
		
		require_once("classes/session.php");
		
		//initialize objects
		$account = new Account;
		$protocol = new Protocol;
		$session = new Session;
		$account->getFormValues( $_POST );
		
		//validate login
		if( $account->Login() ) {
			$account->Initialize();
			$id = $account->getAccountId();
			
			$protocol->Initialize($id);
			$proid = $protocol->getProtocolId();
			
			$userid = $account->getUserId();
			$accounttype = $account->getAccountType();
			
			$session->setUserId($userid);
			$session->setAccountType($accounttype);
			
			$query_string = 'id=' . urlencode($id) . '&proid=' . urlencode($proid);
			header("location:home/index.php?".$query_string);
			
		} else {
			header("location:index.php?err=1");
		}
	}
?>
