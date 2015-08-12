<?php
# Load object properties
$accountid = $account->getAccountId();
$protocoltitle = $protocol->getProtocolTitle();
$protocoldesc = $protocol->getProtocolDesc();
$discontinue = $protocol->getDiscontinue();
$protocolid = $protocol->getProtocolId();

//initialize error messages
$accountidErr = $protocoltitleErr = $protocoldescErr = "";

//if this form has been submitted, process it
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
	
	$proid = $_POST['protocolid'];
	
	if(($accountidErr=="")&&($protocoltitleErr=="")&&($protocoldescErr=="")){
		$protocol->Update($protocoltitle,$protocoldesc,$accountid,$discontinue,$proid,$page);
	}else{
		echo '<strong class="error-text">Notice:</strong><span class="message-text"> Please fix the highlighted fields before you proceed..</span>';
	}
}

//remove special characters
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
			<td class="bottom-border" colspan="5">
				<table width="100%">
					<tr>
						<th class="hexa-fill" width="20px"></th>
						<th class="pink-fill"><?php echo $protocoltitle;?></th>
					</tr>
					<tr>
						<td class="hexa-fill" width="20px"></td>
						<td class="pink-fill"></td>
					</tr>
					<tr>
						<th class="image-fill" width="20px" rowspan="6"></th>
						<td >
							<strong class="font-14">
								Principal Investigator
							</strong>
							<br>
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
							Protocol Title
							<input type="hidden" name="protocolid" value=<?php echo $protocolid;?>>
						</strong>
						<br>
							<span class="message-text">* <?php echo $protocoltitleErr;?></span>
						</td>
					</tr>
					<tr>
						<td >
							<input class="text-input" name="protocoltitle" type="text" value="<?php echo $protocoltitle;?>">
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
			<td align="right">
				<a href="../protocol/del_confirm.php?id=<?php echo $accountid;?>&proid=<?php echo $protocolid.'&page='.$page;?>" class="link-no-deco"><input type="button" value="Delete" name="delete"></a>
			</td>
		</tr>
	</form>
</table>