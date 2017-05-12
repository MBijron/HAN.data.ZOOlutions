<?php
/* Smarty version 3.1.29, created on 2016-05-08 18:08:59
  from "C:\Users\maurice\Dropbox\Apps\Launcy\Resources\USBWebserver v8.6\root\app\views\notfound\index.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_572f80bbbdeb02_30124532',
  'file_dependency' => 
  array (
    '058d3e705ce4de0da52cb8f3515715383ce8dac9' => 
    array (
      0 => 'C:\\Users\\maurice\\Dropbox\\Apps\\Launcy\\Resources\\USBWebserver v8.6\\root\\app\\views\\notfound\\index.tpl',
      1 => 1455812501,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_572f80bbbdeb02_30124532 ($_smarty_tpl) {
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
