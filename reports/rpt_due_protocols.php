<?php 
	if ($_SERVER["REQUEST_METHOD"] != "POST") {
		?><strong>Due Protocols Report<br><br></strong>
		<form method="post" action="">
			<span class="font-12">
			Due In<br>
				<select name="daysdue" class="text-input-report">
					<option value=30>4 weeks</option>
					<option value=44>6 weeks</option>
					<option value=60>8 weeks</option>
				</select>
				<input type="submit" value="SUBMIT">
			</span>
		</form>
		<?php
	}else{
	?>
		<table width="100%">
		<tr>
			<td class="protocol-box" width="80%" colspan="5">
			<?php 
				$days = $_POST['daysdue'];
				if($days==30){
					$period ="1 month";
				}elseif($days==44){
						$period="6 weeks";
				}elseif($days=="60"){
					$period="2 months";
				}
				echo '
					<strong>Due Protocols Report<br></strong>
					<a href="../reports/print_due.php?days='.$days.'" target="blank"><img src="../images/print.jpg" alt="Print" width="50px" style="border:1px solid black"></a><br><br>
					Expiring in the Next '.$period.'
				';
				$report->DueProtocols($days);
			?>
			</td>
		</tr>
		</table>
	<?php 
	}
?>