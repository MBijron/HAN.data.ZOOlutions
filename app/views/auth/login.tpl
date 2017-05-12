<section id="main-article">
	<div class="container">
		<div class="row content-bar">
			<div class="col-md-4 col-md-push-4">
				{if $logged_in == true}
					<p>You allready are logged in.</p>
				{else}
					<div class="form">
						<form action="{$url_root}login/start" method="post">
							<p>Geeft u uw inlog gegevens</p><br />
							<input class="form-control" id="username" type="text" name="username" placeholder="username" required autofocus/><br />
							<input class="form-control" id="password" type="password" name="password" placeholder="password" required /><br />
							<input type="hidden" name="token" value="{$token}" />
							{if $error == true}
								<div class="alert alert-danger" role="alert">
									<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
									<span class="sr-only">Error:</span>
									Username or password did not match
								</div>
							{/if}
							<input class="form-control btn btn-primary" id="submit" type="submit" value="submit" />
						</form>
					</div>
				{/if}
			</div>
		</div>
	</div>
</section>