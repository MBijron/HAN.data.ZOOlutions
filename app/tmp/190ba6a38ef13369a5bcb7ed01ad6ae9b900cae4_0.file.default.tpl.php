<?php
/* Smarty version 3.1.29, created on 2017-05-12 09:27:16
  from "C:\xampp\htdocs\Somerleyton\app\templates\default.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_59157ff48deea8_92122069',
  'file_dependency' => 
  array (
    '190ba6a38ef13369a5bcb7ed01ad6ae9b900cae4' => 
    array (
      0 => 'C:\\xampp\\htdocs\\Somerleyton\\app\\templates\\default.tpl',
      1 => 1456404774,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_59157ff48deea8_92122069 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
		<meta name="viewport" content="width = device-width, initial-scale=1.0">
		<meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['keywords']->value;?>
">
		<meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['description']->value;?>
">
		<?php echo $_smarty_tpl->tpl_vars['library_files']->value;?>

		<?php echo $_smarty_tpl->tpl_vars['css']->value;?>

		<?php echo $_smarty_tpl->tpl_vars['js']->value;?>

	</head>
	<body>
		<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

	</body>
</html><?php }
}