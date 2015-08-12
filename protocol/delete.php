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
								<table width="" height="">
									<tr>
										<td align="">
											<strong class="message-text">
											<img src="../images/spinner.gif">.. please wait ..
											</strong>
												<?php
												if($protocol->HasTransactions($proid)){
													?>
													<table width="400px">
														<tr>
															<th class="hexa-fill" width="20px" ></th>
															<th class="pink-fill" >
																<?php echo $protocol->getProtocolTitle();?>
															</th>
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
																echo $protocol->getProtocolDesc();
															?>
															<br><br>
															
															</td>
														</tr>
														<tr>
															<td ></td>
															<td  class="bottom-border">
															<span class="message-text">
																This Protocol has transactions. Do you wish to delete this protocol and all its transactions?
															</span>
															</td>
														</tr>
														<tr>
															<td ></td>
															<td>
																<form>
																	<a href="delete.php?id=<?php echo $accid;?>&proid=<?php echo $proid;?>" class="link-no-deco"><input type="button" value="Yes"></a>
																	<input type="button" value="No" onclick="window.location.href='../protocol/index.php?id=<?php echo $accid;?>&proid=<?php echo $proid?>'">
																</form>
															</td>
														</tr>
													</table>
													<?php
												}else{
													$protocol->Delete($accid,$proid);
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