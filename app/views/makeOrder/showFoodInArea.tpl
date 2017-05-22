<div class="row">
	<div class="col-md-12">
		<label><h2>Current stock in area</h2></label>
	</div>
</div>

<div class="row" id="foodInArea">
	<div class="col-md-6 col-sm-6 col-xs-6">
		<h4><b>Name</b></h4>
		{foreach from=$foodInArea item=$fooditem}
			<p>{$fooditem->FOODNAME}</p>
		{/foreach}
	</div>

	<div class="col-md-3 col-sm-3 col-xs-3">
		<h4><b>Amount</b></h4>
		{foreach from=$foodInArea item=$fooditem}
			<p>{$fooditem->AMOUNT}</p>
		{/foreach}
	</div>

	<div class="col-md-3 col-sm-3 col-xs-3">
		<h4><b>Unit</b></h4>
		{foreach from=$foodInArea item=$fooditem}
			<p>{$fooditem->UNIT}</p>
		{/foreach}
	</div>
</div>