<?php
# Load object properties
$accountid = 0;
$prev_accid = $_GET['previd'];

//initialize error messages
$accountidErr = "";

//if the form on this page has been submitted, process it
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if(empty($_POST['accountid'])){
		$accountidErr = "Required";
	}else{
		$accountid = test_input($_POST['accountid']);
	}
	
	//if no error, add investigator
	if(($accountidErr=="")){
		$account->AddInvestigator($accountid,$proid,$prev_accid,$page);
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
			<td  colspan="" valign="top">
				<table width="100%">
					<tr>
						<th class="hexa-fill" width="20px" ></th>
						<th class="pink-fill" >Add Co Investigator</th>
					</tr>
					<tr>
						<th class="hexa-fill" width="20px" ></th>
						<th class="pink-fill" ></th>
					</tr>
					<tr>
						<td class="image-fill" rowspan="3"></td>
					</tr>
					<tr>
						<td>
							<strong class="font-12">Select Investigator</strong>
							*<span class="message-text"><?php echo $accountidErr;?></span>
						</td>
					</tr>	
					<tr>
						<td>
							<select class="text-input" name="accountid">
								<!-- List Investigators other than the selected PI -->
								<option value=0>Select</option>
								<?php
									$db = new DbObject();
									$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
									
									$sql= "SELECT * FROM account WHERE account_type='Investigator' AND account_id NOT LIKE ".$accid;
									$stmt = $db->prepare($sql);
									$stmt->execute();
									
									while ($row = $stmt->FetchObject()) {
										echo'
										<option value='.$row->account_id.'';
											if($row->account_id==$accid){echo 'selected=selected';}
											echo '>'.$row->title.' '.$row->surname.' '.$row->other_names.'</option>
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
				<input type="button" value="Cancel" name="cancel" onclick="window.location.href='../home/index.php?id=<?php echo $accid.'&proid='.$proid.'&page='.$page;?>'">
			</td>
		</tr>
	</form>
</table>