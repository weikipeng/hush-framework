<?php /* Smarty version 3.0rc1, created on 2010-06-07 18:00:23
         compiled from "D:\workspace\hush-framework\tpl\backend\template\index/frame/head.tpl" */ ?>
<?php /*%%SmartyHeaderCode:103174c0cc3373a3f55-71599341%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eb37a7cd9a3a3545c852f365765989242141b510' => 
    array (
      0 => 'D:\\workspace\\hush-framework\\tpl\\backend\\template\\index/frame/head.tpl',
      1 => 1274950988,
    ),
  ),
  'nocache_hash' => '103174c0cc3373a3f55-71599341',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div class="head">
	<div class="top_logo">
		<img src="<?php echo $_smarty_tpl->getVariable('_root')->value;?>
img/logo.gif"  alt="iHush Track System" />
	</div>
	<div class="top_link">
		<ul>
			<li class="welcome">欢迎您, <?php echo $_smarty_tpl->getVariable('_admin')->value['name'];?>
 <?php if ($_smarty_tpl->getVariable('_admin')->value['sa']){?>(sa)<?php }?></li>
			<li class="menuact"><a href="#" id="togglemenu">[隐藏菜单]</a></li>
			<li><a href="<?php echo $_smarty_tpl->getVariable('_root')->value;?>
auth/logout" target="_top">[退出]</a></li>
		</ul>
		<!--
		<div class="quick">
			<a href="#" class="ac_qucikmenu" id="ac_qucikmenu">1</a>
			<a href="#" class="ac_qucikadd" id="ac_qucikadd">2</a>
		</div>
		-->
	</div>
	<div class="nav" id="nav">
		<ul>
			<?php  $_smarty_tpl->tpl_vars['topAppList'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('appList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['topAppList']->index=-1;
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['topAppList']->key => $_smarty_tpl->tpl_vars['topAppList']->value){
 $_smarty_tpl->tpl_vars['topAppList']->index++;
 $_smarty_tpl->tpl_vars['topAppList']->first = $_smarty_tpl->tpl_vars['topAppList']->index === 0;
?>
				<li><a <?php if ($_smarty_tpl->tpl_vars['topAppList']->first){?>class="thisclass"<?php }?> href="javascript:;" _for="top_<?php echo $_smarty_tpl->tpl_vars['topAppList']->value['id'];?>
" target="main"><?php echo $_smarty_tpl->tpl_vars['topAppList']->value['name'];?>
</a></li>
			<?php }} ?>
		</ul>
	</div>
</div>
<!-- header end -->