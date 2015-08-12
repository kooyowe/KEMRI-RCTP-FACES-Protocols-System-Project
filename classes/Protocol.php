<?php
	/* *********************************************************************
	*Protocol Class
	*Models the Protocol Object
	*Defines Protocol methods
	*@Author:	Kevin Oyowe
	 ***********************************************************************/
	Class Protocol{
		//fundamental properties
		var $_protocolId = 0;
		var $_protocolTitle = "";
		var $_protocolDesc = "";
		var $_accountId = 0;
		var $_discontinue = 0;
		
		//check properties
		var $_transactions = 0;
		var $_approved = 0; 
		var $_expiryDate = "";
		var $_currentDate = "";
		var $_sign = "";
		var $_days = 0;
		var $_period = "";
		
		//select properties
		var $_collapse = 0;
		var $_expand = 0;
		
		//paging properties
		var $_rowsPerPage = 5;
		var $_pageNum = 1;
		var $_offset = 0;
		var $_maxPage = 0;
		
		//setters
		function setProtocolId($protocolId){
			$this->_protocolId=$protocolId;
		}
		function setProtocolTitle($protocolTitle){
			$this->_protocolTitle=$protocolTitle;
		}
		function setProtocolDesc($protocolDesc){
			$this->_protocolDesc=$protocolDesc;
		}
		function setDiscontinue($discontinue){
			$this->_discontinue=$discontinue;
		}
		
		//getters
		function getProtocolId(){
			return $this->_protocolId;
		}
		function getProtocolTitle(){
			return $this->_protocolTitle;
		}
		function getProtocolDesc(){
			return $this->_protocolDesc;
		}
		function getDiscontinue(){
			return $this->_discontinue;
		}
		function getOffSetLimit(){
			return $this->_offset;
		}
		function getRowsPerPage(){
			return $this->_rowsPerPage;
		}
		function getMaxPage(){
			return $this->_maxPage;
		}
		
		//Forces the current Protocol Transaction to disapprove
		function Expire($proid){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			//get last transaction id
			$sql="SELECT * FROM protocol_transactions WHERE protocol_id=".$proid." ORDER BY transaction_id DESC";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$row = $stmt->FetchObject();
			$lasttransid = $row->transaction_id;
			
			//update its transaction
			$updsql="UPDATE protocol_transactions SET approved=0 WHERE transaction_id=".$lasttransid;
			$updstmt = $db->prepare($updsql);
			$updstmt->execute();		
		}
		
		//Sets all the properties of a Protocol instance
		function Fetch($proid){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$sql="SELECT * FROM protocol WHERE protocol_id=".$proid;
			$stmt = $db->prepare($sql);
			$stmt->execute();
			
			while ($row = $stmt->FetchObject()) {
				$this->setProtocolId($row->protocol_id);
				$this->setProtocolTitle($row->protocol_title);
				$this->setProtocolDesc($row->protocol_desc);
				$this->setDiscontinue($row->discontinue);
			}
			
		}
		
		//
		function ValidateTitle($protocoltitle){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$titleQ="SELECT * FROM protocol WHERE protocol_title='".$protocoltitle."'";
			$tStmt = $db->prepare($titleQ);
			$tStmt->execute();
			$tRow = $tStmt->FetchObject();
			
			$titles = $tStmt->rowCount();
			if($titles>0){
				return FALSE;
			}else{
				return TRUE;
			}
		}
		
		function ValidateDesc($protocoldesc){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$descQ="SELECT * FROM protocol WHERE protocol_desc='".$protocoldesc."'";
			$dStmt = $db->prepare($descQ);
			$dStmt->execute();
			$dRow = $dStmt->FetchObject();
			
			$descs = $dStmt->rowCount();
			if($descs>0){
				return FALSE;
			}else{
				return TRUE;
			}
		}
		
		//used during login to select first protocol for initialized PI
		function Initialize($id){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$sql="SELECT * FROM protocol WHERE account_id=".$id;
			$stmt = $db->prepare($sql);
			$stmt->execute();
			
			$row = $stmt->FetchObject();
			$this->setProtocolId($row->protocol_id);
		}
		
		//deletes a protocol from the database
		function Delete($accid,$proid){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$sql="DELETE FROM protocol WHERE protocol_id=".$proid;
			$stmt = $db->prepare($sql);
			if($stmt->execute()){
				?>
				<script type="text/javascript">
					window.location = "../home/index.php?id=<?php echo $accid; ?>"
				</script>;
				<?php
			}else{
				echo 'Could not perform the requested operation.';
			}
			
		}
		
		//Updates a protocol
		function Update($prot,$prod,$accid,$disc,$proid,$page){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$sql = "UPDATE protocol SET protocol_title=\"".$prot."\", protocol_desc=\"".$prod."\", account_id=".$accid.", discontinue=".$disc." WHERE protocol_id=".$proid;
			$stmt = $db->prepare($sql);
			if($stmt->execute()){
				?>
				<script type="text/javascript">
					window.location = "../home/index.php?id=<?php echo $accid; ?>&proid=<?php echo $proid.'&page='.$page;?>"
				</script>;
				<?php
			}else{
				echo '<strong class="error-text">Error:</strong><span class="message-text"> An Error occurred while trying to save the record.</span>';
			}
		}
		
		//creates a new protocol
		function Insert($prot,$prod,$accid,$desc,$page){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$sql = "INSERT INTO protocol(protocol_title,protocol_desc,account_id,discontinue) VALUES(\"".$prot."\",\"".$prod."\",".$accid.",".$desc.")";
			$stmt = $db->prepare($sql);
			if($stmt->execute()){
				?>
				<script type="text/javascript">
					window.location = "../home/index.php?id=<?php echo $accid.'&page='.$page; ?>"
				</script>;
				<?php
			}else{
				echo '<strong class="error-text">Error:</strong><span class="message-text"> An Error occurred while trying to save the record.</span>';
			}
		}
		
		//sets the check properties
		function setChecks($protocolId){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$this->_currentDate = new DateTime();
			$this->_expiryDate = new DateTime();
			
			//query the last transaction
			$sql="SELECT * FROM protocol_transactions WHERE protocol_id=".$protocolId.' ORDER BY transaction_id DESC';
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$row = $stmt->FetchObject();
			
			//set checks
			$this->_transactions = $stmt->rowCount();
			if($this->_transactions>0){
				$this->_approved = $row->approved;
				$this->_expiryDate = date_create($row->expiry_date);
				
				$diff=date_diff($this->_currentDate,$this->_expiryDate);
				$this->_sign = $diff->format("%R");
				$this->_days = $diff->format("%a");					
			}
		}
		
		//return boolean TRUE if protocol is selected
		function IsSelected($protocolId,$proid){
			if($protocolId==$proid){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
		//return boolean TRUE if protocol is due
		function IsDue(){
			if(($this->_sign=='+')&&($this->_days<=30)){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
		//return boolean TRUE if protocol is pending renewal
		function IsPendingRenewal(){
			if(($this->_approved==0)&&($this->_sign=='+')){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
		//return boolean TRUE if protocol has expired
		function IsExpired($protocolId){
			if($this->_sign=='-'){
				$this->Expire($protocolId);
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
		//return boolean TRUE if Protocol has co-investigators
		function HasCoInvestigator($proid){
			$has = FALSE;
			try{
				$db = new DbObject();
				$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
				
				$sql="SELECT * FROM `co_investigator` WHERE protocol_id=".$proid;
				$stmt = $db->prepare($sql);
				$stmt->execute();
				$total = $stmt->rowCount();
				if($total>0){
					$has = TRUE;
					return $has;
				}
			}catch(PDOException $e){
				//echo $e->getMessage();
				return $has;
			}
		}
		
		function ListCoInvestigators($proid,$accid,$page){
			try{
				$db = new DbObject();
				$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
				
				$sql="SELECT * FROM `co_investigator` WHERE protocol_id=".$proid;
				$stmt = $db->prepare($sql);
				$stmt->execute();
				
				while ($row = $stmt->FetchObject()) {
					$coid = $row->account_id;
					$cosql="SELECT * FROM `account` WHERE account_id=".$coid;
					$costmt = $db->prepare($cosql);
					$costmt->execute();
					$corow = $costmt->FetchObject();
					$cotitle= $corow->title;
					$cosurname= $corow->surname;
					$coothernames= $corow->other_names;
					echo '<span class="font-12">, '.$cotitle.' '.$coothernames.' '.$cosurname.' <a href="../account/delcoi_confirm.php?coid='.$coid.'&proid='.$proid.'&id='.$accid.'&page='.$page.'" class="font-10">[Del]</a></span>';
				}
				
			}catch(PDOException $e){
				echo 'Error selecting investigators in Protocol > ListCoInvestigators()';
			}
		}
		
		//return boolean TRUE if the protocol has transactions
		function HasTransactions($proid){
			$has = FALSE;
			try{
				$db = new DbObject();
				$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
				
				$sql="SELECT * FROM `protocol_transactions` WHERE protocol_id=".$proid;
				$stmt = $db->prepare($sql);
				$stmt->execute();
				$total = $stmt->rowCount();
				if($total>0){
					$has = TRUE;
					return $has;
				}
			}catch(PDOException $e){
				echo $e->getMessage();
			}
		}
		
		//calculates days remaining until protocol expiry
		function ComputePeriod(){
			$this->_period="days";
			if($this->_sign=='+'){ //not yet expired
				if($this->_days>0){
					if($this->_days>30){
						$this->_days=(round($this->_days/30));
						$this->_period="months";
						if($this->_days>=12){
							$this->_days=(round($this->_days/12));
							$this->_period="years";
						}
					}
					echo $this->_sign.$this->_days.' '.$this->_period;
				}else{
					echo 'due today';
				}
			}else{ //has expired
				if($this->_days>0){
					if($this->_days>30){
						$this->_days=(round($this->_days/30));
						$this->_period="months";
						if($this->_days>=12){
							$this->_days=(round($this->_days/12));
							$this->_period="years";
						}
					}
					echo $this->_days.' '.$this->_period.' ago';
				}else{
					echo 'expired today';
				}
			}
		}
		
		function SetUpNavigation(){
			// if $_GET['protocol_page'] is defined, use it as page number
			if(isset($_GET['protocol_page'])){
				$this->_pageNum = $_GET['protocol_page'];
			}
			// counting the offset
			$this->_offset = ($this->_pageNum - 1) * $this->_rowsPerPage;
		}
		
		function DisplayProtocolNavigation($accid){
			try{
				$db = new DbObject();
				$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
				
				// how many rows we have in database
				$sql="SELECT * FROM protocol WHERE account_id=".$accid;
				$stmt = $db->prepare($sql);
				$stmt->execute();
				$total = $stmt->rowCount();
				
				// how many pages we have when using paging?
				$this->_maxPage = ceil($total/$this->_rowsPerPage);
				
				// print the link to access each page
				$self = $_SERVER['PHP_SELF'];
				// creating previous and next link
				// plus the link to go straight to
				// the first and last page
				if ($this->_pageNum > 1)
				{
				   $page = $_GET['page'];
				   $protocol_page  = $this->_pageNum - 1;
				   $prev  = " <a href=\"$self?id=$accid&page=$page&protocol_page=$protocol_page\">Prev </a> ";

				   $first = " <a href=\"$self?id=$accid&page=$page&protocol_page=1\">First </a> ";
				}
				else{
				   $prev  = 'Prev '; // we're on page one, don't print previous link
				   $first = 'First '; // nor the first page link
				}
				if ($this->_pageNum < $this->_maxPage)
				{
				   $page = $_GET['page'];
				   $protocol_page = $this->_pageNum + 1;
				   $next = " <a href=\"$self?id=$accid&page=$page&protocol_page=$protocol_page\">Next </a> ";

				   $last = " <a href=\"$self?id=$accid&page=$page&protocol_page=$this->_maxPage\">Last</a> ";
				}
				else
				{
				   $next = 'Next '; // we're on the last page, don't print next link
				   $last = 'Last '; // nor the last page link
				}
				
				// print the navigation link
				if($total>5){
					echo "
					<table style='width:100%;font-size:12px;font-weight:bold'>
					<tr class='navigation'>
					<td class=>".$first ."</td><td>". $prev ."</td><td>". $next ."</td><td>". $last."</td>
					</tr>
					</table>
					" ;
				}
				
			}catch(PDOException $e){
				echo $e->getMessage();
			}
		}
		
		//Lays out a tabular representation of a PI's Protocols details
		function DisplayProtocols($accid,$proid,$page,$lower,$upper){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$sql="SELECT * FROM protocol WHERE account_id=".$accid." limit ".$lower.", ".$upper;
			$stmt = $db->prepare($sql);
			$stmt->execute();
			$total=$stmt->RowCount();
			
			$count = $this->_offset; //numbers the records
			
			if(($accid<=0)||($total<=0)){
				echo '
					<tr>
						<td colspan="5" align="center"><img src="../images/logo.png"></td>
					</tr>
				';
			}
			while ($row = $stmt->FetchObject()) {
				$protocolId = $row->protocol_id;
				$protocolTitle = $row->protocol_title;
				$protocolDesc = $row->protocol_desc;
				
				$count = $count+1;
				
				if(isset($_GET['page'])){
					$page=$_GET['page'];
				}else{
					$page=1;
				}
				
				if(isset($_GET['protocol_page'])){
					$protocol_page=$_GET['protocol_page'];
				}else{
					$protocol_page=1;
				}
				
				$this->setChecks($protocolId);
				echo '
					<tr '; 
						if($this->IsSelected($protocolId,$proid)){
							echo 'class="selected"';
						}
						echo '>
						<td class="index-field" width="15px">';
							if($_SESSION['accounttype']=="Admin"){
								echo '<a href="../protocol/index.php?id='.$accid.'&proid='.$protocolId.'" title="Edit Protocol">'.$count.'</a>';
							}else{
								echo $count;
							}
							if(!$this->IsSelected($protocolId,$proid)){
								echo '
								</td>
									<td class="record-field" width="80%"><a href="../home/index.php?id='.$_GET['id'].'&proid='.$protocolId.'&page='.$page.'&protocol_page='.$protocol_page.'" class="protocol-link"><strong>'.$protocolTitle.' -</strong> <span style="color:orange">'.substr($protocolDesc,0,95).'..</span></a>
								</td>
								<td ';
							}else{
								echo '
								</td>
									<td class="record-field" width="80%"><a href="../home/index.php?id='.$_GET['id'].'&page='.$page.'&protocol_page='.$protocol_page.'" class="protocol-link"><strong>'.$protocolTitle.' -</strong > <span style="color:orange">'.substr($protocolDesc,0,95).'..</span></a>
								</td>
								<td ';
							}
							
							if($this->_transactions>0){
								if($this->IsDue()){
									echo 'class="due"';
								}
								
								if($this->IsPendingRenewal()){
									echo 'class="pending"';
								}
								
								if($this->IsExpired($protocolId)){
									echo 'class="expired"';
								}
							}else{
								echo 'class="pending"';
							}
						echo' class="blank-td" width="20px"><br></td>
						<td class="record-field" width="10%">'; 			
							if($this->_transactions>0){
								$this->ComputePeriod();
							}else{
								echo 'pending';
							} 
						echo '</td>
						<td class="record-field">'; 
							if($this->_transactions>0){
								if($this->_approved==1){
									echo '<img src="../images/approved.ico" width="">';
								}else{
									echo '<br>';
								} 
							}else{
								echo '<br>';
							}
							echo '</td>
						<td class="select-field">';
							if(!$this->IsSelected($protocolId,$proid)){
								echo '<a href="../home/index.php?id='.$_GET['id'].'&proid='.$protocolId.'" title="Select Protocol" width"5px" class="link-no-deco">+</a><br>';
							}else{
								echo '<a href="../home/index.php?id='.$_GET['id'].'" title="Select Protocol" width"5px" class="link-no-deco">-</a><br>';
							}
							echo '
						</td>
					</tr>';
					if($this->IsSelected($protocolId,$proid)){
						echo '
							<tr>
								<td><br></td>
								<td colspan="4" class="record-field"><strong class="protocol-desc-text">'.$protocolDesc.'</strong></td>
							</tr>';
							if($_SESSION['accounttype']=="Admin"){
								echo '
							<tr>
								<td><br></td>
								<td >
									<a href="../protocol/index.php?id='.$accid.'&proid='.$protocolId.'&page='.$page.'" title="Edit Protocol" class="protocol-button-link">Edit</a>
									<img src="../images/shim.gif">
									<a href="../account/investigator.php?id='.$accid.'&proid='.$proid.'&previd='.$accid.'&page='.$page.'" class="protocol-button-link">Add Investigator</a>
								</td>
							</tr>';
							}
							
					}
			}
		}
	}
?>