<?php
/* Smarty version 3.1.29, created on 2017-05-12 11:28:46
  from "C:\xampp\htdocs\app\views\notfound\index.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_59159c6eb476c5_72032694',
  'file_dependency' => 
  array (
    '5aa4deed6df60a9b354b079ac8f57748cb27618f' => 
    array (
      0 => 'C:\\xampp\\htdocs\\app\\views\\notfound\\index.tpl',
      1 => 1455812501,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59159c6eb476c5_72032694 ($_smarty_tpl) {
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
