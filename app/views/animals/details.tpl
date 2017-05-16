<section class="animals">
	<div class="container">
		<div class="row">
			<h1>Details of {$animal->ANIMALNAME}</h1>
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
		<div class="row">
			<div class="col-md-6">
				<div class="row">
					<h2>Feeding information</h2>
					<div class="animal-info-block">
						<div class="animal-info-text">
							<table class="table" id="nutrition-table">
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
											<td>{$markupstart}{$dietitem->AMOUNT} {$dietitem->UNIT}{$markupend}</td>
										</tr>
									{/foreach}
							</table>
						</div>
					</div>
					<a href="#"><i class="fa fa-plus-square-o icon-button add-diet" aria-hidden="true"></i></a>
					<a href="#"><i class="fa fa-minus-square-o pull-right icon-button remove-diet" aria-hidden="true"></i></a>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row">
					<h2>Veterinary record</h2>
					<div class="animal-info-block">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="fancybox-popup-form">
		<h2>Add an item to the diet of {$animal->ANIMALNAME}</h2>
        <div class="container">
			<form action="/animals/addfood" method="post">
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
							<select class="form-control selectpicker" id="food" name="food"  data-live-search="true" required>
								{foreach from=$food item=fooditem}
									<option>{$fooditem->FOODNAME}</option>
								{/foreach}
							</select>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="amount">Amount</label>
							<input type="numeric" class="form-control" id="amount" name="amount" required>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group pull-right">
							<label for="submit" class="btn"><i class="fa fa-plus-square-o icon-button fancybox" aria-hidden="true"></i></label>
							<input id="submit" type="submit" value="Go" class="hidden" />
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
		$('#nutrition-table').on('click', '.clickable-row', function(event) {
			$(this).addClass('active').siblings().removeClass('active');
		});
		$('.remove-diet').click(function() {
			if($('#nutrition-table .active').html() == null)
			{
				alert('Please select a diet item');
			}
			else
			{
				$.redirect("/animals/removefood", { date: $($('#nutrition-table .active').children()[0]).text(), food: $($('#nutrition-table .active').children()[1]).text(), quantity: parseInt($($('#nutrition-table .active').children()[2]).text()), animalid: '{$animal->ANIMALID}', token: '{$token}'})
			}
		});
		
	</script>
</section>