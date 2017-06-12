<?php

	$medicines = ($_POST['medicinearray']);

		echo "<table class='table selectable-table' data-extra-fields='token: biep'>
				<thead>
					<th>Medicine</th>
					<th>Startdate</th>
					<th>Enddate</th>
				</thead>
				<tbody>";

	foreach ($medicines as $medicine) {
		echo "	<tr class='clickable-row' onclick='setSelectedRow(this);'>
					<td>" . $medicine[1] . "</td>
					<td>" . $medicine[2] . "</td>
					<td>" . $medicine[3] . "</td>
					<input type='hidden' name='startdate[]' value=" . $medicine[2] . ">
					<input type='hidden' name='enddate[]' value=" . $medicine[3] . ">
					<input type='hidden' name='medicineId[]' value=" . $medicine[0] . ">
				</tr>";
	}

	echo "		</tbody>
			</table>";

?>