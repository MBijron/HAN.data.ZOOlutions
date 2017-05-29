<section class="ordersAtSuppliers">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>All orders</h1>
			</div>
			<div class="selectable-table col-md-12">
				<table class="table selectable-table" id="order-table">
					<thead>
						<th>Order name</th>
						<th>Date</th>
						<th>Status</th>
					</thead>
					<tbody>
						{foreach from=$orderrequests item=orderrequest}
							<tr class="clickable-row"  data-redirect-url="/ordersList/details/{$orderrequest->ORDERREQUESTID}">
								<td>{$orderrequest->ORDERREQUESTNAME}</td>
								<td>{$orderrequest->ORDERREQUESTDATE}</td>
								<td>{if $orderrequest->ORDERREQUESTSTATUS == 0}
										Order not placed
									{else}
										Order placed
									{/if}
								</td>
							</tr>
						{/foreach}
					</tbody>
				</table>
				<a href="/ordersList/combined"><button class="btn btn-default">Combine orders</button></a>
				<button class="submit float-right btn btn-default" data-table-ref="orderrequest-table">Details</button>
			</div>
		</div>
	</div>
</section>