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

			<div class="col-md-6">
				<div class="col-md-12">
					<h2>Ordered supplies</h2>
				</div>

				<div class="col-md-12">
					<table class="table">
						<thead>
							<th>Food</th>
							<th>Quantity</th>
						</thead>
						<tbody>						
							{foreach from=$orderRows item=$row}
								<tr>
									<td>{$row->FOODNAME}</td>
									<td>{$row->AMOUNTORDERED} {$row->UNIT}</td>
								</tr>
							{/foreach}
						</tbody>
					</table>
				</div>
			</div>

			{if $checkOrder == "true"}
				<div class="col-md-6">
					<div class="col-md-12">
						<h2>Delivered supplies</h2>
					</div>

					<form action="/ordersAtSuppliers/checkOrder" method="post">

						{foreach from=$orderRows item=$orderitem}
							<div class="col-md-12" id="deliveredFood">
								<div class="col-md-4">
									<p>{$orderitem->FOODNAME}</p>
								</div>
								
								<div class="col-md-4">
									<input type="text" class="form-control" name="quantity">
								</div>

								<div class="col-md-4">
									<p>{$orderitem->UNIT}</p>
								</div>
							</div>
						{/foreach}

					</form>

					<div class="col-md-12">
						<button class="btn btn-default pull-right">Check order</button>
					</div>

				</div>
			{/if}

		</div>
	</div>
</section>