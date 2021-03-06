<?php
	/* *********************************************************************
	*Home Page
	*Pulls down a list of Principal Investigators on the left. Protocols and
	*			their Transactions are displayed on the right upon selection.
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
	<body >
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
								<?php 
									require_once("edit_protocol.php");
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