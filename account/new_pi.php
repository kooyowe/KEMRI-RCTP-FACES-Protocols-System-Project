<?php
# Load object properties
$title = $surname = $othernames = $emailaddress = $accounttype = "";

$titleErr = $surnameErr = $othernamesErr = $emailaddressErr = $accountTypeErr = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	$title = test_input($_POST['title']);
	
	if(empty($_POST['surname'])){
		$surnameErr = "Required";
	}else{
		$surname = test_input($_POST['surname']);
	}
	
	if(empty($_POST['othernames'])){
		$othernamesErr = "Required";
	}else{
		$othernames = test_input($_POST['othernames']);
	}
	
	if(empty($_POST['emailaddress'])){
		$emailaddressErr = "Required";
	}else{
		$emailaddress = test_input($_POST['emailaddress']);
	}
	
	if(empty($_POST['accounttype'])){
		$accountTypeErr = "Required";
	}else{
		$accounttype = test_input($_POST['accounttype']);
	}
	
	if(($titleErr=="")&&($surnameErr=="")&&($othernamesErr=="")&&($emailaddressErr=="")&&($accountTypeErr=="")){
		$account->Insert($title,$surname,$othernames,$emailaddress,$accounttype,$accid);
	}else{
		echo '<strong class="error-text">Notice:</strong><span class="message-text"> Please fix the highlighted fields before you proceed..</span>';
	}
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<table width="400px">
	<form method="post" action="">
		<tr>
			<td  colspan="" valign="top">
				<table width="100%">
					<tr>
						<th class="hexa-fill" width="20px" ></th>
						<th class="pink-fill" >New Account</th>
					</tr>
					<tr>
						<th class="hexa-fill" width="20px" ></th>
						<th class="pink-fill" ></th>
					</tr>
					<tr>
						<td class="image-fill" rowspan="10"></td>
						<td >
							<strong class="font-12">Title</strong>
						</td>
					</tr>
					<tr>
						<td >
							<input type="text" name="title" value="<?php echo $title;?>" class="title-input">
						</td>
					</tr>		
					<tr>
						<td>
							<strong class="font-12">Surname</strong>
							*<span class="message-text"><?php echo $surnameErr;?></span>
						</td>
					</tr>	
					<tr>
						<td>
							<input type="text" name="surname" value="<?php echo $surname;?>" class="text-input">
						</td>
					</tr>
					<tr>
						<td>
							<strong class="font-12">Other Names</strong>
							*<span class="message-text"><?php echo $othernamesErr;?></span>
						</td>
					</tr>	
					<tr>
						<td>
							<input type="text" name="othernames" value="<?php echo $othernames;?>" class="text-input">
						</td>
					</tr>
					<tr>
						<td>
							<strong class="font-12">Email Address</strong>
							*<span class="message-text"><?php echo $emailaddressErr;?></span>
						</td>
					</tr>	
					<tr>
						<td>
							<input type="text" name="emailaddress" value="<?php echo $emailaddress;?>" class="text-input">
						</td>
					</tr>
					<tr>
						<td>
							<strong class="font-12">Account Type</strong>
							*<span class="message-text"><?php echo $accountTypeErr;?></span>
						</td>
					</tr>	
					<tr>
						<td>
							<select name="accounttype" class="text-input" >
								<option>Investigator</option>
								<option>Admin</option>
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
				<input type="button" value="Cancel" name="cancel" onclick="window.location.href='../home/index.php?id=<?php echo $accid.'&page='.$page;?>'">
			</td>
		</tr>
	</form>
</table>