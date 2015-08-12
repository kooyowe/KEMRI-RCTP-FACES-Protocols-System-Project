<?php
	/* *********************************************************************
	*Account Class
	*Models the Account Object
	*@Author:	Kevin Oyowe
	 ***********************************************************************/
	class Account {
		#Properties
		var $_accountId = 0;
		var $_userId = 0;
		var $_surname = "";
		var $_otherNames = "";
		var $_title = "";
		var $_emailAddress = "";
		var $_username = "";
		var $_password = "";
		var $_accountType = "";
		var $_suspended = "";
		var $_rowsPerPage = 20;
		var $_pageNum = 1;
		var $_offset = 0;
		var $_maxPage = 0;
		
		#Setter methods
		function setAccountId($accountId){
			$this->_accountId=$accountId;
		}
		//For session management. different from setAccountId()
		function setUserId($userid){
			$this->_userId=$userid;
		}
		function setSurname($surname){
			$this->_surname=$surname;
		}
		function setOthernames($othernames){
			$this->_otherNames=$othernames;
		}
		function setTitle($title){
			$this->_title=$title;
		}
		function setEmailAddress($emailAddress){
			$this->_emailAddress=$emailAddress;
		}
		function setUsername($username){
			$this->_username=$username;
		}
		function setPassword($password){
			$this->_password=$password;
		}
		function setAccountType($accountType){
			$this->_accountType=$accountType;
		}
		function setSuspended($suspended){
			$this->_suspended=$suspended;
		}
		
		#Getter methods
		function getAccountId(){
			return $this->_accountId;
		}
		//For session management. different from getAccountId()
		function getUserId(){
			return $this->_userId;
		}
		function getSurname(){
			return $this->_surname;
		}
		function getOtherNames(){
			return $this->_otherNames;
		}
		function getTitle(){
			return $this->_title;
		}
		function getEmailAddress(){
			return $this->_emailAddress;
		}
		function getUsername(){
			return $this->_username;
		}
		function getPassword(){
			return $this->_password;
		}
		function getAccountType(){
			return $this->_accountType;
		}
		function getSuspended(){
			return $this->_suspended;
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
		
		//constructor sets user name and password
		public function __construct() {
			if( isset( $_POST['username'] ) ){
				$this->_username = $_POST['username'];
			}
			if( isset( $_POST['password'] ) ){
				$this->_password = $_POST['password'];
			}
		}
		
		//Get $_POST values from Login Form and pass to the constructor()
		public function getFormValues( $params ) {
			$this->__construct( $params );
		}
		
		
		//Validates User Login and Sets logged in user id. Returns Boolean
		public function Login() {
			$success = false;
			try{
				$db = new DbObject();
				$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
				
				$sql="SELECT * FROM `account` WHERE username = \"".$this->_username."\" AND password =PASSWORD(\"".$this->_password."\")";
				$stmt = $db->prepare($sql);
				$stmt->execute();
				$row = $stmt->FetchObject();
				$total = $stmt->rowCount();
				if($total>0) {
					$this->setUserId($row->account_id);
					$this->setAccountType($row->account_type);
					$success = true;
				}

				return $success;
			}catch (PDOException $e) {
				echo $e->getMessage();
				return $success;
			}
		}
		
		//verifies a user password
		function VerifyPassword($password){
			$verified = FALSE;
			try{
				$db = new DbObject();
				$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
				
				$sql="SELECT * FROM `account` WHERE password =PASSWORD(\"".$password."\")";
				$stmt = $db->prepare($sql);
				$stmt->execute();
				$total = $stmt->rowCount();
				if($total>0){
					$verified = TRUE;
					return $verified;
				}
			}catch(PDOException $e){
				echo $e->getMessage();
				return $verified;
			}
		}
		
		
		function ChangePassword($password,$username,$accounttype,$accid,$page){
			try{
				$db = new DbObject();
				$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
				
				$sql="UPDATE account SET password = PASSWORD(\"".$password."\"), username='".$username."', account_type='".$accounttype."' WHERE account_id =".$accid;
				$stmt = $db->prepare($sql);
				if($stmt->execute()){
					?>
					<script type="text/javascript">
						window.location = "../home/index.php?id=<?php echo $accid.'&page='.$page; ?>"
					</script>;
					<?php
				}else{
					echo '<strong class="error-text">Error:</strong><span class="message-text"> Sorry, An error occurred while trying to update the account</span>';
				}
			}catch( PDOException $e ) {
				return $e->getMessage();
			}
		}
		
		#sets all the properties of an Account instance
		function Fetch($accid){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$sql="SELECT * FROM account WHERE account_id=".$accid;
			$stmt = $db->prepare($sql);
			$stmt->execute();
			
			while ($row = $stmt->FetchObject()) {
				$this->setAccountId($row->account_id);
				$this->setSurname($row->surname);
				$this->setOthernames($row->other_names);
				$this->setEmailAddress($row->email_address);
				$this->setUsername($row->username);
				$this->setPassword($row->password);
				$this->setAccountType($row->account_type);
				$this->setSuspended($row->suspended);
				$this->setTitle($row->title);
			}
			
		}
		
		//used to automatically select the first PI when user logs in
		function Initialize(){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$sql="SELECT * FROM account WHERE account_type='Investigator'";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			
			$row = $stmt->FetchObject();
			$this->setAccountId($row->account_id);
		}
		
		function Insert($title,$sname,$onames,$eadd,$acctype,$accid){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			if(isset($_GET['page'])){
				$page=$_GET['page'];
			}else{
				$page=1;
			}
			
			$sql="INSERT INTO account(title,surname,other_names,email_address,account_type) VALUES('".$title."','".$sname."','".$onames."','".$eadd."','".$acctype."')";
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
		
		function AddInvestigator($accid,$proid,$prev_accid,$page){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$sql="INSERT INTO co_investigator(account_id,protocol_id) VALUES(".$accid.",".$proid.")";
			$stmt = $db->prepare($sql);
			if($stmt->execute()){
				?>
				<script type="text/javascript">
					window.location = "../home/index.php?id=<?php echo $prev_accid.'&page='.$page; ?>"
				</script>;
				<?php
			}else{
				echo '<strong class="error-text">Error:</strong><span class="message-text"> An Error occurred while trying to save the record.</span>';
			}
		}
		
		function Update($title,$sname,$onames,$eadd,$accid,$page){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$sql="UPDATE account SET title='".$title."', surname='".$sname."', other_names='".$onames."', email_address='".$eadd."' WHERE account_id=".$accid;
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
		
		//deletes an account from the database
		function Delete($accid,$page){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$sql="DELETE FROM account WHERE account_id=".$accid;
			$stmt = $db->prepare($sql);
			if($stmt->execute()){
				?>
				<script type="text/javascript">
					window.location = "../home/index.php?id=<?php echo $accid.'&page='.$page; ?>"
				</script>;
				<?php
			}else{
				echo 'Could not perform the requested operation';
			}
			
		}
		
		function DeleteCoInvestigator($coid,$proid,$accid,$page){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$sql="DELETE FROM co_investigator WHERE account_id=".$coid." AND protocol_id=".$proid;
			$stmt = $db->prepare($sql);
			if($stmt->execute()){
				?>
				<script type="text/javascript">
					window.location = "../home/index.php?id=<?php echo $accid; ?>&proid=<?php echo $proid.'&page='.$page;?>"
				</script>;
				<?php
			}else{
				echo 'failed';
				echo 'coid='.$coid.' proid='.$proid;
			}
		}
		
		//return boolean TRUE if account is selected
		function IsSelected($accountId,$accid){
			if($accountId==$accid){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
		//return boolean TRUE if account is selected
		function IsAdmin(){
			if($_SESSION['accounttype']=="Admin"){
				return TRUE;
			}else{
				return FALSE;
			}
		}
		
		//return boolean TRUE if the account belongs to logged in user
		function IsLoggedIn(){
			if($_SESSION['userid']==$this->getAccountId()){
				return TRUE;
				//echo $this->getUserId();
			}else{
				return FALSE;
			}
		}
		
		//return boolean TRUE if the account has protocols
		function HasProtocols($accid){
			$has = FALSE;
			try{
				$db = new DbObject();
				$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
				
				$sql="SELECT * FROM `protocol` WHERE account_id=".$accid;
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
		
		function SetUpNavigation(){
			// if $_GET['page'] is defined, use it as page number
			if(isset($_GET['page'])){
				$this->_pageNum = $_GET['page'];
			}
			// counting the offset
			$this->_offset = ($this->_pageNum - 1) * $this->_rowsPerPage;
		}
		
		function DisplayPINavigation(){
			try{
				$db = new DbObject();
				$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
				
				// how many rows we have in database
				$sql="SELECT * FROM account WHERE account_type='Investigator'";
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
				   $page  = $this->_pageNum - 1;
				   $prev  = " <a href=\"$self?id=0&page=$page\">Prev </a> ";

				   $first = " <a href=\"$self?id=0&page=1\">First </a> ";
				}
				else{
				   $prev  = 'Prev '; // we're on page one, don't print previous link
				   $first = 'First '; // nor the first page link
				}
				if ($this->_pageNum < $this->_maxPage)
				{
				   $page = $this->_pageNum + 1;
				   $next = " <a href=\"$self?id=0&page=$page\">Next </a> ";

				   $last = " <a href=\"$self?id=0&page=$this->_maxPage\">Last</a> ";
				}
				else
				{
				   $next = 'Next '; // we're on the last page, don't print next link
				   $last = 'Last '; // nor the last page link
				}
				// print the navigation link
				echo "
				<table style='width:100%;font-size:12px;font-weight:bold'>
				<tr>
				<td>".$first ."</td><td>". $prev ."</td><td>". $next ."</td><td>". $last."</td>
				</tr>
				</table>
				Showing page $this->_pageNum of $this->_maxPage pages" ;
				
			}catch(PDOException $e){
				echo $e->getMessage();
				return $has;
			}
		}
		
		#Lays out a tabular representation of a PI details
		function DisplayPI($accid,$lower,$upper){
			
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$sql= "SELECT * FROM account WHERE account_type='Investigator' limit ".$lower.", ".$upper;
			$stmt = $db->prepare($sql);
			$stmt->execute();
			
			$count = $this->_offset; //numbers the records
			
			if(isset($_GET['page'])){
				$page=$_GET['page'];
			}else{
				$page=1;
			}
			
			while ($row = $stmt->FetchObject()) {
				$accountId = $row->account_id;
				$surname = $row->surname;
				$otherNames = $row->other_names;
				$emailAddress = $row->email_address;
				$title = $row->title;
				
				$count = $count+1;
				
				echo '
					<tr>
						<td width="20px" class="font-12" >';
							echo $count.'.';
						echo '
						</td>
						<td width="" class="">
							<strong><a href="../home/index.php?id='.$accountId.'&page='.$page.'" class="pi-link">'.$title.' '.$otherNames.' '.$surname.'</a></strong>
						</td>
					</tr>';
					if($this->IsSelected($accountId,$accid)){
						if($this->IsLoggedIn()||$this->IsAdmin()){
							echo '<tr>
							<td><br></td>
							<td class="font-12">
								<a href="../account/index_edit.php?id='.$accountId.'&page='.$page.'" class="pi-button-link">Edit Account</a>  ';
								if($this->IsAdmin()){
									echo '<a href="../account/create_password.php?id='.$accountId.'&page='.$page.'" class="pi-button-link">Create Password</a>';
								}else{
									echo '<a href="../account/change_password.php?id='.$accountId.'&page='.$page.'" class="pi-button-link">Change Password</a>';
								}
							echo '
							</td>
						</tr>';
						}
					}
			}
			
			$db=null;
		}
		
		function DisplayUsers(){
			$db = new DbObject();
			$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
			
			$sql= "SELECT * FROM account WHERE account_type='Admin'";
			$stmt = $db->prepare($sql);
			$stmt->execute();
			
			$count = 0; //numbers the records
			echo '
			<table width="600px">
				<tr >
					<td class="field-head">No.</td>
					<td class="field-head">Last Name</td>
					<td class="field-head">Other Names</td>
					<td class="field-head">User Name</td>
					<td class="field-head">Edit</td>
					<td class="field-head">Password</td>
				</tr>
			';
			while ($row = $stmt->FetchObject()) {
				$accountId = $row->account_id;
				$surname = $row->surname;
				$otherNames = $row->other_names;
				$username = $row->username;
				$usertype = $row->account_type;
				$emailAddress = $row->email_address;
				$title = $row->title;
				
				$count = $count+1;
				
				echo '
				<tr>
					<td class="record-field">'.$count.'<br></td>
					<td class="record-field">'.$surname.'<br></td>
					<td class="record-field">'.$otherNames.'<br></td>
					<td class="record-field">'.$username.'<br></td>
					<td class="record-field"><a href="user_edit.php?id='.$accountId.'">Edit</a></td>
					<td class="record-field">';
						
							if(($this->IsLoggedIn())&&($this->getAccountId()==$accountId)){
								echo '<a href="../account/create_password.php?id='.$accountId.'">Password</a>';
							}else{
									echo '<br>';
							}
					
					echo '
					</td>
				</tr>
				';
			}
			echo '
			
			';
			$db=null;
		}
	}
?>