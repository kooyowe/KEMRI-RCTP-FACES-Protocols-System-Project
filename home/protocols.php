<?php

/* Page protocols.php - displays list of Protocols for a given PI */
 
?>
<table width="100%">
<tr>
	<td class="protocol-box" width="80%" colspan="5">
	<table width="100%">
	<tr>
	<th class="hexa-fill"></th>
	<th class="pink-fill" colspan="4">Protocols</th>
	<th class="hexa-fill" width="5px"></th>
	</tr>
	<?php
		if($account->IsLoggedIn()||$account->IsAdmin()){
			$protocol->SetUpNavigation();
			//display protocols list
			if(isset($_GET['id'])){
				if(isset($_GET['proid'])){
					$protocol->DisplayProtocols($accid,$proid,$page,$protocol->getOffsetLimit(),$protocol->getRowsPerPage());
				}else{
					$protocol->DisplayProtocols($accid,$proid=0,$page,$protocol->getOffsetLimit(),$protocol->getRowsPerPage());
				}
			}else{
				echo 'test';
			}
		}else{
			echo '
				<tr>
					<td colspan="5" align="center"><img src="../images/logo.png"></td>
				</tr>
			';
		}
		
	?>	
	<tr>
		<td class="" colspan="6">
			<?php
				$protocol->DisplayProtocolNavigation($accid);
			?>
		</td>
	</tr>
	<tr>
		<td colspan="7" valign="top">
			<?php
			if($account->IsAdmin()){
				if(isset($_GET['id'])&&($_GET['id']>0)){
					?><input type="button" onclick="window.location.href='../protocol/new_protocol_index.php?id=<?php echo $accid.'&page='.$page;?>'" value="Add Protocol"><?php
				}
			}
			?>
			
		</td>
	</tr>
	</table>
	</td >
	<td valign="top">
		<table id="key" width="100%" class="protocol-key-box">
			<tr>
				<th class="key-header" colspan="2">Key</th>
			</tr>
			<tr>
				<td class="key-item-active" width="5px"><br></td>
				<td class="key-item-desc">Active Protocol</td >
			</tr>
			<tr>
				<td class="key-item-due"><br></td>
				<td class="key-item-desc">Due in 30 days</td >
			</tr>
			<tr>
				<td class="key-item-pending"><br></td>
				<td class="key-item-desc">Awaiting Approval</td >
			</tr>
			<tr>
				<td class="key-item-expired"><br></td>
				<td class="key-item-desc">Expired</td >
			</tr>
			<tr>
				<td class="key-item-approved"><img src="../images/approved.ico"></td>
				<td class="key-item-desc">Approved</td >
			</tr>
		</table>
	</td>
</tr>
</table>