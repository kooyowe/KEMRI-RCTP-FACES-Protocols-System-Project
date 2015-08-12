<?php
	/* *********************************************************************
	*Protocol Index Page
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
					<table width="100%" style="background:#E1CC76">
						<tr >
							<td width="100%">
								<span style="color:;font-size:18">
									<strong>
										KEMRI-RCTP
									</strong>
								</span>
							</td>
						</tr>
					</table>
					<table style="background:red;width:100%;">
						<tr >
							<td></td>
						</tr>
					</table>
					<table width="100%">
						<tr>
							<td id="left" width="20%" valign="top" style="background:#E1CC76">
								<?php
									require_once("../home/pi.php"); 
								?>
							</td>
							<td id="separator" width="2px" style="background:red"> <br> </td>
							<td id="right" valign="top" align="left">
								<?php 
									require_once("renew_protocol.php");
								?>
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