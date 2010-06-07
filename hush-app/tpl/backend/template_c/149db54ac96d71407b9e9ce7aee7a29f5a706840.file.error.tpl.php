<?php /* Smarty version 3.0rc1, created on 2010-06-07 18:00:15
         compiled from "D:\workspace\hush-framework\tpl\backend\template\frame/error.tpl" */ ?>
<?php /*%%SmartyHeaderCode:163704c0cc32f3f05d9-82600642%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '149db54ac96d71407b9e9ce7aee7a29f5a706840' => 
    array (
      0 => 'D:\\workspace\\hush-framework\\tpl\\backend\\template\\frame/error.tpl',
      1 => 1274950988,
    ),
  ),
  'nocache_hash' => '163704c0cc32f3f05d9-82600642',
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