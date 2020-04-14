<?php
/* Smarty version 3.1.34-dev-7, created on 2020-04-11 05:35:04
  from '/opt/lampp/htdocs/studieren/mvc/mvci/application/admin/view/tpl/cat_list.html' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5e913ae8532e74_75145318',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '310a7bc3a49ff699ed8bcb6db7e70fab3b09311c' => 
    array (
      0 => '/opt/lampp/htdocs/studieren/mvc/mvci/application/admin/view/tpl/cat_list.html',
      1 => 1586575758,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5e913ae8532e74_75145318 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Category List</title>
	</head>
	<body bgcolor="mintcream">
		<table border="1px" bordercolor="gray" cellspacing="0px">
			<caption><h3>Category List</h3></caption>
			<tr>
				<th>Goods Id</th>
				<th>Goods Name</th>
				<th>Shop Price</th>
				<th>Market Proce</th>
			</tr>
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['cat_list']->value, 'v', false, 'k');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['k']->value => $_smarty_tpl->tpl_vars['v']->value) {
?>
			<tr>
				<td><?php echo $_smarty_tpl->tpl_vars['v']->value['goods_id'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['v']->value['goods_name'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['v']->value['shop_price'];?>
</td>
				<td><?php echo $_smarty_tpl->tpl_vars['v']->value['market_price'];?>
</td>
			</tr>
			<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
		</table>
	</body>
</html>
<?php }
}
