<?php
/* Smarty version 3.1.29, created on 2016-05-08 18:30:33
  from "/var/www/html/app/views/general/copyright.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.29',
  'unifunc' => 'content_572f85c999a483_70370595',
  'file_dependency' => 
  array (
    '7247ae41f54e4c1118ce3711fb958a6fef017990' => 
    array (
      0 => '/var/www/html/app/views/general/copyright.tpl',
      1 => 1456403698,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_572f85c999a483_70370595 ($_smarty_tpl) {
?>
<div id="copyright">
	<div class="container">
		<p>&copy; 2015 - <?php echo $_smarty_tpl->tpl_vars['end_date']->value;?>
 Quesoft <a href="/sitemap.xml">Sitemap</a> | <a href="javascript:void(0)">Contact</a> | <a href="https://www.dropbox.com/sh/beftf53kv3t91yu/AADw_tnmUtDLJTwGNnGG_M6Fa?dl=0">Download</a> ( The page was generated in <?php echo $_smarty_tpl->tpl_vars['php_generate_time']->value;?>
 seconds )</p> 
	</div>
</div><?php }
}
