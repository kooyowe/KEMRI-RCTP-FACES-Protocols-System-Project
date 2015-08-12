<?php
	/* *********************************************************************
	*Protocol Home Page
	*@Author:	Kevin Oyowe
	*@Date:		Jan 30, 2015
	 ***********************************************************************/
?>

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
								<table width="400px" height="">
									<tr>
										<td align="">
											<strong class="message-text">
												<img src="../images/spinner.gif">.. please wait ..
											</strong>
												<?php
												if($account->HasProtocols($accid)){
													?>
													<table width="400px">
														<tr>
															<th class="hexa-fill" width="20px" ></th>
															<th class="pink-fill" ><?php echo $account->getTitle().' '.$account->getSurname().' '.$account->getOthernames();?></th>
														</tr>
														<tr>
															<td class="hexa-fill" width="20px" ></td>
															<td class="pink-fill" ></td>
														</tr>
														<tr>
															<td class="" width="20px" rowspan=""></td>
															<td class="protocol-title-desc-box">
															<br>
															<?php
																echo $account->getEmailAddress();
															?>
															<br><br>
															
															</td>
														</tr>
														<tr>
															<td ><br></td>
															<td class="bottom-border">
																<span class="message-text">This account has protocols. Ensure the account has no Protocols before you delete.
																</span>
															</td>
														</tr>
														<tr>
															<td ></td>
															<td>
																<form>
																	<a href="delete.php?id=<?php echo $accid;?>" class="link-no-deco"><input type="button" value="Yes"></a>
																	<input type="button" value="No" onclick="window.location.href='../account/index_edit.php?id=<?php echo $accid;?>'">
																</form>
															</td>
														</tr>
													</table>
													<?php
												}else{
													$account->Delete($accid,$page);
												}
												
												?>
										</td>
									</tr>
								</table>
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