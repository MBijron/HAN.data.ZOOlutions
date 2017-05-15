<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="collapse navbar-collapse" id="defaultNavbar1">
			<ul class="nav navbar-nav navHeaderCollapse">'
				{foreach from=$menu_items key=menu_key item=menu_item}
					{if $menu_item|is_array}
						<li class="dropdown">
					        <a class="dropdown-toggle" data-toggle="dropdown" href="#">{$menu_key}
					        <span class="caret"></span></a>
					        <ul class="dropdown-menu">
								{foreach from=$menu_item key=submenu_key item=submenu_item}
									<li><a href="/{$submenu_key}">{$submenu_item}</a></li>
								{/foreach}
							</ul>
				      	</li>
					{else}
						<li><a href="/{$menu_item}">{$menu_key}</a></li>
					{/if}
				{/foreach}
			</ul>
		</div>
	</div>
</nav>