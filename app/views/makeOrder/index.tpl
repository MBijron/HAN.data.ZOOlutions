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
    function refreshUnits() {
        var foodId = $("#foodSelector").val();

        $.ajax({
            url: "/makeOrder/refreshUnits",
            type: "POST",
            data: { foodid: foodId },
            dataType: "html",
            success: function(data) {
                document.getElementById("unitDiv").innerHTML = data;
            }
        });
    }

	function addFood() {
		if ($("#quantityInput").val() != "" && $("#quantityInput").val() > 0) {

			var selectedFood = $("#foodSelector option:selected").html();
			var quantity = $("#quantityInput").val();

			var compleetUnit = $("#unitSelector").val();
			var unit = compleetUnit.split(":")[0];
			var conversionFactor = compleetUnit.split(":")[1];

			var finalQuantity = quantity * conversionFactor;
			
			var index = 0;

			if (foodArray.length > 0) {
				for (fooditem in foodArray) {
					if (foodArray[fooditem][FOODNAME] == selectedFood) {
						foodArray[fooditem][FOODQUANTITY] = parseFloat(finalQuantity) + parseFloat(foodArray[fooditem][FOODQUANTITY]);
					} else {
						index++;
					} 

					if (index == foodArray.length) {
						foodArray.push([selectedFood, finalQuantity, $("#foodSelector").val(), "kg"]);
					}
				}
			} else {
				foodArray.push([selectedFood, finalQuantity, $("#foodSelector").val(), "kg"]);
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
			$("#noQuantityAlert").modal();
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

	    selectedRow = null;
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
	}

	function submitForm() {
		if (foodArray.length == 0) {
			$("#noFoodAdded").modal();
		} else {
		    $("#makeOrderForm").submit();
		}
	}

    window.onload = refreshUnits;

</script>

<section class="makeOrder">
	<div class="container">
		<form name="makeOrderForm" id="makeOrderForm" method="POST" action="/makeOrder/addFood">
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
						<select class="selectpicker" id="foodSelector" name="foodSelector" onchange="refreshUnits();" data-live-search="true">
							{foreach from=$food item=$foodname}
								<option value="{$foodname->FOODID}">{$foodname->FOODNAME}</option>
							{/foreach}
						</select>
					</div>
					
					<div class="col-md-7 col-md-offset-2">
						<div class="row">
							<div class="col-xs-12">
								<label for="makeOrderForm"><h2>Quantity</h2></label>
							</div>
							<div class="col-xs-8">
								<input type="number" name="quantity" class="form-control" id="quantityInput" min="1" step="any" max="999999">
							</div>
							<div class="col-xs-4" id="unitDiv">
								<select class="selectpicker" id="unitSelector">

								</select>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-12" id="foodList">
						<table class="selectable-table orderTable" id="orderTable">
							<thead>
								<th><h4><b>Food</b></h4></th>
								<th><h4><b>Quantity</b></h4></th>
								<th><h4><b>Unit</b></h4></th>
							</thead>
							<tbody id="orderTableBody">
								
							</tbody>
						</table>
					</div>
				</div>

				<div class="row addRemoveFood">
					<div class="col-md-3 col-xs-5">
						<button type="button" class="btn btn-default" onclick="addFood();"><span class="glyphicon glyphicon-plus-sign"></span></button>
						<button type="button" class="btn btn-default pull-right" onclick="removeFood();"><span class="glyphicon glyphicon-minus-sign"></span></button>
					</div>

					<div class="col-md-9 col-xs-7">
						<button type="button" class="btn btn-default glyphicon glyphicon-ok" name="submitOrder" id="submitButton" onclick="submitForm();"></button>
					</div>
				</div>
			</div>

			{generate_token}
		</form>

		<!-- Modal -->
		<div class="modal fade" id="noQuantityAlert" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Wrong information</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-warning">
							Please fill in the quantity and use a positive number.
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Oke</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="noFoodAdded" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Missing supplies</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-warning">
							There are no supplies added to the order.
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Oke</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>