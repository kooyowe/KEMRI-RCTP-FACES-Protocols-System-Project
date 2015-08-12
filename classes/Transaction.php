<?php
/* *********************************************************************
	*Transaction Class
	*Models the Transaction Object for a Protocol
	*			Inherits Protocol
	*@Author:	Kevin Oyowe
	*@Date:		Feb 4, 2015
	 ***********************************************************************/
	 
	class Transaction extends Protocol{
		# properties
		var $_transactionId = 0;
		var $_protocolId = 0;
		var $_submissionDate = "";
		var $_approvalDate = "";
		var $_expiryDate = "";
		var $_applicationStatus ="";
		var $_transactionDate = "";
		var $_approved = "";
		
		# setters
		function setTransactionId($transactionId){
			$this->_transactionId=$transactionId;
		}
		function setProtocolId($protocolId){
			$this->_protocolId=$protocolId;
		}
		function setSubmissionDate($submissionDate){
			$this->_submissionDate=$submissionDate;
		}
		function setApprovalDate($approvalDate){
			$this->_approvalDate=$approvalDate;
		}
		function setExpiryDate($expiryDate){
			$this->_expiryDate=$expiryDate;
		}
		function setApplicationStatus($applicationStatus){
			$this->_applicationStatus=$applicationStatus;
		}
		function setTransactionDate($transactionDate){
			$this->_transactionDate=$transactionDate;
		}
		function setApproved($approved){
			$this->_approved=$approved;
		}
		
		# getters
		function getTransactionId(){
			return $this->_transactionId;
		}
		function getProtocolId(){
			return $this->_protocolId;
		}
		function getSubmissionDate(){
			return $this->_submissionDate;
		}
		function getApprovalDate(){
			return $this->_approvalDate;
		}
		function getExpiryDate(){
			return $this->_expiryDate;
		}
		function getApplicationStatus(){
			return $this->_applicationStatus;
		}
		function getTransactionDate(){
			return $this->_transactionDate;
		}
		function getApproved(){
			return $this->_approved;
		}
		
		#sets all the properties of a Transaction instance
		function Fetch($transid){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$sql="SELECT * FROM protocol_transactions WHERE transaction_id=".$transid;
			$stmt = $db->prepare($sql);
			$stmt->execute();
			
			while ($row = $stmt->FetchObject()) {
				$this->setTransactionId($row->transaction_id);
				$this->setProtocolId($row->protocol_id);
				$this->setSubmissionDate($row->submission_date);
				$this->setApprovalDate($row->approval_date);
				$this->setExpiryDate($row->expiry_date);
				$this->setApplicationStatus($row->application_status);
				$this->setTransactionDate($row->transaction_date);
				$this->setApproved($row->approved);
			}
			
		}
		
		# Creates new transaction
		function Create($id,$proid,$subdt,$appdt,$expdt,$status,$approved){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$sql="INSERT into protocol_transactions(protocol_id, submission_date, approval_date, expiry_date, application_status, approved) VALUES(".$proid.",'".$subdt."','".$appdt."','".$expdt."','".$status."',".$approved.")";
			$stmt = $db->prepare($sql);
			if($stmt->execute()){
				?>
				<script type="text/javascript">
					window.location = "../home/index.php?id=<?php echo $id; ?>&proid=<?php echo $proid?>"
				</script>;
				<?php
			}else{
				echo '<strong class="error-text">Error: </strong><span class="message-text">An error occurred while saving ther record..</span>';
			}
		}
		
		function Save($id,$proid,$transid,$subdt,$appdt,$expdt,$transdt,$approved){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$sql="UPDATE protocol_transactions SET submission_date='".$subdt."', approval_date='".$appdt."', expiry_date='".$expdt."', transaction_date='".$transdt."', approved=".$approved." WHERE transaction_id=".$transid;
			$stmt = $db->prepare($sql);
			if($stmt->execute()){
				?>
				<script type="text/javascript">
					window.location = "../home/index.php?id=<?php echo $id; ?>&proid=<?php echo $proid?>"
				</script>;
				<?php
			}else{
				echo '<strong class="error-text">Error: </strong><span class="message-text">An error occurred while saving the record..</span>';
			}
		}
		
		#Lays out a tabular representation of a Protocol's Transaction details
		function DisplayTransactions($proid){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$sql="SELECT * FROM protocol_transactions WHERE protocol_id=".$proid;
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$total = $stmt->rowCount();
			$counter = 0;
			
			while ($row = $stmt->FetchObject()) {
				$transactionId=$row->transaction_id;
				$submissionDate=date_create($row->submission_date);
				$approvalDate=date_create($row->approval_date);
				$expiryDate=date_create($row->expiry_date);
				$applicationStatus=$row->application_status;
				$transactionDate=date_create($row->transaction_date);
				$approved=$row->approved;
				$counter++;
				
				echo '
					<tr >
						<td class="index-field">'.$counter.'<br></td>
						<td class="record-field">'.date_format($submissionDate, 'jS F Y').'<br></td>
						<td class="record-field">'.date_format($approvalDate, 'jS F Y').'<br></td>
						<td class="record-field">'.date_format($expiryDate, 'jS F Y').'<br></td>
						<td class="record-field">'.$applicationStatus.'<br></td>
						<td class="record-field">'.date_format($transactionDate, 'jS F Y').'<br></td>
						<td class="record-field" width="20px">'; if($approved==1){echo '<img src="../images/approved.ico">';} echo '<br></td>
					</tr>
				';
			}
			
			echo '
				<tr>
					';
					if($_SESSION['accounttype']=="Admin"){
						if(($total>0)&&($approved==0)){
							echo '
								<td colspan="2">
									<a href="../transaction/index.php?transaction=renewed&id='.$_GET['id'].'&proid='.$proid.'&transid='.$transactionId.'" class="link-no-deco"><input type="button" value="Renew Protocol"></a>
								</td>
							';
						}
						if($total<1){
							echo '
								<td colspan="2">
									<a href="../transaction/index.php?transaction=new&id='.$_GET['id'].'&proid='.$proid.'" class="link-no-deco"><input type="button" value="Approve Protocol"></a>
								</td>
							';
						}
						if($total>0){
							echo '
								<td colspan="2">
									<a href="../transaction/edit_trans_index.php?id='.$_GET['id'].'&proid='.$proid.'&transid='.$transactionId.'" class="link-no-deco"><input type="button" value="Edit Transaction"></a>
								</td>
							';
						}
					}
					
					echo '
				</tr>
			';
		}
	}
?>