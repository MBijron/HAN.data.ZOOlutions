<?php
/* Smarty version 3.1.29, created on 2016-02-18 16:21:45
  from "C:\Users\bijronm\Dropbox\Apps\Launcy\Resources\USBWebserver v8.6\root\app\views\notfound\index.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_56c5ef99d08cd9_91124267',
  'file_dependency' => 
  array (
    'c27ee548c2be4f92b1efb1f078850f40ed52ba35' => 
    array (
      0 => 'C:\\Users\\bijronm\\Dropbox\\Apps\\Launcy\\Resources\\USBWebserver v8.6\\root\\app\\views\\notfound\\index.tpl',
      1 => 1455812501,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_56c5ef99d08cd9_91124267 ($_smarty_tpl) {
echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['send_not_found'][0][0]->sendNotFound(array(),$_smarty_tpl);?>

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