<?php
/* Smarty version 3.1.29, created on 2016-05-08 18:39:42
  from "/var/www/html/app/views/notfound/index.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_572f87eef3fbe5_90734695',
  'file_dependency' => 
  array (
    '648ccc5e524f4b36b972b60a15657de3b6a40dc4' => 
    array (
      0 => '/var/www/html/app/views/notfound/index.tpl',
      1 => 1455812501,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_572f87eef3fbe5_90734695 ($_smarty_tpl) {
echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['send_not_found'][0][0]->smarty_send_not_found(array(),$_smarty_tpl);?>

<section id="notfound">
	<div class="container">
		<div class="row text-center">
			<h1 id="notfound-text">404 Page not found</h1>
		</div>
		<div class="row text-center">
			<img src="/public/img/404_wizard.png" style="height: 407px; width: 347px" class="loader"/>
			<h3>The page you are looking for doesn't exist or is under construction</h3>
		</div>
	</div>
</section><?php }
}
