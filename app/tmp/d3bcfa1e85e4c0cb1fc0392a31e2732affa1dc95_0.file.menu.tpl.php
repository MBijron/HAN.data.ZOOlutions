<?php
/* Smarty version 3.1.29, created on 2016-05-08 18:30:33
  from "/var/www/html/app/views/general/menu.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_572f85c9985a31_19440882',
  'file_dependency' => 
  array (
    'd3bcfa1e85e4c0cb1fc0392a31e2732affa1dc95' => 
    array (
      0 => '/var/www/html/app/views/general/menu.tpl',
      1 => 1455811367,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_572f85c9985a31_19440882 ($_smarty_tpl) {
?>
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="javascript:void(0);">localhost</a>
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>  
					<span class="icon-bar"></span>
				</button>
			</div>
		<div class="collapse navbar-collapse" id="defaultNavbar1">
			<ul class="nav navbar-nav navHeaderCollapse">'
				<?php
$_from = $_smarty_tpl->tpl_vars['menu_items']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$__foreach_menu_item_0_saved_item = isset($_smarty_tpl->tpl_vars['menu_item']) ? $_smarty_tpl->tpl_vars['menu_item'] : false;
$__foreach_menu_item_0_saved_key = isset($_smarty_tpl->tpl_vars['menu_key']) ? $_smarty_tpl->tpl_vars['menu_key'] : false;
$_smarty_tpl->tpl_vars['menu_item'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['menu_key'] = new Smarty_Variable();
$_smarty_tpl->tpl_vars['menu_item']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['menu_key']->value => $_smarty_tpl->tpl_vars['menu_item']->value) {
$_smarty_tpl->tpl_vars['menu_item']->_loop = true;
$__foreach_menu_item_0_saved_local_item = $_smarty_tpl->tpl_vars['menu_item'];
?>
					<li><a href="/<?php echo $_smarty_tpl->tpl_vars['menu_item']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['menu_key']->value;?>
</a></li>
				<?php
$_smarty_tpl->tpl_vars['menu_item'] = $__foreach_menu_item_0_saved_local_item;
}
if ($__foreach_menu_item_0_saved_item) {
$_smarty_tpl->tpl_vars['menu_item'] = $__foreach_menu_item_0_saved_item;
}
if ($__foreach_menu_item_0_saved_key) {
$_smarty_tpl->tpl_vars['menu_key'] = $__foreach_menu_item_0_saved_key;
}
?>
			</ul>
		</div>
	</div>
</nav><?php }
}
