<?php
# Load object properties
$protocolid = $protocol->getProtocolId();
$title = $protocol->getProtocolTitle();
$desc = $protocol->getProtocolDesc();

$accountid = $account->getAccountId();

$transid = $transaction->getTransactionId();
$submissiondate = $transaction->getSubmissionDate();
$approvaldate = $transaction->getApprovalDate();
$expirydate = $transaction->getExpiryDate();
$approved = $transaction->getApproved();
$date = new DateTime();
$transactiondate = date_format($date, 'Y-m-d');

$submissionErr = $approvalErr = $expiryErr = $approvedErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if(empty($_POST['submissiondate'])){
		$submissionErr = "Required";
	}else{
		$submissiondate = test_input($_POST['submissiondate']);
	}
	
	if(empty($_POST['approvaldate'])){
		$approvalErr = "Required";
	}else{
		$approvaldate = test_input($_POST['approvaldate']);
	}
	
	if(empty($_POST['expirydate'])){
		$expiryErr = "Required";
	}else{
		$expirydate = test_input($_POST['expirydate']);
	}
	
	$transactiondate = $_POST['transactiondate'];
	if(isset($_POST['approved'])){
		$approved = 1;
	}else{
		$approved = 0;
	}
	
	if(($submissionErr=="")&&($approvalErr=="")&&($expiryErr=="")){
		$transaction->Save($accountid,$protocolid,$transid,$submissiondate,$approvaldate,$expirydate,$transactiondate,$approved);
	}else{
		echo '<strong class="error-text">Notice: </strong><span class="message-text">Please fix the highlighted fields before you proceed..</span>';
	}
	
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>
<script>
	$(function() {
		$( "#subdt" ).datepicker({dateFormat: 'yy-mm-dd'});
		$( "#appdt" ).datepicker({dateFormat: 'yy-mm-dd'});
		$( "#expdt" ).datepicker({dateFormat: 'yy-mm-dd'});
	});
</script>
<script>
	function calcExpiry(f) {
		var d = new Date(f.approvaldate.value);
		d.setFullYear(d.getFullYear() + 1); 
		var yy = d.getFullYear();
		var mm = d.getMonth()+1;
		var dd = d.getDate();
		//f.expirydate.value = yy + '-' + mm + '-' + dd;
	}
</script>
<table width="400px">
	<form method="post" action="<?php echo htmlspecialchars("edit_trans_index.php?id=".$accountid."&proid=".$protocolid)."&transid=".$transid;?>">
		<tr>
			<td class="bottom-border" colspan="" valign="top">
				<table width="100%">
					<tr>
						<th class="hexa-fill" width="20px" ></th>
						<th class="pink-fill" ><?php echo $title;?></th>
					</tr>
					<tr>
						<td class="hexa-fill" width="20px" ></td>
						<td class="pink-fill" ></td>
					</tr>
					<tr>
						<td class="image-fill" width="20px" rowspan="8"></td>
						<td class="protocol-title-desc-box">
						<strong class="font-15">
							<u>
							<?php
								echo $title;
							?>
							</u>
						</strong>
						<br>
							<?php
								echo $desc;
							?>
						</td>
					</tr>
					<tr height="30px">
						<td class="bottom-border">
							<strong class="font-12">
								Date: <?php echo $transactiondate;?>
							</strong>
							<input type="hidden" name="transactiondate" value="<?php echo $transactiondate;?>">
						</td>
					</tr>
					<tr>
						<td class="font-12">
							<strong>ERC Submission Date</strong><span class="input-hint"> [yyyy-mm-dd]</span>
							<span class="message-text">*<?php echo $submissionErr;?></span>
						</td>
					</tr>
					<tr>
						<td >
							<input id="subdt" type="text" name="submissiondate" value="<?php echo $submissiondate;?>" placeholder="2015-02-18" class="text-input">
						</td>
					</tr>
					<tr>
						<td class="font-12">
							<strong>Approved on</strong><span class="input-hint"> [yyyy-mm-dd]</span>
							<span class="message-text">*<?php echo $approvalErr;?></span>
						</td>
					</tr>
					<tr>
						<td >
							<input id="appdt" type="text" name="approvaldate" value="<?php echo $approvaldate;?>" placeholder="2015-02-18" class="text-input">
						</td>
					</tr>
					<tr>
						<td class="font-12">
							<strong>Expiry Date</strong><span class="input-hint"> [yyyy-mm-dd]</span>
							<span class="message-text">*<?php echo $expiryErr;?></span>
						</td>
					</tr>
					<tr>
						<td >
							<input id="expdt" type="text" name="expirydate" value="<?php echo $expirydate;?>" placeholder="2015-02-18" class="text-input" onfocus="calcExpiry(this.form)">
						</td>
					</tr>
					<tr>
						<td >
							<input id="approved" type="checkbox" name="approved" <?php if($approved==1){ echo 'checked';}?>>
						</td>
					</tr>
					<tr>
						<td >
							<br>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="Save" name="save">
				<a href="../home/index.php?id=<?php echo $accountid?>&proid=<?php echo $protocolid?>" class="link-no-deco"><input type="button" value="Cancel" name="cancel"></a>
			</td>
		</tr>
	</form>
</table>