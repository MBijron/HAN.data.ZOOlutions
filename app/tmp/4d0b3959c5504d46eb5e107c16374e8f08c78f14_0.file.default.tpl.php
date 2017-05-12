<?php
/* Smarty version 3.1.29, created on 2016-02-21 12:20:06
  from "C:\Users\maurice\Dropbox\Apps\Launcy\resources\USBWebserver v8.6\root\app\templates\default.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_56c9ab76620693_24991608',
  'file_dependency' => 
  array (
    '4d0b3959c5504d46eb5e107c16374e8f08c78f14' => 
    array (
      0 => 'C:\\Users\\maurice\\Dropbox\\Apps\\Launcy\\resources\\USBWebserver v8.6\\root\\app\\templates\\default.tpl',
      1 => 1455887655,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_56c9ab76620693_24991608 ($_smarty_tpl) {
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
