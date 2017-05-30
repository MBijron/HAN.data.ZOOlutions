<section class="animals">
	<div class="container">
		<div class="row">
		<h1>All animals of the {$area} area</h1>
			{foreach from=$animals item=$animal}
					<div class="animal-info-block">
						<div class="col-sm-3 animal-info-image hidden-sm hidden-xs">
							<img src="/public/img/placeholder.png" alt="preview" class="img-responsive">
						</div>
						<div class="col-sm-9">
							<div class="animal-info-text">
								<table class="table">
									<tbody>
										<tr>
											<td>Animal name</td>
											<td>{$animal->ANIMALNAME}</td>
										</tr>
										<tr>
											<td>Gender</td>
											<td>{$animal->GENDER}</td>
										</tr>
										<tr>
											<td>Species</td>
											<td>{$animal->SPECIESEN}</td>
										</tr>
										<tr>
											<td>Birth date</td>
											<td>{$animal->BIRTHDATE}</td>
										</tr>
										<tr>
											<td>Area</td>
											<td>{$animal->AREANAME}</td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="pull-right">
							<a href="/animals/details/{$animal->ANIMALID}"><button type="button" class="btn btn-primary">Details</button></a>
							</div>
						</div>
					</div>
			{/foreach}
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