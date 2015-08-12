<table width="80%">
	<tr>
		<td class="transaction-header">
			<strong>
					<?php
					if($account->IsLoggedIn()||$account->IsAdmin()){
						if(isset($_GET['proid'])){
							echo '<span class="font-12">'.$protocol->getProtocolTitle().' - '.$account->getTitle().' '.$account->getOtherNames().' '.$account->getSurname().'</span>';
							if($protocol->HasCoInvestigator($proid)){
									$protocol->ListCoInvestigators($proid,$accid,$page);
							}
						}else{
							echo '<span class="transaction-title">
									<strong>Transactions</strong>
								</span>';
						}
					}
					?>
				</strong>
		</td>
	</tr>
</table>
<table width="100%">
<tr>
	<td class="transaction-box" colspan="5">
	<table width="100%" class="font-12">
	<th class="hexa-fill"></th>
	<th class="pink-fill">Submitted On</th>
	<th class="pink-fill">Approved On</th>
	<th class="pink-fill">Expiry Date</th>
	<th class="pink-fill">Status</th>
	<th class="pink-fill">Transaction Date</th>
	<th class="hexa-fill"></th>
	<?php
		if($account->IsLoggedIn()||$account->IsAdmin()){
			if(isset($_GET['proid'])){
				$transaction->DisplayTransactions($proid);
			}
		}
	?>	
	</td>
	</table>
</tr>
</table>