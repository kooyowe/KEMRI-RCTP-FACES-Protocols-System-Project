<?php
# Load object properties
$title = $account->getTitle();
$surname = $account->getSurname();
$othernames = $account->getOtherNames();
$emailaddress = $account->getEmailAddress();
$username = $account->getUsername();
$password = $account->getPassword();
$repassword = "";
$accounttype = $account->getAccountType();

//initialize error messages
$passwordErr = $rePasswordErr = $userNameErr = $accounttypeErr = "";

//if the form has been submitted, process it
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if(empty($_POST['password'])){
		$passwordErr = "Required";
	}else{
		$password = test_input($_POST['password']);
	}
	
	if(empty($_POST['repassword'])){
		$rePasswordErr = "Required";
	}elseif($_POST['password']!=$_POST['repassword']){
		$rePasswordErr = "Passwords do not match";
		$passwordErr  = "Passwords do not match";
	}else{
		$repassword = test_input($_POST['repassword']);
	}
	
	if(empty($_POST['username'])){
		$userNameErr = "Required";
	}else{
		$username = test_input($_POST['username']);
	}
	
	$accounttype = $_POST['accounttype'];
	
	//if there is no error, change the password
	if(($passwordErr=="")&&($rePasswordErr=="")&&($userNameErr=="")){
		$account->ChangePassword($password,$username,$accounttype,$accid,$page);
	}else{
		echo '<strong class="error-text">Notice:</strong><span class="message-text"> Please fix the highlighted fields before you proceed..</span>';
	}
}

//get rid of special characters
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<table width="400px">
	<form method="post">
		<tr>
			<td colspan="" valign="top">
				<table width="100%">
					<tr>
						<th class="hexa-fill" width="20px" ></th>
						<th class="pink-fill" >Create Password</th>
					</tr>
					<tr>
						<th class="hexa-fill" width="20px" ></th>
						<th class="pink-fill" ></th>
					</tr>	
					<tr>
						<td class="image-fill" rowspan="9"></td>
						<td>
							<strong class="font-12">Username</strong>
							*<span class="message-text"><?php echo $userNameErr;?></span>
						</td>
					</tr>	
					<tr>
						<td>
							<input type="text" name="username" value="<?php echo $username;?>" class="text-input">
						</td>
					</tr>
					<tr>
						<td>
							<strong class="font-12">Password</strong>
							*<span class="message-text"><?php echo $passwordErr;?></span>
						</td>
					</tr>	
					<tr>
						<td>
							<input type="password" name="password" value="" class="text-input">
						</td>
					</tr>
					<tr>
						<td>
							<strong class="font-12">Re-enter Password</strong>
							*<span class="message-text"><?php echo $rePasswordErr;?></span>
						</td>
					</tr>	
					<tr>
						<td>
							<input type="password" name="repassword" value="" class="text-input">
						</td>
					</tr>
					<tr>
						<td>
							<strong class="font-12">Account Type</strong>
							*<span class="message-text"><?php echo $accounttypeErr;?></span>
						</td>
					</tr>	
					<tr>
						<td>
							<select class="text-input" name="accounttype">
								<option value="">Select</option>
								<?php
									$db = new DbObject();
									$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
									
									$sql= "SELECT DISTINCT account_type FROM account";
									$stmt = $db->prepare($sql);
									$stmt->execute();
									
									while ($row = $stmt->FetchObject()) {
										echo'
										<option value="'.$row->account_type.'"';
											if($row->account_type==$accounttype){echo 'selected=selected';}
											echo '>'.$row->account_type.'</option>
										';
									}
								?>
							</select>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="bottom-border">
				<br>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="Save" name="save">
				<a href="../home/index.php?id=<?php echo $accid.'&page='.$page;?>" class="link-no-deco"><input type="button" value="Cancel" name="cancel"></a>
			</td>
		</tr>
	</form>
</table>