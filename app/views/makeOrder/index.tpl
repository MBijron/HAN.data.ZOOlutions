<!-- <link rel="stylesheet" type="text/css" href="../../../public/libraries/bootstrap-select-1.12.2/dist/css/bootstrap-select.css">
<script src="../../../public/libraries/bootstrap-select-1.12.2/dist/js/bootstrap-select.js"></script> -->

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

					<div class="form-group">
						<select class="selectpicker" data-live-search="true">
							{foreach from=$food item=$foodname}
								<option value="{$foodname->FOODNAME}">{$foodname->FOODNAME}</option>
							{/foreach}
						</select>
					</div>
				</div>
			</form>
		</div>
	</div>
</section>