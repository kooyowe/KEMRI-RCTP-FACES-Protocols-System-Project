<?php
	require_once("../shared/global_vars.php");
?>

<html xmlns="http://www.w3.org/1999/xhtml">
	<?php 
		include "../shared/head.php"; 
	?>	
	<body>
		<div id="container">
			<?php
				include "../shared/pageheader.php"; 
			?>
			<div >
				<div class="page-body">
					<table width="100%">
						<tr>
							<?php
								require_once("../shared/pi.php");
							?>
							<td id="right" valign="top" align="left">
								<span class="message-text">
								<br>
									<strong>Are you sure you want to remove the Co-Investigator?</strong>
								</span>
								<table width="400px">
									<tr>
										<th class="hexa-fill" width="20px" ></th>
										<th class="pink-fill" ><?php /* echo $account->getTitle().' '.$account->getSurname().' '.$account->getOthernames(); */?></th>
									</tr>
									<tr>
										<td ></td>
										<td>
											<form>
												<a href="delete_coi.php?coid=<?php echo $coid.'&proid='.$proid.'&id='.$accid.'&page='.$page;?>" class="link-no-deco"><input type="button" value="Yes"></a>
												<input type="button" value="No" onclick="window.location.href='../home/index.php?id=<?php echo $accid.'&proid='.$proid.'&page='.$page;?>'">
											</form>
										</td>
									</tr>
								</table>
								<br>
								
							</td>
						</tr>
					</table>
				</div>
			</div>
			<?php 
				#Page Footer
				include "../shared/footer.php";
			?>
		</div>
	</body>
</html>