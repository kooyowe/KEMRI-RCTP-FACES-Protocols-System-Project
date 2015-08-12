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
								<table width="74%" height="300px">
									<tr>
										<td align="center">
											<span style="color:orange">
												<strong>New Protocol created successfully!</strong>
											</span>
											<form>
												<br>
												<input type="button" value="OK" onclick="window.location.href='../home/index.php?id=<?php echo $accid;?>'">
											</form>
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