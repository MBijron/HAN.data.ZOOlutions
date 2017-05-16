<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="../../../public/libraries/bootstrap-select-1.12.2/dist/js/bootstrap-select.js"></script>

<section class="makeOrder">
	<div class="container">
		<div class="row">
			<form name="makeOrderForm" method="POST" action="/makeOrder">
				<div class="form-inline">
					<label for="makeOrderForm"><h2>Order name</h2></label>
					<input type="text" class="form-control" placeholder="Order name">
				</div>

				<div class="form-inline">
					<label for="makeOrderForm"><h2>Area</h2></label>
					<select class="selectpicker">
						{foreach from=$areas item=$area}
							<option value="{$area->AREANAME}">{$area->AREANAME}</option>
						{/foreach}
					</select>
				</div>

				<div class="form-inline">
					<label for="makeOrderForm"><h2>Food</h2></label>
					<select class="selectpicker" data-live-search="true">
						<option>Hot Dog, Fries and a Soda</option>
					</select>
				</div>
			</form>
		</div>
	</div>
</section>