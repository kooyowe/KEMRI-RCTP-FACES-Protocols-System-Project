<?php

/* Page pi.php - displays list of Principal Investigators */

?>
<td id="left" width="20%" valign="top" class="left-nav">					
	<table width="100%">
		<tr>
			<td class="pi-box" colspan="5">
				<table width="100%" class="table-collapse">
					<tr >
						<td valign="bottom" align="" class="bottom-border" colspan="2">
							<img src="../images/kemri-logo.ico" width="32px">
							<img src="../images/rctp_faces.jpeg" width="50px">
						</td>
					</tr>
					<tr>
						<td colspan="2"><strong>KEMRI-RCTP FACES</strong><br><br></td>
					</tr>
					<?php
						$account->SetUpNavigation();
						if(isset($_GET['id'])){
							$account->DisplayPI($accid,$account->getOffsetLimit(),$account->getRowsPerPage());
						}else{
							$account->DisplayPI($accid=1,$account->getOffsetLimit(),$account->getRowsPerPage());
						}
						
					?>	
				</table>
			</td>
		</tr>
		<tr>
			<td class="bottom-border">
				
			</td>
		</tr>
		<tr>
			<td class="navigation">
				<?php
					$account->DisplayPINavigation();
				?>
			</td>
		</tr>
		<tr>
			<td class="bottom-border">
				
			</td>
		</tr>
		<tr>
			<td>
				<div id="">
				<?php
					if($account->IsAdmin()){
						echo '<a href="../account/index.php?id=0&page='.$page.'" class="link-no-deco"><input type="button" value="Add Account"></a>';
					}
				?>
				</div>
			</td>
		</tr>
	</table>
</td>