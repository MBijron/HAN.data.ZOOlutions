<section class="animals">
	<div class="container">
		<div class="row">
			<h1>{$orderrequest->ORDERREQUESTNAME}</h1>
			<div class="col-md-6">
				<h2>Requested food</h2>
				<div  class="animal-info-block">
					<table class="table">
						<thead>
							<th>Food</th>
							<th>Quantity</th>
						</thead>
						<tbody>
							{foreach from=$orderrequestrows item=row}
								<tr>
									<td>{$row->FOODNAME}</td>
									<td>{$row->AMOUNT} {$row->UNIT}</td>
								</tr>
							{/foreach}
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-md-6">
				<h2>Information</h2>
				<div class="animal-info-block">
					<div class="animal-info-text">
						<table class="table">
							<thead>
								<th>Date</th>
								<th>Ordered By</th>
							</thead>
							<tbody>
								<tr>
									<td>{$orderrequest->ORDERREQUESTDATE}</td>
									<td>{$orderrequest->FIRSTNAME} {$orderrequest->LASTNAME}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>