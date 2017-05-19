<section class="animals">
	<div class="container">
		<div class="row">
		<h1>All order requests</h1>
			<div class="selectable-table">
				<table class="table selectable-table" id="orderrequest-table" data-extra-fields="token: biep, test: boep">
					<thead>
						<th>Order name</th>
						<th>Date</th>
						<th>Status</th>
					</thead>
					<tbody>
						{foreach from=$orderrequests item=orderrequest}
							<tr class="clickable-row">
								<td>{$orderrequest->ORDERREQUESTNAME}</td>
								<td>{$orderrequest->ORDERREQUESTDATE}</td>
								<td>{$orderrequest->ORDERREQUESTSTATUS}</td>
							</tr>
						{/foreach}
				</table>
				<button class="submit" data-redirect-url="/ordersList/test" data-table-ref="orderrequest-table">Combine orders</button>
			</div>
		</div>
	</div>
</section>