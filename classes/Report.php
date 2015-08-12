<?php 
	class Report {
		function AllInvestigators(){
				$db = new DbObject();
				$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
				
				$sql= "SELECT * FROM account WHERE account_type='Investigator' ";
				$stmt = $db->prepare($sql);
				$stmt->execute();
				
				$count = 0; //numbers the records
				echo '
					<table style="font-size:12px" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td style="border:1px solid pink"><strong>No.</strong></td>
						<td style="border:1px solid pink"><strong>Title</strong></td>
						<td style="border:1px solid pink"><strong>Name</strong></td>
						<td style="border:1px solid pink"><strong>Email</strong></td>
						<td style="border:1px solid pink"><strong>Username</strong></td>
						<td style="border:1px solid pink"><strong>Account Type</strong></td>
					</tr>
				';
				while ($row = $stmt->FetchObject()) {
					$count++;
					$accountid = $row->account_id;
					$title = $row->title;
					$othernames = $row->other_names;
					$surname = $row->surname;
					$username = $row->username;
					$email = $row->email_address;
					$accounttype= $row->account_type;
					
					echo'
						<tr>
							<td style="border:1px solid pink">'.$count.'<br></td>
							<td style="border:1px solid pink">'.$title.'<br></td>
							<td style="border:1px solid pink">'.$othernames.' '.$surname.'<br></td>
							<td style="border:1px solid pink">'.$email.'<br></td>
							<td style="border:1px solid pink">'.$username.'<br></td>
							<td style="border:1px solid pink">'.$accounttype.'<br></td>
						</tr>
					';
				}
				echo '
					</table>
				';
		}
		
		function AllProtocols(){
				$db = new DbObject();
				$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
				
				$psql= "SELECT p.*, a.* FROM protocol p 
				JOIN account a ON p.account_id=a.account_id  ";
				$pstmt = $db->prepare($psql);
				$pstmt->execute();
				$pcount = 0;
				
				echo '
					<table style="font-size:12px" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td style="border:1px solid pink"><strong>No.</strong></td>
						<td style="border:1px solid pink"><strong>Protocol</strong></td>
						<td style="border:1px solid pink"><strong>Principal Investigator</strong></td>
						<td style="border:1px solid pink"><strong>Email</strong></td>
					</tr>
				';
				while ($prow = $pstmt->FetchObject()) {
					$proid = $prow->protocol_id;
					$protitle = $prow->protocol_title;
					$prodesc = $prow->protocol_desc;
					$pititle = $prow->title;
					$pisurname = $prow->surname;
					$piothernames = $prow->other_names;
					$piemail = $prow->email_address;
					$pcount++;
					
					$cosql= "SELECT a.*, c.* FROM account a 
					JOIN co_investigator c ON a.account_id=c.account_id  AND c.protocol_id=".$proid;
					$costmt = $db->prepare($cosql);
					$costmt->execute();
					
						echo '
							<tr>
								<td style="border:1px solid pink;vertical-align:top">'.$pcount.'</td>
								<td style="border:1px solid pink;vertical-align:top" width="40%">
									'.$protitle.'<br>'.$prodesc.'
								</td>
								<td style="border:1px solid pink;vertical-align:top">
								'.$pititle.' '.$piothernames.'  '.$pisurname.'
								<br>
								';
								while($corow = $costmt->FetchObject()){
									$coid = $corow->account_id;
									$cotitle = $corow->title;
									$cosurname = $corow->surname;
									$coothernames = $corow->other_names;
									$coemail = $corow->email_address;
									echo $cotitle.' '.$coothernames.' '.$cosurname.'<br>';
								}
								echo '
								</td>
								<td style="border:1px solid pink;vertical-align:top">'.$piemail.'</td>
							</tr>
						';
				}
				echo '
					</table>
				';
		}
		
		function ActiveProtocols(){
				$db = new DbObject();
				$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
				
				$psql= "SELECT * FROM protocol p
				JOIN account a ON p.account_id=a.account_id ";
				$pstmt = $db->prepare($psql);
				$pstmt->execute();
				$pcount = 0;
				
				echo '
					<table style="font-size:12px" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td style="border:1px solid pink"><strong>No.<strong></td>
						<td style="border:1px solid pink"><strong>Protocol<strong></td>
						<td style="border:1px solid pink"><strong>Principal Investigator<strong></td>
						<td style="border:1px solid pink"><strong>Submission Date<strong></td>
						<td style="border:1px solid pink"><strong>Renewal Date<strong></td>
						<td style="border:1px solid pink"><strong>Expiry Date<strong></td>
						<td style="border:1px solid pink"><strong>Email<strong></td>
					</tr>
				';
				while ($prow = $pstmt->FetchObject()) {
					$proid = $prow->protocol_id;
					$protitle = $prow->protocol_title;
					$prodesc = $prow->protocol_desc;
					$pititle = $prow->title;
					$pisurname = $prow->surname;
					$piothernames = $prow->other_names;
					$piemail = $prow->email_address;
					
					$tsql= "SELECT * FROM protocol_transactions WHERE protocol_id=".$proid." ORDER BY transaction_id DESC";
					$tstmt = $db->prepare($tsql);
					$tstmt->execute();
					$trow = $tstmt->FetchObject();
					//..
					if(isset($trow->transaction_id)){
						$transid = $trow->transaction_id;
						$submdate = $trow->submission_date;
						$approvaldate = $trow->approval_date;
						$expirydate = date_create($trow->expiry_date);
						$pcount++;
						
						$currentDate = new DateTime();
						$diff=date_diff($currentDate,$expirydate);
						$sign = $diff->format("%R");
						$days = $diff->format("%a");
						
					
						if(($sign=="+")&&($days>0)){
							$cosql= "SELECT a.*, c.* FROM account a 
							JOIN co_investigator c ON a.account_id=c.account_id  AND c.protocol_id=".$proid;
							$costmt = $db->prepare($cosql);
							$costmt->execute();
							
							
						
							echo '
								<tr>
									<td style="border:1px solid pink;vertical-align:top">'.$pcount.'</td>
									<td style="border:1px solid pink;vertical-align:top" width="40%">
										'.$protitle.'<br>'.$prodesc.'
									</td>
									<td style="border:1px solid pink;vertical-align:top">
									'.$pititle.' '.$piothernames.'  '.$pisurname.'
									<br>
									';
									while($corow = $costmt->FetchObject()){
										$coid = $corow->account_id;
										$cotitle = $corow->title;
										$cosurname = $corow->surname;
										$coothernames = $corow->other_names;
										$coemail = $corow->email_address;
										echo $cotitle.' '.$coothernames.' '.$cosurname.'<br>';
									}
									echo '
									</td>
									<td style="border:1px solid pink;vertical-align:top">'.$submdate.'</td>
									<td style="border:1px solid pink;vertical-align:top">'.$approvaldate.'</td>
									<td style="border:1px solid pink;vertical-align:top">'.date_format($expirydate,"Y-m-d").'</td>
									<td style="border:1px solid pink;vertical-align:top">'.$piemail.'</td>
								</tr>
							';
						}
					
					}
				}
				echo '
					</table>
				';
		}
		
		function DueProtocols($daysDue){
				$db = new DbObject();
				$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
				
				$psql= "SELECT * FROM protocol p
				JOIN account a ON p.account_id=a.account_id ";
				$pstmt = $db->prepare($psql);
				$pstmt->execute();
				$pcount = 0;
				
				echo '
					<table style="font-size:12px" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td style="border:1px solid pink"><strong>No.</strong></td>
						<td style="border:1px solid pink"><strong>Protocol</strong></td>
						<td style="border:1px solid pink"><strong>Principal Investigator</strong></td>
						<td style="border:1px solid pink"><strong>Submission Date</strong></td>
						<td style="border:1px solid pink"><strong>Renewal Date</strong></td>
						<td style="border:1px solid pink"><strong>Expiry Date</strong></td>
						<td style="border:1px solid pink"><strong>Email</strong></td>
					</tr>
				';
				while ($prow = $pstmt->FetchObject()) {
					$proid = $prow->protocol_id;
					$protitle = $prow->protocol_title;
					$prodesc = $prow->protocol_desc;
					$pititle = $prow->title;
					$pisurname = $prow->surname;
					$piothernames = $prow->other_names;
					$piemail = $prow->email_address;
					
					$tsql= "SELECT * FROM protocol_transactions WHERE protocol_id=".$proid." ORDER BY transaction_id DESC";
					$tstmt = $db->prepare($tsql);
					$tstmt->execute();
					$trow = $tstmt->FetchObject();
					//..
					if(isset($trow->transaction_id)){
						$transid = $trow->transaction_id;
						$submdate = $trow->submission_date;
						$approvaldate = $trow->approval_date;
						$expirydate = date_create($trow->expiry_date);
						
						$cosql= "SELECT a.*, c.* FROM account a 
						JOIN co_investigator c ON a.account_id=c.account_id  AND c.protocol_id=".$proid;
						$costmt = $db->prepare($cosql);
						$costmt->execute();
						
						$currentDate = new DateTime();
						$diff=date_diff($currentDate,$expirydate);
						$sign = $diff->format("%R");
						$days = $diff->format("%a");
						
						if(($sign=="+")&&($days<$daysDue)){
							$pcount++;
							echo '
								<tr>
									<td style="border:1px solid pink;vertical-align:top">'.$pcount.'</td>
									<td style="border:1px solid pink;vertical-align:top" width="40%">
										'.$protitle.'<br>'.$prodesc.'
									</td>
									<td style="border:1px solid pink;vertical-align:top">
									'.$pititle.' '.$piothernames.'  '.$pisurname.'
									<br>
									';
									while($corow = $costmt->FetchObject()){
										$coid = $corow->account_id;
										$cotitle = $corow->title;
										$cosurname = $corow->surname;
										$coothernames = $corow->other_names;
										$coemail = $corow->email_address;
										echo $cotitle.' '.$coothernames.' '.$cosurname.'<br>';
									}
									echo '
									</td>
									<td style="border:1px solid pink;vertical-align:top">'.$submdate.'</td>
									<td style="border:1px solid pink;vertical-align:top">'.$approvaldate.'</td>
									<td style="border:1px solid pink;vertical-align:top">'.date_format($expirydate,"Y-m-d").'</td>
									<td style="border:1px solid pink;vertical-align:top">'.$piemail.'</td>
								</tr>
							';	
						}
					}
				}
				echo '
					</table>
				';
		}
		
		function ExpiredProtocols(){
				$db = new DbObject();
				$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
				
				$psql= "SELECT * FROM protocol p
				JOIN account a ON p.account_id=a.account_id ";
				$pstmt = $db->prepare($psql);
				$pstmt->execute();
				$pcount = 0;
				
				echo '
					<table style="font-size:12px" width="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td style="border:1px solid pink"><strong>No.</strong></td>
						<td style="border:1px solid pink"><strong>Protocol</strong></td>
						<td style="border:1px solid pink"><strong>Principal Investigator</strong></td>
						<td style="border:1px solid pink"><strong>Submission Date</strong></td>
						<td style="border:1px solid pink"><strong>Renewal Date</strong></td>
						<td style="border:1px solid pink"><strong>Expiry Date</strong></td>
						<td style="border:1px solid pink"><strong>Email</strong></td>
					</tr>
				';
				while ($prow = $pstmt->FetchObject()) {
					$proid = $prow->protocol_id;
					$protitle = $prow->protocol_title;
					$prodesc = $prow->protocol_desc;
					$pititle = $prow->title;
					$pisurname = $prow->surname;
					$piothernames = $prow->other_names;
					$piemail = $prow->email_address;
					
					$tsql= "SELECT * FROM protocol_transactions WHERE protocol_id=".$proid." ORDER BY transaction_id DESC";
					$tstmt = $db->prepare($tsql);
					$tstmt->execute();
					$trow = $tstmt->FetchObject();
					//..
					if(isset($trow->transaction_id)){
						$transid = $trow->transaction_id;
						$submdate = $trow->submission_date;
						$approvaldate = $trow->approval_date;
						$expirydate = date_create($trow->expiry_date);
						
						$cosql= "SELECT a.*, c.* FROM account a 
						JOIN co_investigator c ON a.account_id=c.account_id  AND c.protocol_id=".$proid;
						$costmt = $db->prepare($cosql);
						$costmt->execute();
						
						$currentDate = new DateTime();
						/* $diff=date_diff($currentDate,$expirydate);
						$sign = $diff->format("%R");
						$days = $diff->format("%a"); */
						
						if($expirydate<=$currentDate){
							$pcount++;
							echo '
								<tr>
									<td style="border:1px solid pink;vertical-align:top;">'.$pcount.'</td>
									<td style="border:1px solid pink;vertical-align:top;" width="40%">
										'.$protitle.'<br>'.$prodesc.'
									</td>
									<td style="border:1px solid pink;vertical-align:top;">
									'.$pititle.' '.$piothernames.'  '.$pisurname.'
									<br>
									';
									while($corow = $costmt->FetchObject()){
										$coid = $corow->account_id;
										$cotitle = $corow->title;
										$cosurname = $corow->surname;
										$coothernames = $corow->other_names;
										$coemail = $corow->email_address;
										echo $cotitle.' '.$coothernames.' '.$cosurname.'<br>';
									}
									echo '
									</td>
									<td style="border:1px solid pink;vertical-align:top;">'.$submdate.'</td>
									<td style="border:1px solid pink;vertical-align:top;">'.$approvaldate.'</td>
									<td style="border:1px solid pink;vertical-align:top;">'.date_format($expirydate,"Y-m-d").'</td>
									<td style="border:1px solid pink;vertical-align:top;">'.$piemail.'</td>
								</tr>
							';	
						}
					}
				}
				echo '
					</table>
				';
		}
		
		function PrincipalInvestigators(){
			$db = new DbObject();
				$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
				
				$sql= "SELECT a.*, p.* 
				FROM account a 
				JOIN protocol p WHERE a.account_id=p.account_id 
				GROUP BY a.account_id";
				$stmt = $db->prepare($sql);
				$stmt->execute();
				
				$count = 0; //numbers the records
				echo '
					<table style="font-size:12px" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td style="border:1px solid pink"><strong>No.</strong></td>
						<td style="border:1px solid pink"><strong>Title</strong></td>
						<td style="border:1px solid pink"><strong>Name</strong></td>
						<td style="border:1px solid pink"><strong>Email</strong></td>
						<td style="border:1px solid pink"><strong>Username</strong></td>
						<td style="border:1px solid pink"><strong>Account Type</strong></td>
					</tr>
				';
				while ($row = $stmt->FetchObject()) {
					$count++;
					$accountid = $row->account_id;
					$title = $row->title;
					$othernames = $row->other_names;
					$surname = $row->surname;
					$username = $row->username;
					$email = $row->email_address;
					$accounttype= $row->account_type;
					
					echo'
						<tr>
							<td style="border:1px solid pink" valign="top"><strong>'.$count.'</strong><br></td>
							<td style="border:1px solid pink" valign="top"><strong>'.$title.'</strong><br></td>
							<td style="border:1px solid pink" width="12%"><strong>'.$othernames.' '.$surname.'</strong><br></td>
							<td style="border:1px solid pink" valign="top"><strong>'.$email.'</strong><br></td>
							<td style="border:1px solid pink" valign="top"><strong>'.$username.'</strong><br></td>
							<td style="border:1px solid pink" valign="top"><strong>'.$accounttype.'</strong><br></td>
						</tr>
					';
					
					$psql= "SELECT * FROM protocol  
					WHERE account_id=".$accountid;
					$pstmt = $db->prepare($psql);
					$pstmt->execute();
					
					echo'
						<tr>
							<td style="border:1px solid pink"></td>
							<td style="border:1px solid pink" colspan="5"><strong>Protocolls</strong><br></td>
						</tr>
					';
					while ($prow = $pstmt->FetchObject()) {
						$protitle = $prow->protocol_title;
						$prodesc = $prow->protocol_desc;
						
						echo'
							<tr>
								<td style="border:1px solid pink"></td>
								<td style="border:1px solid pink" colspan="2" valign="top">'.$protitle.'<br></td>
								<td style="border:1px solid pink" colspan="3">'.$prodesc.'<br></td>
							</tr>
						';
					}
					echo '
					<tr>
						<td><br></td>
					<tr>
					';
				}
				echo '
					</table>
				';
		}
		
		function CoInvestigators(){
				$db = new DbObject();
				$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
				
				$sql= "SELECT a.*, c.account_id  AS co_id, c.protocol_id AS co_proid 
				FROM account a 
				JOIN co_investigator c WHERE a.account_id=c.account_id 
				GROUP BY c.account_id ASC";
				$stmt = $db->prepare($sql);
				$stmt->execute();
				
				$count = 0; //numbers the records
				echo '
					<table style="font-size:12px" width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td style="border:1px solid pink"><strong>No.</strong></td>
						<td style="border:1px solid pink"><strong>Title</strong></td>
						<td style="border:1px solid pink"><strong>Name</strong></td>
						<td style="border:1px solid pink"><strong>Email</strong></td>
						<td style="border:1px solid pink"><strong>Username</strong></td>
						<td style="border:1px solid pink"><strong>Account Type</strong></td>
					</tr>
				';
				while ($row = $stmt->FetchObject()) {
					$count++;
					$accountid = $row->account_id;
					$coid = $row->co_id;
					$coproid = $row->co_proid;
					$title = $row->title;
					$othernames = $row->other_names;
					$surname = $row->surname;
					$username = $row->username;
					$email = $row->email_address;
					$accounttype= $row->account_type;
					
					echo'
						<tr>
							<td style="border:1px solid pink" valign="top"><strong>'.$count.'</strong><br></td>
							<td style="border:1px solid pink" valign="top"><strong>'.$title.'</strong><br></td>
							<td style="border:1px solid pink" width="12%"><strong>'.$othernames.' '.$surname.'</strong><br></td>
							<td style="border:1px solid pink" valign="top"><strong>'.$email.'</strong><br></td>
							<td style="border:1px solid pink" valign="top"><strong>'.$username.'</strong><br></td>
							<td style="border:1px solid pink" valign="top"><strong>'.$accounttype.'</strong><br></td>
						</tr>
					';
					
					$cosql= "SELECT p.*, c.protocol_id, c.account_id 
					FROM protocol p JOIN co_investigator c 
					ON p.protocol_id=c.protocol_id 
					AND c.account_id =".$coid;
					$costmt = $db->prepare($cosql);
					$costmt->execute();
					
					echo'
						<tr>
							<td style="border:1px solid pink" ></td>
							<td style="border:1px solid pink" colspan="5"><strong>Protocols</strong></td>
						</tr>
					';
					while ($corow = $costmt->FetchObject()) {
						$protitle = $corow->protocol_title;
						$prodesc = $corow->protocol_desc;
						
						echo'
							<tr>
								<td style="border:1px solid pink"></td>
								<td style="border:1px solid pink" colspan="2" valign="top">'.$protitle.'<br></td>
								<td style="border:1px solid pink" colspan="3">'.$prodesc.'<br></td>
							</tr>
						';
					}
					
					echo '
						<tr>
							<td><br></td>
						<tr>
					';
				}
				echo '
					</table>
				';
		}
		
		function CanvasReport(){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$sql= "SELECT a.*, p.* 
			FROM account a 
			JOIN protocol p WHERE a.account_id=p.account_id 
			GROUP BY a.account_id";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			
			$count = 0; //numbers the records
			echo '
				<table style="font-size:12px" width="100%" cellpadding="0" cellspacing="0">
			';
			while ($row = $stmt->FetchObject()) {
				$count++;
				$accountid = $row->account_id;
				$title = $row->title;
				$othernames = $row->other_names;
				$surname = $row->surname;
				$username = $row->username;
				$email = $row->email_address;
				$accounttype= $row->account_type;
				
				echo'
					<tr>
						<td style="border:1px solid pink" valign="top"><strong>'.$count.'.</strong><br></td>
						<td style="border:1px solid pink" valign="top" colspan="5"><strong>'.$title.' '.$othernames.' '.$surname.'</strong><br></td>
					</tr>
				';
				
				$psql= "SELECT * FROM protocol  
				WHERE account_id=".$accountid;
				$pstmt = $db->prepare($psql);
				$pstmt->execute();
				
				echo'
					<tr>
						<td style="border:1px solid pink"></td>
						<td style="border:1px solid pink" colspan="5" style="border:1px solid pink"><strong>Protocols</strong><br></td>
					</tr>
				';
				while ($prow = $pstmt->FetchObject()) {
					$proid = $prow->protocol_id;
					$protitle = $prow->protocol_title;
					$prodesc = $prow->protocol_desc;
					
					echo'
						<tr>
							<td style="border:1px solid pink"></td>
							<td style="border:1px solid pink" colspan="2" valign="top"><strong>'.$protitle.'</strong><br></td>
							<td style="border:1px solid pink" colspan="3">'.$prodesc.'<br></td>
						</tr>
					';
					
					$cosql= "SELECT a.*, c.account_id, c.protocol_id, p.protocol_id 
					FROM account a JOIN co_investigator c 
					ON a.account_id=c.account_id 
					JOIN protocol p 
					ON c.protocol_id=p.protocol_id 
					AND p.protocol_id=".$proid;
					$costmt = $db->prepare($cosql);
					$costmt->execute();
					$cocount = 0;
					echo '
						
					';
					$transql= "SELECT * FROM protocol_transactions WHERE protocol_id=".$proid;
					$transtmt = $db->prepare($transql);
					$transtmt->execute();
					$trancount = 0;
					echo '
							<tr>
								<td style="border:1px solid pink"></td>
								<td style="border:1px solid pink"></td>
								<td style="border:1px solid pink" width="10%"><strong>Subm. Dates</strong><br></td>
								<td style="border:1px solid pink"><strong>Approval Dates</strong><br></td>
								<td style="border:1px solid pink"><strong>Expiry Dates</strong><br></td>
								<td style="border:1px solid pink"><strong>Transaction Dates</strong><br></td>
								</td>
							</tr>
						';
					while ($tranrow = $transtmt->FetchObject()) {
						$transid=$tranrow->transaction_id;
						$submissionDate=date_create($tranrow->submission_date);
						$approvalDate=date_create($tranrow->approval_date);
						$expiryDate=date_create($tranrow->expiry_date);
						$applicationStatus=$tranrow->application_status;
						$transactionDate=date_create($tranrow->transaction_date);
						$approved=$tranrow->approved;
						$trancount++;
						echo '
							<tr>
								<td style="border:1px solid pink"></td>
								<td style="border:1px solid pink"></td>
								<td style="border:1px solid pink">'.date_format($submissionDate, 'jS F Y').'<br></td>
								<td style="border:1px solid pink">'.date_format($approvalDate, 'jS F Y').'<br></td>
								<td style="border:1px solid pink">'.date_format($expiryDate, 'jS F Y').'<br></td>
								<td style="border:1px solid pink">'.date_format($transactionDate, 'jS F Y').'<br></td>
								</td>
							</tr>
						';
					}
					echo'
						<tr>
							<td style="border:1px solid pink"></td>
							<td style="border:1px solid pink" colspan="2" valign="top"></td>
							<td  colspan="3">
							';
							echo '
								<table width="100%" style="font-size:12px" cellpadding="0" cellspacing="0">
									<tr>
										<td style="border:1px solid pink" colspan="6"><strong>Co Investigators</strong></td>
									</tr>
							';
							while ($corow = $costmt->FetchObject()) {
								$coid = $corow->account_id;
								$cotitle = $corow->title;
								$cosurname = $corow->surname;
								$coothernames = $corow->other_names;
								$coemail = $corow->email_address;
								$cousername = $corow->username;
								$coaccounttype = $corow->account_type;
								$cocount++;
								echo '
									<tr>
										<td style="border:1px solid pink">'.$cocount.'<br></td>
										<td style="border:1px solid pink">'.$cotitle.'<br></td>
										<td style="border:1px solid pink">'.$coothernames.' '.$cosurname.'<br></td>
										<td style="border:1px solid pink">'.$coemail.'<br></td>
										<td style="border:1px solid pink">'.$cousername.'<br></td>
										<td style="border:1px solid pink">'.$coaccounttype.' <br></td>
									</tr>
								';
							}
							echo '
								</table>
							</td>
						</tr>
					';
				}
				echo '
				<tr>
					<td><br></td>
				<tr>
				';
			}
			echo '
				</table>
			';
		}
	}
?>