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
			<div class="col-md-6">
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

					<button type="button" class="btn btn-default add-diet"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button>
					<button type="submit" class="btn btn-default submit pull-right remove-diet" data-redirect-url="/animals/removefood" data-table-ref="nutrition-table">
						<span class="glyphicon glyphicon-minus-sign" area-hidden="true"></span>
					</button>
				</div>
			</div>

			<div class="col-md-6">
				<div class="col-md-12">
					<h2>Veterinary record</h2>
				</div>

				<div class="col-md-12">
					<div class="animal-info-block">

					</div>
				</div>
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
							<input type="date" class="form-control" id="date" name="date" required>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="food">Select list:</label>
							<select class="form-control selectpicker" id="food" name="food" onchange="refreshUnit();" data-live-search="true" required>
								{foreach from=$food item=fooditem}
									<option value="{$fooditem->FOODID}">{$fooditem->FOODNAME}</option>
								{/foreach}
							</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="amount">Amount</label>
							<input type="numeric" class="form-control" id="amount" name="amount" required>
						</div>
					</div>
					<div class="col-md-2">
						<div class="col-md-12">
							<label for="amount" id="unitLabel">Unit</label>
						</div>
						<div class="col-md-12">
							<label id="unit">kg</label>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group pull-right">
							<button type="submit" for="submit" class="btn btn-default"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></label>
						</div>
					</div>
				</div>
				<input type="hidden" value="{$token}" name="token">
				<input type="hidden" value="{$animal->ANIMALID}" name="animalid">
			</form>
		</div>
    </div>
	<script>
		$('.add-diet').click(function () {
			$.fancybox([
				{ href : '#fancybox-popup-form' }
			]);
		});

		function refreshUnit() {
			var foodId = $("#food").val();

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

		var today = new Date().toISOString().split('T')[0];
		document.getElementsByName("date")[0].setAttribute('min', today);
	</script>
</section>