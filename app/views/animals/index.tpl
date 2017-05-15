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
							<button type="button" class="btn btn-primary">Nutrition management</button>
							</div>
						</div>
					</div>
			{/foreach}
		</div>
	</div>
</section>