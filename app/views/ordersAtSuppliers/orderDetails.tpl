<section class="ordersAtSuppliers">
	<div class="container">
		<div class="row">
			<div class="col-md-7">
				<div class="col-md-12">
					<h2>Supplier information</h2>
				</div>

				<div class="col-md-12">
					<table class="table">
						<thead>
							<th>Suppliername</th>
							<th>Zipcode</th>
							<th>House number</th>
							<th>Tel number</th>
						</thead>
						<tbody>								
							{foreach from=$orderDetails item=order}
								<tr>
									<td>{$order->SUPPLIERNAME}</td>
									<td>{$order->ZIPCODE}</td>
									<td>{$order->HOUSENR}</td>
									<td>{$order->TELEPHONENR}</td>
								</tr>
							{/foreach}								
						</tbody>
					</table>
				</div>
			</div>
				
			<div class="col-md-5">
				<div class="col-md-12">
					<h2>Information</h2>
				</div>

				<div class="col-md-12">
					<table class="table">
						<thead>
							<th>Order date</th>
							<th>Delivery date</th>
							<th>Status</th>
						</thead>
						<tbody>								
							{foreach from=$orderDetails item=order}
								<tr>
									<td>{$order->ORDERDATE}</td>
									<td>{$order->DELIVERYDATE}</td>
									<td>{$order->STATUS}</td>
								</tr>
							{/foreach}								
						</tbody>
					</table>
				</div>
			</div>

			<div class="col-md-7">
				<div class="col-md-12">
					<h2>Ordered supplies</h2>
				</div>

				<div class="col-md-12">
					<table class="table">
						<thead>
							<th>Food</th>
							<th>Ordered</th>
							<th>Delivered</th>
						</thead>
						<tbody>						
							{foreach from=$orderRows item=$row}
								<tr>
									<td>{$row->FOODNAME}</td>
									<td>{$row->AMOUNTORDERED} {$row->UNIT}</td>
									<td>{$row->AMOUNTDELIVERED|floatval} {$row->UNIT}</td>
								</tr>
							{/foreach}
						</tbody>
					</table>
				</div>
			</div>

			{if $checkOrder == "true"}
				<div class="col-md-5">
					<div class="col-md-12">
						<h2>Delivered supplies</h2>
						<p>Fill in the amount of delivered supplies.</p>
					</div>

					<form action="/ordersAtSuppliers/checkOrder" method="post">

						{foreach from=$orderRows item=$orderitem}
							<div class="col-xs-12" id="deliveredFood">
								<div class="col-xs-4">
									<p>{$orderitem->FOODNAME}</p>									
									<input type="hidden" name="foodID[]" value="{$orderitem->FOODID}">
								</div>
								
								<div class="col-xs-5">
									<input type="number" class="form-control" name="quantity[]" id="quantity" placeholder="{$orderitem->AMOUNTDELIVERED|floatval}" required>
								</div>

								<div class="col-xs-3">
									<p>{$orderitem->UNIT}</p>
								</div>
							</div>
						{/foreach}

						<div class="col-xs-12" id="checkOrder">
							<button class="btn btn-default pull-right" type="submit">Check order</button>
						</div>

						<input type="hidden" name="orderID" value="{$orderitem->ORDERID}">

					</form>

				</div>
			{else}
				<div class="col-md-12">
					<div class="col-md-12">
						<form action="/ordersAtSuppliers/markAsReceived/{$orderDetails[0]->ORDERID}">
							<button type="submit" class="btn btn-default">Mark as Received</button>
						</form>
					</div>
				</div>
			{/if}

		</div>
	</div>
</section>