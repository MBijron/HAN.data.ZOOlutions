<section class="animals">
	<div class="container">
		<div class="row">
			<h1>Create supplier order</h1>
			<div class="col-md-8">	
				<h2>Order</h2>
				<div class="animal-info-block">
					<div class="animal-info-text">
						<table class="table">
							<thead>
								<th>Food</th>
								<th>Quantity</th>
								<th>Supplier</th>
								<th>Delivery date</th>
							</thead>
							<tbody>
								{foreach from=$orderrequests item=orderitem}
									<tr class="{$orderitem->FOODNAME|replace:'\'':''}">
										<td>{$orderitem->FOODNAME}</td>
										<td>{$orderitem->TOTALAMOUNT} {$orderitem->UNIT}</td>
									</tr>
									<tr class="{$orderitem->FOODNAME|replace:'\'':''}">
										<td></td>
										<td><input type="number" value="" name="{$orderitem->FOODNAME|replace:'\'':''}_Quantity_1" required></td>
										<td>
											<select name="{$orderitem->FOODNAME|replace:'\'':''}_Supplier_1" required>
												{foreach from=$suppliers item=supplier}
													<option>{$supplier->SUPPLIERNAME}</option>
												{/foreach}
											</select>
										</td>
										<td><input type="date" value="" name="{$orderitem->FOODNAME|replace:'\'':''}_Date_1" required></td>
									</tr class="{$orderitem->FOODNAME|replace:'\'':''}">
									<tr class="{$orderitem->FOODNAME|replace:'\'':''}">
										<td></td>
										<td>Total: <span class="order-counter">0</span></td>
									</tr>
									<tr class="{$orderitem->FOODNAME|replace:'\'':''}">
										<td></td>
										<td><i class="fa fa-plus-square-o add-button" aria-hidden="true"></i></td>
									</tr>
								{/foreach}
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<script>
				$('.add-button').click(function() {
					var rowClass = $($(this).parent().parent().prev().prev()).attr('class');
					var form = '<tr class="'+rowClass+'">' + $($(this).parent().parent().prev().prev()).html() + '</tr>';
					var childrenCount = $(this).parent().parent().parent().children('.'+rowClass).length - 3;
					form = form.replace(rowClass+'_Supplier_'+childrenCount, rowClass+'_Supplier_'+(childrenCount + 1)).replace(rowClass+'_Date_'+childrenCount, rowClass+'_Date_'+(childrenCount + 1)).replace(rowClass+'_Quantity_'+childrenCount, rowClass+'_Quantity_'+(childrenCount + 1));
					console.log(rowClass);
					
					$($(this).parent().parent().prev().prev()).after(form);
				});
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