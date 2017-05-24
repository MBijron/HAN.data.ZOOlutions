<?php
	$food = $_POST['foodarray'];

	foreach ($food as $fooditem => $value) {
			echo "<tr class='clickable-row' onclick='setSelectedRow(this);'>";
			echo 	"<td>" . $value[0] . "</td>";
			echo 	"<td>" . $value[1] . "</td>";
			echo	"<td>" . $value[3] . "</td>";
			echo 	"<input type='hidden' name='foodQuantity[]' value='" . $value[1] . "' >";
			echo 	"<input type='hidden' name='foodId[]' value='" . $value[2] . "' >";
			echo "</tr>";
	}
?>