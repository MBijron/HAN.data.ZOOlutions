<section class="animals">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>Details of {$animal->ANIMALNAME}</h1>
			</div>

			<div class="col-md-12">
				<div class="animal-info-block">
					<div class="col-sm-3 animal-info-image hidden-sm hidden-xs">
						<img src="/public/img/placeholder.png" alt="preview" class="img-responsive">
					</div>
					<div class="col-sm-9">
						<div class="animal-info-text">
							<table class="table">
								<tbody>
									<tr>
										<td>Animal name</td>
										<td>{$animal->ANIMALNAME}</td>
									</tr>
									<tr>
										<td>Animal ID</td>
										<td>{$animal->ANIMALID}</td>
									</tr>
									<tr>
										<td>Gender</td>
										<td>{$animal->GENDER}</td>
									</tr>
									<tr>
										<td>Species</td>
										<td>{$animal->SPECIESEN}</td>
									</tr>
									<tr>
										<td>Birth date</td>
										<td>{$animal->BIRTHDATE}</td>
									</tr>
									<tr>
										<td>Area</td>
										<td>{$animal->AREANAME}</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<h2>Feeding information</h2>
			</div>

			<div class="col-md-12">
				<div class="animal-info-block">
					<div class="animal-info-text">
						<div class="selectable-table">
							<table class="table selectable-table" id="nutrition-table" data-extra-fields="token: {$token}, animalid: {$animal->ANIMALID}">
								<thead>
									<th>From</th>
									<th>Food</th>
									<th>Quantity</th>
								</thead>
								<tbody>
									{foreach from=$nutrition item=dietitem}
									{assign "markupstart" ""}
									{assign "markupend" ""}
									{if $dietitem->currentDiet == 1}
										{assign "markupstart" "<b>"}
										{assign "markupend" "</b>"}
									{/if}
										<tr class="clickable-row">
											<td>{$markupstart}{$dietitem->DIETSTART}{$markupend}</td>
											<td>{$markupstart}{$dietitem->FOODNAME}{$markupend}</td>
											<td>{$markupstart}{$dietitem->AMOUNT} {$dietitem->UNIT}/d{$markupend}</td>
										</tr>
									{/foreach}
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<button type="button" class="btn btn-default add-diet" ><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button>
				<button type="submit" class="btn btn-default submit remove-diet" data-redirect-url="/animals/removefood" data-table-ref="nutrition-table">
					<span class="glyphicon glyphicon-minus-sign" area-hidden="true"></span>
				</button>
			</div>

			<div class="col-md-12">
				<h2>Veterinary record</h2>
			</div>

			<div class="col-md-12">
				<div class="animal-info-block">
					<div class="animal-info-text">
						<div class="selectable-table">
							<table class="table selectable-table" id="veterinary-table" 
									data-extra-fields="token: {$token}, animalid: {$animal->ANIMALID}">
								<thead>
									<th>Date</th>
									<th>Vet</th>
									<th>Diagnosis</th>
									<th>Prescription</th>
									<th>Period</th>
									<th>Notes</th>
								</thead>
								<tbody>
									{foreach from=$veterinary item=veterinaryrecord}
										{assign "markup" ""}
										{if $veterinaryrecord->ENDPRESCRIPTION != null}
											{assign "markup" ":"}
										{/if}
										<tr class="clickable-row" onclick="updateRecordId(this);" 
											value="{$veterinaryrecord->VETERINARYRECORDID}:{$animal->ANIMALID}:{$veterinaryrecord->PRESCRIPTIONID}">
											<td>{$veterinaryrecord->RECORDDATE}</td>
											<td>{$veterinaryrecord->FIRSTNAME} {$veterinaryrecord->LASTNAME}</td>
											<td>{$veterinaryrecord->DIAGNOSIS}</td>
											<td>{$veterinaryrecord->MEDICINENAME}</td>
											<td>{$veterinaryrecord->STARTPRESCRIPTION} {$markup} {$veterinaryrecord->ENDPRESCRIPTION}</td>
											<td>{$veterinaryrecord->NOTES}</td>
										</tr>
									{/foreach}
								</tbody>
							</table>
						</div>
					</div>
				</div>
				
				<button type="button" class="btn btn-default add-veterinary"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button>
				<button type="submit" class="btn btn-default submit remove-veterinary" onclick="removeVeterinaryRecords();" data-table-ref="veterinary-table">
					<span class="glyphicon glyphicon-minus-sign" area-hidden="true"></span>
				</button>
			</div>
		</div>
	</div>

	<div id="fancybox-popup-form">
		<h2>Add an item to the diet of {$animal->ANIMALNAME}</h2>
        <div class="container">
			<form action="/animals/addfood" method="post" name="submit">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="date">Date</label>
							<input type="date" class="form-control" id="date" name="date" value="{$smarty.now|date_format:'%Y-%m-%d'}" min="{$smarty.now|date_format:'%Y-%m-%d'}" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="food">Select food:</label>
							<select class="form-control selectpicker" id="food" name="food" onchange="refreshUnits();" data-live-search="true" required>
								{foreach from=$food item=fooditem}
									<option value="{$fooditem->FOODID}">{$fooditem->FOODNAME}</option>
								{/foreach}
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="amount">Amount</label>
							<input type="number" class="form-control" id="amount" name="amount" min="0.01" max="9999" step="0.01" required>
						</div>
					</div>
					<div class="col-md-2">
						<label for="amount" id="unitLabel">Unit</label>
						<select class="form-control" id="unitSelector" name="unit">
							{foreach from=$units item=$unit}
								<option value="{$unit->UNIT}">{$unit->UNIT}</option>
							{/foreach}
						</select>
					</div>
					<div class="col-md-12">
						<div class="form-group pull-right">
							<button type="submit" for="submit" class="btn btn-default"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span></button>
						</div>
					</div>
				</div>
				<input type="hidden" value="{$token}" name="token">
				<input type="hidden" value="{$animal->ANIMALID}" name="animalid">
			</form>
		</div>
	</div>
	
	<div id="fancybox-popup-form2" style="display: none;">
		<h2>Add an item to the veterinaryrecords of {$animal->ANIMALNAME}</h2>
        <div class="container">
			<form action="/animals/addveterinary" method="post" name="submit" id="veterinaryRecordForm">
				<div class="row">
					<div class="col-md-3">
						<div class="form-group">
							<label for="diagnosis">Select diagnosis:</label>
							<select class="form-control selectpicker" id="diagnosis" name="diagnosis" data-live-search="true" required>
								<option value="0"></option>
								{foreach from=$diagnosis item=diagnosisitem}
									<option value="{$diagnosisitem->DIAGNOSISID}">{$diagnosisitem->DIAGNOSIS}</option>
								{/foreach}
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label for="medicine">Select medicine:</label>
							<select class="form-control selectpicker" id="medicine" name="medicine" data-live-search="true" required>
								<option value="0"></option>
								{foreach from=$medicine item=medicineitem}
									<option value="{$medicineitem->MEDICINEID}">{$medicineitem->MEDICINENAME}</option>
								{/foreach}
							</select>
						</div>
					</div>
					
					<div class="col-md-3">
						<div class="col-md-12">
							<div class="form-group">
								<label for="date">Startdate</label>
								<input type="date" class="form-control" id="startdate" name="startdate" value="{$smarty.now|date_format:'%Y-%m-%d'}" min="{$smarty.now|date_format:'%Y-%m-%d'}">
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="col-md-12">
							<div class="form-group">
								<label for="date">Enddate</label>
								<input type="date" class="form-control" id="enddate" name="enddate" value="{$smarty.now|date_format:'%Y-%m-%d'}" min="{$smarty.now|date_format:'%Y-%m-%d'}">
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
					</div>
					<div class="col-md-5 selectable-table" id="medicineArray">
						
					</div>
				</div>

				<div class="row">
					<div class="col-md-3">
					</div>
					<div class="col-md-3">
						<td>
							<button type="button" class="btn btn-default" onclick="addMedicine();">
								<i class="glyphicon glyphicon-plus-sign add-button" aria-hidden="true"></i>
							</button> 
							<button type="button" class="btn btn-default pull-right" onclick="removeMedicine();">
								<i class="glyphicon glyphicon-minus-sign remove-button" aria-hidden="true"></i>
							</button>
						</td>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<label for="notes">Notes</label>
						<input type="text" class="form-control" id="notes" name="notes" maxlength="256">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group pull-right" style="padding-top: 10px">
							<button type="submit" for="submit" class="btn btn-default"><span class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span></button>
						</div>
					</div>
				</div>
				<input type="hidden" value="{$token}" name="token">
				<input type="hidden" value="{$animal->ANIMALID}" name="animalid">

				<!-- Modal -->
				<div class="modal fade" id="wrongDateValue" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">No start or enddate</h4>
							</div>
							<div class="modal-body">
								<div class="alert alert-warning">
									Please select a startdate.
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Oke</button>
							</div>
						</div>
					</div>
				</div>

				<!-- Modal -->
				<div class="modal fade" id="noMedicineRowSelected" role="dialog">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">No selection</h4>
							</div>
							<div class="modal-body">
								<div class="alert alert-warning">
									Please select a row.
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Oke</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="noMedicineAlert" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">No selection</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-warning">
							Please select a medicine.
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Oke</button>
					</div>
				</div>
			</div>
		</div>
    </div>
	
		
		
	<script>
		var medicines = new Array();
		var selectedRow;
		var veterinaryrecordID;

		function updateRecordId(row) {
			veterinaryrecordID = row.getAttribute('value');
		}

		function removeVeterinaryRecords() {
			sp = veterinaryrecordID.split(":");
			veterinaryrecordID = sp[0];
			animalId = sp[1];
			prescriptionId = sp[2];

			if (veterinaryrecordID != null) {
				$.redirect('/animals/removeveterinary/' + veterinaryrecordID + ":" + animalId + ":" + prescriptionId);
			}
		}

		$('#veterinaryRecordForm').submit(function() {
			if ($("#startdate").val() == '') {
		    	$("#wrongDateValue").modal();
			    return false;
		    } else {
			    return true;
			}
		});

		function addMedicine() {
			if ($("#medicine option:selected").html() != "") {

				var startdate = $("#startdate").val();
				var enddate = $("#enddate").val();

				medicines.push( [ $("#medicine option:selected").val(), $("#medicine option:selected").html(), startdate, enddate ] );

				$.ajax({
			        url: "/app/views/animals/addMedicine.php",
			        type: "POST",
			        dataType:"html",
		    		data: { medicinearray: medicines },
			        success: function(data) {
				        document.getElementById("medicineArray").innerHTML = data;
				        $.fancybox.update();
				    }
			    });
			} else {
				$("#noMedicineAlert").modal();
			}
		}

		function removeMedicine() {
			removeItem(medicines, selectedRow - 1);

			if (selectedRow != null) {
				if (medicines.length > 0) {
					$.ajax({
				        url: "/app/views/animals/addMedicine.php",
				        type: "POST",
				        dataType:"html",
			    		data: { medicinearray: medicines },
				        success: function(data) {
					        document.getElementById("medicineArray").innerHTML = data;
					        $.fancybox.update();
					    }
				    });
			    } else {
			    	document.getElementById("medicineArray").innerHTML = [''];
			    }
			} else {
				$("#noMedicineRowSelected").modal();
			}

		    selectedRow = null;
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

		function setSelectedRow(row) {
			selectedRow = row.rowIndex;
		}
	
		$('.add-diet').click(function () {
			$.fancybox([
				{ href : '#fancybox-popup-form' }
			]);
		});
		
		$('.add-veterinary').click(function () {
			$.fancybox([
				{ href : '#fancybox-popup-form2' }
			]);
		});
		
		function refreshUnits() {
        var foodId = $("#food").val();

        $.ajax({
            url: "/makeOrder/refreshUnitsNoConversion",
            type: "POST",
            data: { foodid: foodId },
            dataType: "html",
            success: function(data) {
                document.getElementById("unitSelector").innerHTML = data;
            }
        });
    }
	
	window.onload = refreshUnits;

		/*
		$('.add-button').click(function() {
			//get the class of the item you want to add (the food name)
			var rowClass = $($(this).parent().parent().prev().prev()).attr('class');
			//get the form to duplicate
			var form = '<tr class="'+rowClass+'">' + $($(this).parent().parent().prev().prev()).html() + '</tr>';
			//get the amount of input fiels allready present to determain the new class names
			var childrenCount = $(this).parent().parent().parent().children('.'+rowClass).length - 3;
			//add one to all classnames
			var 
			form = form.replace(rowClass+'_Medicine_'+childrenCount, rowClass+'_Medicine_'+(childrenCount + 1)).replace(rowClass+'_Startdate_'+childrenCount, rowClass+'_Startdate_'+(childrenCount + 1)).replace(rowClass+'_Enddate_'+childrenCount, rowClass+'Enddate'+(childrenCount + 1)));
			//add the new form
			$($(this).parent().parent().prev().prev()).after(form);
		});
		$('.remove-button').click(function() {
			var rowClass = $($(this).parent().parent().prev().prev()).attr('class');
			var childrenCount = $(this).parent().parent().parent().children('.'+rowClass).length - 3;
			if(childrenCount > 1)
			{
				$(this).parent().parent().prev().prev().remove();
			}
		});*/
	</script>
</section>