<script type="text/javascript">
/* ========== */
/*  VARIABLES */
/* ========== */
	var FOODNAME = 0
	var FOODQUANTITY = 1;

	var foodArray = new Array();
	var selectedRow;


/* =============== */
/*  MAIN FUCNTIONS */
/* =============== */
	function refreshUnit() {
		var foodId = $("#foodSelector").val();

	    $.ajax({
	        url: "/makeOrder/getUnit",
	        type: "POST",
	        dataType:"html",
    		data: { foodid: foodId },
	        success: function(data) {
	        	document.getElementById("unit").innerHTML = data;
	        }
	    });
	}

	function addFood() {
		if ($("#quantityInput").val() != "") {

			var selectedFood = $("#foodSelector option:selected").html();
			var quantity = $("#quantityInput").val();
			var index = 0;

			if (foodArray.length > 0) {
				for (fooditem in foodArray) {
					if (foodArray[fooditem][FOODNAME] == selectedFood) {
						foodArray[fooditem][FOODQUANTITY] = parseInt(quantity) + parseInt(foodArray[fooditem][FOODQUANTITY]);
					} else {
						index++;
					} 

					if (index == foodArray.length) {
						foodArray.push([selectedFood, quantity, $("#foodSelector").val()]);
					}
				}
			} else {
				foodArray.push([selectedFood, quantity, $("#foodSelector").val()]);
			}

			$.ajax({
		        url: "/app/views/makeOrder/addFoodToTable.php",
		        type: "POST",
		        dataType:"html",
        		data: { foodarray: foodArray },
		        success: function(data) {
			        document.getElementById("orderTableBody").innerHTML = data;
			    }
		    });
		} else {
			alert("Please fill in the quantity");
		}
	}

	function removeFood() {

		removeItem(foodArray, selectedRow - 1);

		if (foodArray.length > 0) {
			$.ajax({
		        url: "/app/views/makeOrder/addFoodToTable.php",
		        type: "POST",
		        dataType:"html",
	    		data: { foodarray: foodArray },
		        success: function(data) {
		        	document.getElementById("orderTableBody").innerHTML = data;
		        }
	    	});
	    } else {
	    	document.getElementById("orderTableBody").innerHTML = [''];
	    }
	}

/* ================ */
/*  OTHER FUCNTIONS */
/* ================ */
	function setSelectedRow(row) {
		selectedRow = row.rowIndex;
	}

	function removeItem(array, key) {
	   if (!array.hasOwnProperty(key))
	      return;
	   if (isNaN(parseInt(key)) || !(array instanceof Array))
	      delete array[key];
	   else
	      array.splice(key, 1);

	  return array;
	};
</script>

<section class="makeOrder">
	<div class="container">
		<form name="makeOrderForm" id="makeOrderForm" method="POST" action="/makeOrder">
			<div class="col-md-8 col-sm-12">
				<div class="row">
					<div class="form-inline col-md-12">
						<label for="makeOrderForm"><h2>Order name</h2></label>
						<input type="text" name="ordername" class="form-control" id="ordername" placeholder="Order name">
					</div>
				</div>

				<div class="row">
					<div class="form-group col-md-12">
						<label for="makeOrderForm"><h2>Area</h2></label>
						<select class="selectpicker" id="areaSelector" name="areaSelector">
							{foreach from=$areas item=$area}
								<option value="{$area->AREAID}">{$area->AREANAME}</option>
							{/foreach}
						</select>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
						<label for="makeOrderForm"><h2>Food</h2></label>
						<select class="selectpicker" id="foodSelector" name="foodSelector" data-live-search="true" onchange="refreshUnit();">
							{foreach from=$food item=$foodname}
								<option value="{$foodname->FOODID}">{$foodname->FOODNAME}</option>
							{/foreach}
						</select>
					</div>
					
					<div class="col-md-4 col-md-offset-2">
						<div class="row">
							<div class="col-xs-12">
								<label for="makeOrderForm"><h2>Quantity</h2></label>
							</div>
							<div class="col-xs-8">
								<input type="number" name="quantity" class="form-control" id="quantityInput">
							</div>
							<div class="col-xs-4">
								<label for="makeOrderForm" id="unit">kg</label>
							</div>
						</div>
					</div>

					<div class="form-inline col-md-3 addRemoveFood">
						<button type="button" class="btn btn-default" onclick="addFood();"><span class="glyphicon glyphicon-plus-sign"></span></button>
						<button type="button" class="btn btn-default pull-right" id="removeFoodButton" onclick="removeFood();"><span class="glyphicon glyphicon-minus-sign"></span></button>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12" id="foodList">
						<table class="selectable-table orderTable" id="orderTable">
							<thead>
								<th><h4>Food</h4></th>
								<th><h4>Quantity</h4></th>
							</thead>
							<tbody id="orderTableBody">
								
							</tbody>
						</table>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12">
						<button type="submit" class="btn btn-default glyphicon glyphicon-ok" name="submitOrder" id="submitButton"></button>
					</div>
				</div>
			</div>
		</form>
	</div>
</section>