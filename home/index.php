<?php
	include "../shared/global_vars.php";
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
					<table width="100%" class="page-table">
						<tr>
							<?php
								include "../shared/pi.php";
							?>
							<td id="right" valign="top" align="left">
								<?php 
									include "protocols.php";
									include "protocol_transactions.php";
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