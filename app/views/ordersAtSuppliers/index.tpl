<script type="text/javascript">
	var selectedRow = 0;

	function checkOrder() {
		window.location.href = '/ordersAtSuppliers/details/' + selectedRow + '?checkOrder=true';
	}

	function setSelectedRow(row) {
		selectedRow = row.rowIndex;
	}
</script>

<section class="ordersAtSuppliers">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>All orders</h1>
			</div>
			<div class="selectable-table col-md-12">
				<table class="table selectable-table" id="order-table" data-extra-fields="token: biep">
					<thead>
						<th>Supplier</th>
						<th>Delivery date</th>
						<th>Status</th>
					</thead>
					<tbody>
						{foreach from=$orders item=order}
							<tr class="clickable-row" onclick="setSelectedRow(this);" data-redirect-url="/ordersAtSuppliers/details/{$order->ORDERID}">
								<td>{$order->SUPPLIERNAME}</td>
								<td>{$order->DELIVERYDATE}</td>
								<td>{$order->STATUS}</td>
							</tr>
						{/foreach}
					</tbody>
				</table>

				<button class="btn btn-default" onclick="checkOrder();">Check order</button>
				<button class="submit float-right btn btn-default" data-table-ref="order-table">Details</button>
			</div>
		</div>
	</div>
</section>