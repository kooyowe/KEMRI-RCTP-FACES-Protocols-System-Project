<?php
# Load object properties
$accountid = $account->getAccountId();
$protocoltitle = "";
$protocoldesc = "";
$discontinue = "";

//initialize message variables
$accountidErr = $protocoltitleErr = $protocoldescErr = "";
$validTitleErr = $validDescErr = "";

//if page has been submitted, process it
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["accountid"])||($_POST["accountid"]==0)) {
		$accountidErr = "Select a PI";
	} else {
		$accountid = test_input($_POST["accountid"]);
	}
	
	if (empty($_POST["protocoltitle"])) {
		$protocoltitleErr = "Protocol Title is required";
	} else {
		$protocoltitle = test_input($_POST["protocoltitle"]);
	}
	
	if (empty($_POST["protocoldesc"])) {
		$protocoldescErr = "Protocol Description is required";
	} else {
		$protocoldesc = test_input($_POST["protocoldesc"]);
	}
	
	if(isset($_POST['discontinue'])){
		$discontinue=1;
	}else{
		$discontinue=0;
	}
	
	$accountid = $_POST['accountid'];
	
	//if no errors, validate the form
	if(($accountidErr=="")&&($protocoltitleErr=="")&&($protocoldescErr=="")){
		
		if(!$protocol->ValidateTitle($protocoltitle)){
			$validTitleErr = "Duplicate Title/No attempt.";
			echo '<span class="message-text">'.$validTitleErr.'</span>';
		}
		if(!$protocol->ValidateDesc($protocoldesc)){
			$validDescErr = "Duplicate Protocol Description attempt.";
			echo '<span class="message-text"><br>'.$validDescErr.'</span>';
		}
		
		//if no validation errors, create protocol
		if($validTitleErr=="" && $validDescErr==""){
			$protocol->Insert($protocoltitle,$protocoldesc,$accountid,$discontinue,$page);
		}
		
	}
}

//gets rid of special chars
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
			<td class="bottom-border" colspan="5" valign="top">
				<table width="100%">
					<tr>
						<th class="hexa-fill" width="20px" ></th>
						<th class="pink-fill">New Protocol Study</th>
					</tr>
					<tr>
						<td class="hexa-fill" width="20px" ></td>
						<td class="pink-fill"></td>
					</tr>
					<tr>
						<th class="image-fill" width="20px" rowspan="6"></th>
						<td >
							<strong class="font-14">
								Principal Investigator
							</strong>
							<br>
							<input type="hidden" name="accountid" value=<?php echo $accountid;?>>
							<span class="message-text">* <?php echo $accountidErr;?></span>
						</td>
					</tr>
					<tr>
						<td >
							<select class="text-input" name="accountid">
								<option value=0>Select</option>
								<?php
									$db = new DbObject();
									$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
									
									$sql= "SELECT * FROM account WHERE account_type='Investigator'";
									$stmt = $db->prepare($sql);
									$stmt->execute();
									
									while ($row = $stmt->FetchObject()) {
										echo'
										<option value="'.$row->account_id.'"';
											if($row->account_id==$accountid){echo 'selected=selected';}
											echo '>'.$row->title.' '.$row->surname.' '.$row->other_names.'</option>
										';
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td >
						<strong class="font-14">
							Protocol Title/No.
						</strong>
						<br>
							<span class="message-text">* <?php echo $protocoltitleErr;?></span>
						</td>
					</tr>
					<tr>
						<td >
							<input name="protocoltitle" type="text" value="<?php echo $protocoltitle;?>" class="text-input">
						</td>
					</tr>
					<tr>
						<td >
						<strong class="font-14">
							Protocol Description
						</strong>
						<br>
							<span class="message-text">* <?php echo $protocoldescErr;?></span>
						</td>
					</tr>
					<tr>
						<td >
							 <textarea name="protocoldesc" class="text-area"><?php echo $protocoldesc;?></textarea>
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input name="discontinue" type="checkbox" value=<?php echo $discontinue;?> <?php if($protocol->getDiscontinue()==1){echo 'checked';} ?>> Discontinue<br>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" value="Save" name="save">
				<input type="button" value="Cancel" name="cancel" onclick="window.location.href='../home/index.php?id=<?php echo $accountid.'&page='.$page;?>'">
			</td>
		</tr>
	</form>
</table>