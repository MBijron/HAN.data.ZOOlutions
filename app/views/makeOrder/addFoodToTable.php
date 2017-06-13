<?php
	$food = $_POST['foodarray'];

	foreach ($food as $fooditem => $value) {
			echo "<tr class='clickable-row' onclick='setSelectedRow(this);'>
				 	<td>" . $value[0] . "</td>
				 	<td>" . $value[1] . "</td>
					<td>" . $value[3] . "</td>
					<input type='hidden' name='foodQuantity[]' value='" . $value[1] . "' >
					<input type='hidden' name='foodId[]' value='" . $value[2] . "' >
					<input type='hidden' name='unit[]' value='" . $value[3] . "' >
				 </tr>";
	}
?>