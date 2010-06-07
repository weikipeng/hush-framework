<?php /* Smarty version 3.0rc1, created on 2010-06-07 18:27:58
         compiled from "D:\workspace\hush-framework\hush-app\tpl\backend\template\frame/error.tpl" */ ?>
<?php /*%%SmartyHeaderCode:201924c0cc9aea397d3-08577071%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '73b8d584c7c2bf663aa85af4e1e1e87f44dfc9c2' => 
    array (
      0 => 'D:\\workspace\\hush-framework\\hush-app\\tpl\\backend\\template\\frame/error.tpl',
      1 => 1275906254,
    ),
  ),
  'nocache_hash' => '201924c0cc9aea397d3-08577071',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_smarty_tpl->getVariable('errors')->value){?>
	<div class="errorbox">
	<?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('errors')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
?>
		<span><b>!</b> <?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</span>
	<?php }} ?>
	</div>
<?php }?>