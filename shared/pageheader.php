<?php
	//Fetch details of logged in user.
	$account->Fetch($session->getUserId());
?>
<table width="100%" class="banner-table">
	<tr class="height-44">
		<td  valign="center" width="250px">
			<table width="100%" style="border:1px solid green;height:40px">
				<tr>
					<td>
						<a href="../home/index.php?id=0&page=1" style="text-decoration:none;"><span style="color:white;font-size:16px;font-weight:bold">Protocols Management System</span></a>
					</td>
				</tr>
			</table>
			
		</td>
		<td align="right" valign="bottom">
			<table >
				<tr>
					<td align="right" style="color:orange;">|</td>
					<td align="right" style="color:white;font-size:12px">
						<a href="" style="color:white;font-size:12px">
							<?php
								echo $account->getTitle().' '.$account->getOtherNames().' '.$account->getSurname();
							?>
						</a>
					</td>
					<td align="right" style="color:orange">|</td>
					<td align="right" style="color:white;font-size:12px">
							<?php
								if($session->getAccountType()=="Admin"){
									echo '<a href="../admin/users.php" style="color:white;font-size:12px">Admin</a>';
								}
							?>
					</td>
					<td align="right" style="color:orange">|</td>
					<td align="right" >
						<a href="" style="color:white;font-size:12px">
							Help
						</a>
					</td>
					<td align="right" style="color:orange">|</td>
					<td align="right" >
						<a href="../shared/logout.php" style="color:white;font-size:12px">
							Logout
						</a>
					</td>
					<td align="right" style="color:orange">|</td>
				</tr>
			</table>
			
		</td>
	</tr>
</table>
<?php
	//revert to details of selected PI
	if(isset($accid)){
		$account->Fetch($accid);
	}
?>