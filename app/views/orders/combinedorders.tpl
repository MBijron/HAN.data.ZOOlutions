<section class="animals">
	<div class="container">
		<div class="row">
			<h1>Create supplier order</h1>
			<div class="col-md-8">	
				<h2>Order</h2>
				<div class="animal-info-block">
					<div class="animal-info-text">
						<form method="post" onkeypress="return event.keyCode != 13;">
							<table class="table">
								<thead>
									<th>Food</th>
									<th>Quantity</th>
									<th>Supplier</th>
									<th>Delivery date</th>
								</thead>
								<tbody>
									{foreach from=$orderrequests item=orderitem}
										{assign "sanitizedName" $orderitem->FOODNAME|replace:'\'':''|replace:' ':''}
										<tr class="{$sanitizedName}">
											<td>{$orderitem->FOODNAME}</td>
											<td class="{$sanitizedName}_MAX_AMOUNT">{$orderitem->TOTALAMOUNT} {$orderitem->UNIT}</td>
										</tr>
										<tr class="{$sanitizedName}">
											<td><input type="hidden" value="{$orderitem->FOODNAME}" name="{$sanitizedName}_Foodname_1"></td>
											<td><input type="number" value="" name="{$sanitizedName}_Quantity_1" min="0.0" max="{$orderitem->TOTALAMOUNT}" step="any" 
														class="{$sanitizedName}_Quantity form-control" onchange="updateCounter(this)"></td>
											<td>
												<select name="{$sanitizedName}_Supplier_1" class="form-control" required>
													{foreach from=$suppliers item=supplier}
														<option>{$supplier->SUPPLIERNAME}</option>
													{/foreach}
												</select>
											</td>
											<td><input type="date" class="form-control" value="{$orderdate}" min="{$smarty.now|date_format:'%Y-%m-%d'}" name="{$sanitizedName}_Date_1" data-provide="datepicker" required></td>
										</tr class="{$sanitizedName}">
										<tr class="{$sanitizedName}">
											<td></td>
											<td>Total: <span class="{$sanitizedName}_ORDER_COUNTER">0</span></td>
										</tr>
										<tr class="{$sanitizedName}">
											<td></td>
											<td>
												<button type="button" class="btn btn-default add-button">
													<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
												</button>
												<button type="button" class="btn btn-default remove-button">
													<span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span>
												</button>
											</td>
										</tr>
									{/foreach}
								</tbody>
							</table>
							<button type="submit" class="btn btn-default"><span class="glyphicon glyphicon-saved"></span> Save orders</button>
						</form>
					</div>
				</div>
			</div>

			<script>
				$('.add-button').click(function() {
					//get the class of the item you want to add (the food name)
					var rowClass = $($(this).parent().parent().prev().prev()).attr('class');
					//get the form to duplicate
					var form = '<tr class="'+rowClass+'">' + $($(this).parent().parent().prev().prev()).html() + '</tr>';
					//get the amount of input fiels allready present to determain the new class names
					var childrenCount = $(this).parent().parent().parent().children('.'+rowClass).length - 3;
					//add one to all classnames
					var 
					form = form.replace(rowClass+'_Supplier_'+childrenCount, rowClass+'_Supplier_'+(childrenCount + 1)).replace(rowClass+'_Date_'+childrenCount, rowClass+'_Date_'+(childrenCount + 1)).replace(rowClass+'_Quantity_'+childrenCount, rowClass+'_Quantity_'+(childrenCount + 1)).replace(rowClass+'_Foodname_'+childrenCount, rowClass+'_Foodname_'+(childrenCount + 1));
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
				});
				function updateCounter(selector)
				{
					var total = new Big(0);
					var rowClass = $($(selector).parent().parent()).attr('class');
					var maxAmount = new Big(parseFloat($($(selector).parent().parent().parent().find('.' + rowClass + '_MAX_AMOUNT')).text()));
					var currentAmount = new Big(parseFloat($(selector).val()));
					$(selector).parent().parent().parent().children('.' + rowClass).each(function(index, item){
						var input = $(item).find('.' + rowClass + '_Quantity');
						if(input.length)
						{
							if(input.val() != '')
							{
								total = total.plus(parseFloat(input.val()));
							}
						}
					});
					if(total.gt(maxAmount))
					{
						//currentAmount = currentAmount.minus(total).minus(maxAmount).times(-1);
						currentAmount = total.minus(maxAmount).minus(currentAmount).times(-1);
						console.log ('total: ' + total.toString() + '| maxAmount: ' + maxAmount.toString() + '| currentAmount: ' + currentAmount.toString());
						$(selector).val(currentAmount.toString())
						$($(selector).parent().parent().parent().find('.' + rowClass + '_ORDER_COUNTER')).html(maxAmount.toString());
					}
					else if(total.lt(0))
					{
						$(selector).val(0)
					}
					else
					{
						$($(selector).parent().parent().parent().find('.' + rowClass + '_ORDER_COUNTER')).html(total.toString());
					}
				}
			</script>

			<div class="col-md-4">
				<h2>Suppliers</h2>
				<div class="animal-info-block">
					<div class="animal-info-text">
						<table class="table table-responsive">
							<thead>
								<th>Supplier</th>
								<th>Number</th>
							</thead>
							<tbody>
								{foreach from=$suppliers item=supplier}
									<tr>
										<td>{$supplier->SUPPLIERNAME}</td>
										<td>{$supplier->TELEPHONENR}</td>
									</tr>
								{/foreach}
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>