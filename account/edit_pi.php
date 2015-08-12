<?php
# Load object properties
$title = $account->getTitle();
$surname = $account->getSurname();
$othernames = $account->getOtherNames();
$emailaddress = $account->getEmailAddress();

//initialize error strings
$titleErr = $surnameErr = $othernamesErr = $emailaddressErr ="";

//if this form has been submitted, process
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if(empty($_POST['title'])){
		$titleErr = "Required";
	}else{
		$title = test_input($_POST['title']);
	}
	
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
	
	//if there is no error captured, update
	if(($titleErr=="")&&($surnameErr=="")&&($othernamesErr=="")&&($emailaddressErr=="")){
		$account->Update($title,$surname,$othernames,$emailaddress,$accid,$page);
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
						<th class="pink-fill" ><?php echo $title.' '.$othernames.' '.$surname;?></th>
					</tr>
					<tr>
						<th class="hexa-fill" width="20px" ></th>
						<th class="pink-fill" ></th>
					</tr>
					<tr>
						<td class="image-fill" rowspan="8"></td>
						<td >
							<strong class="font-12">Title</strong>
							*<span class="message-text"><?php echo $titleErr;?></span>
						</td>
					</tr>
					<tr>
						<td >
							<input type="text" name="title" value=<?php echo $title;?> class="title-input">
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
				</table>
			</td>
		</tr>
		<tr>
			<td  class="bottom-border">
				<br>
			</td>
		</tr>
		<tr>
			<td >
				<table width="100%">
					<tr>
						<td>
							<input type="submit" value="Save" name="save">
							<a href="../home/index.php?id=<?php echo $accid.'&page='.$page;?>" class="link-no-deco">
								<input type="button" value="Cancel" name="cancel">
							</a>
						</td>
						<td align="right">
							<a href="../account/del_confirm.php?id=<?php echo $accid.'&page='.$page;?>" class="link-no-deco">
								<input type="button" value="Delete" name="Delete">
							</a>
						</td>
					</tr>
				</table>
			</td>
	</form>
		</tr>
</table>