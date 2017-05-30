<script type="text/javascript">
	var selectedRow;

	function checkOrder() {
		if (selectedRow == null) {
			$("#noSelectedRowAlert").modal();
		} else {
			window.location.href = '/ordersAtSuppliers/details/' + selectedRow + '?checkOrder=true';
		}
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
							<tr class="clickable-row" onclick="setSelectedRow(this);" data-redirect-url="/ordersAtSuppliers/details/{$order->ORDERID}?checkOrder=false">
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

		<!-- Modal -->
		<div class="modal fade" id="noSelectedRowAlert" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">No row selected</h4>
					</div>
					<div class="modal-body">
						<div class="alert alert-warning">
							Please select a row.
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Oke</button>
					</div>
				</div>
			</div>
		</div>
</section>