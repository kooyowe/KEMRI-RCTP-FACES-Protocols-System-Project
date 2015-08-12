<?php
	/* *********************************************************************
	*Database Class
	*Inherits the PHP Data Object (PDO) Class to manage connection to any 
	*			database and query executions on target db.
	*			(PHP 5)
	*@Author:	Kevin Oyowe
	*@Date:		Jan 28, 2015
	 ***********************************************************************/
	class DbObject extends PDO{

		const DB_HOST='localhost';
		const DB_PORT='3306';
		const DB_NAME='protocols';
		const DB_USER='root';
		const DB_PASS='root';
		
		public function __construct($options=null){
			try{
				parent::__construct('mysql:host='.DbObject::DB_HOST.';port='.DbObject::DB_PORT.';dbname='.DbObject::DB_NAME,
								DbObject::DB_USER,
								DbObject::DB_PASS,$options);
			} catch (PDOException $e) {
				//header("location:index.php?err=4");
				print "Error!: Lost connection to the database.<br/>";
				echo '
			<html xmlns="http://www.w3.org/1999/xhtml">
			<head>
				<meta http-equiv="content-type" content="text/html; charset=UTF-8">
				<link rel="icon" type="image/png" href="images/kemri-logo.ico">
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
						<div class="login-body">
							<br>
						</div>
						<br>
						<strong class="message-text">
							Not connected to db !!
						</strong>
						<div class="">
						<div class="login-body">
							<div class="footer">
							<form action="" method="post">
								<fieldset class="inputs">
									<div class="login-container">
										<div class="login-field">
											..............................
											<h1>Sorry</h1>
											..............................
										</div>
									</div>
								</fieldset>
								<div class="login-button">
									<button class="login button" id="loginbutton" name="login"> Retry</button>
								</div>
							</form>
							</div>
						</div>
						</div>
						<div class="footer">
						</div>
					</div>
				</div>
			</body>
		</html>';
				die();
				
			}
		}
	}
?>
