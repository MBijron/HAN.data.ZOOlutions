<section class="animals">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h1>{$orderrequest->ORDERREQUESTNAME}</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="col-md-12">
					<h2>Requested food</h2>
				</div>

				<div class="animal-info-block col-md-12">
					<table class="table">
						<thead>
							<th>Food</th>
							<th>Quantity</th>
						</thead>
						<tbody>
							{foreach from=$orderrequestrows item=row}
								<tr>
									<td>{$row->FOODNAME}</td>
									<td>{$row->AMOUNTREQUESTED} {$row->UNIT}</td>
								</tr>
							{/foreach}
						</tbody>
					</table>
				</div>
			</div>
				
			<div class="col-md-6">
				<div class="col-md-12">
					<h2>Information</h2>
				</div>

				<div class="animal-info-block col-md-12">
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