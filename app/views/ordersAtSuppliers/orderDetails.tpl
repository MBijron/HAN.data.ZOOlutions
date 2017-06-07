<script type="text/javascript">
	$('#confirm-delete').on('show.bs.modal', function(e) {
	    $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
	});
</script>

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
								{assign "markupstart" ""}
								{assign "markupend" ""}

								{if $order->STATUS == 'Incomplete delivery'}
									{assign "markupstart" "<p style='color:red;'>"}
									{assign "markupend" "</p>"}
								{/if}
								<tr>
									<td>{$order->ORDERDATE}</td>
									<td>{$order->DELIVERYDATE}</td>
									<td>{$markupstart} {$order->STATUS} {$markupend}</td>
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
							<th>Supplies</th>
							<th>Ordered</th>
							<th>Delivered</th>
							{if $order->STATUS != "Awaiting payment"} <th> Missing supplies </th> {/if}
						</thead>
						<tbody>						
							{foreach from=$orderRows item=$row}
								{assign "markupstart" ""}
								{assign "markupend" ""}
								{assign "missingSupplies" $row->AMOUNTORDERED - $row->AMOUNTDELIVERED}

								{if $row->AMOUNTDELIVERED < $row->AMOUNTORDERED AND $missingSupplies != 0}
									{assign "markupstart" "<p style='color:red;'>"}
									{assign "markupend" "</p>"}
								{/if}
								<tr>
									<td>{$row->FOODNAME}										</td>
									<td>{$row->AMOUNTORDERED|number_format:2} 	{$row->UNIT}	</td>
									<td>{$row->AMOUNTDELIVERED|number_format:2} {$row->UNIT}	</td>
									{if $order->STATUS != "Awaiting payment"} 
										<td> 
											{if $order->STATUS == "Incomplete delivery"}
												{$markupstart} 
											{/if} 
												{$missingSupplies|number_format:2} {$row->UNIT} {$markupend} </td>
									{/if}
								</tr>
							{/foreach}
						</tbody>
					</table>
				</div>
			</div>

			{if $order->STATUS == "Incomplete delivery"}
				<div class="col-md-5">
					<div class="col-xs-12">
						<h2>Process missing supplies</h2>
					</div>

					<form action="/ordersAtSuppliers/fixIncompleteDelivery/?orderID={$order->ORDERID}" method="post">
						<div class="col-xs-12">
							<p>Choose a new delivery date for the missing supplies:</p>
						</div>

						<div class="form-group col-xs-12 form-inline">
							<label>Delivery date</label>
							<input type="date" class="form-control" name="deliveryDate" value="{$smarty.now|date_format:'%Y-%m-%d'}" min="{$smarty.now|date_format:'%Y-%m-%d'}">
						</div>

						<div class="col-xs-12">
							<button type="submit" class="btn btn-default" name="updateOrder">
								<span class="glyphicon glyphicon-floppy-save"></span> Update the current order with a new delivery date
							</button>
						</div>

						<div class="col-xs-12">
							<button type="submit" class="btn btn-default" name="createNewOrder">
								<span class="glyphicon glyphicon-floppy-save"></span> Create a new orderrequest for the missing supplies
							</button>
						</div>

						<input type="hidden" name="supplierName" value="{$order->SUPPLIERNAME}">
					</form>
				</div>
			{/if}

			{if $order->STATUS == "Awaiting payment"}
				<div class="row">
					<div class="col-md-12">
						<div class="col-md-12">
							<button class="btn btn-default" data-toggle="modal" data-target="#confirm-delete">
							    Mark as Payed
							</button>
						</div>
					</div>
				</div>
			{/if}

				<!-- Modal -->
				<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				    <div class="modal-dialog">
				        <div class="modal-content">
				            <div class="modal-header">
				                Confirmation
				            </div>
				            <div class="modal-body">
				                Are you sure you want to mark this order as Payed?
				            </div>
				            <div class="modal-footer">
				                

				                <form action="/ordersAtSuppliers/markAsPayed/{$orderDetails[0]->ORDERID}" method="post">
				                <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
				                	<button class="btn btn-success btn-ok">Yes</button>
				                </form>
				            </div>
				        </div>
				    </div>
				</div>

			{if $checkOrder == "true"}
				<div class="col-md-5">
					<div class="col-md-12">
						<h2>Delivered supplies</h2>
						<p>Fill in the amount of delivered supplies.</p>
					</div>

					<form action="/ordersAtSuppliers/checkOrder" method="post" onkeypress="return event.keyCode != 13;">

						{foreach from=$orderRows item=$orderitem}
							<div class="col-xs-12" id="deliveredFood">
								<div class="col-xs-4">
									<p>{$orderitem->FOODNAME}</p>									
									<input type="hidden" name="foodID[]" value="{$orderitem->FOODID}">
								</div>
								
								<div class="col-xs-5">
									<input type="number" class="form-control" name="quantity[]" id="quantity" 
											placeholder="{$orderitem->AMOUNTORDERED - $orderitem->AMOUNTDELIVERED|floatval}" required>
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
			{else if $order->STATUS == "Awaiting delivery"}
				<div class="col-md-12">
					<div class="col-md-12">
						<form action="/ordersAtSuppliers/markAsReceived/{$orderDetails[0]->ORDERID}" method="post">
							<button type="submit" class="btn btn-default">Mark as Received</button>
						</form>
					</div>
				</div>
			{/if}

		</div>
	</div>
</section>