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
					<select class="selectpicker form-control">
						{foreach from=$areas item=$area}
							<option value="{$area->AREANAME}">{$area->AREANAME}</option>
						{/foreach}
					</select>
				</div>
			</form>
		</div>
	</div>
</section>