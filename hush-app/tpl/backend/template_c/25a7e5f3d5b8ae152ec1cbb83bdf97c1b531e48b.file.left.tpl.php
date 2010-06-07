<?php /* Smarty version 3.0rc1, created on 2010-06-07 18:00:23
         compiled from "D:\workspace\hush-framework\tpl\backend\template\index/frame/left.tpl" */ ?>
<?php /*%%SmartyHeaderCode:202264c0cc33740ed48-77594278%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '25a7e5f3d5b8ae152ec1cbb83bdf97c1b531e48b' => 
    array (
      0 => 'D:\\workspace\\hush-framework\\tpl\\backend\\template\\index/frame/left.tpl',
      1 => 1274950988,
    ),
  ),
  'nocache_hash' => '202264c0cc33740ed48-77594278',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="left">

	<div class="menu" id="menu">
	
	<?php  $_smarty_tpl->tpl_vars['topAppList'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('appList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['topAppList']->index=-1;
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['topAppList']->key => $_smarty_tpl->tpl_vars['topAppList']->value){
 $_smarty_tpl->tpl_vars['topAppList']->index++;
?>
		<?php  $_smarty_tpl->tpl_vars['groupList'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['topAppList']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['groupList']->index=-1;
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['groupList']->key => $_smarty_tpl->tpl_vars['groupList']->value){
 $_smarty_tpl->tpl_vars['groupList']->index++;
?>
		<div id="items_top_<?php echo $_smarty_tpl->tpl_vars['topAppList']->value['id'];?>
">
			<dl id="dl_items_<?php echo $_smarty_tpl->tpl_vars['topAppList']->index+1;?>
_<?php echo $_smarty_tpl->tpl_vars['groupList']->index+1;?>
">
			<dt><?php echo $_smarty_tpl->tpl_vars['groupList']->value['name'];?>
</dt>
			<dd>
				<ul>
					<?php  $_smarty_tpl->tpl_vars['appItem'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['groupList']->value['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['appItem']->key => $_smarty_tpl->tpl_vars['appItem']->value){
?>
					<li><a href="<?php if ($_smarty_tpl->tpl_vars['appItem']->value['path']){?><?php echo $_smarty_tpl->tpl_vars['appItem']->value['path'];?>
<?php }else{ ?>javascript:;<?php }?>" target="main"><?php echo $_smarty_tpl->tpl_vars['appItem']->value['name'];?>
</a></li>
					<?php }} ?>
				</ul>
			</dd>
			</dl>
		</div><!-- Item End -->
		<?php }} ?>
	<?php }} ?>
	
	</div>

</div>
<!-- left end -->