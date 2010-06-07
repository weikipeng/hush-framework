<?php /* Smarty version 3.0rc1, created on 2010-06-07 18:00:30
         compiled from "D:\workspace\hush-framework\tpl\backend\template\acl/user/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:28654c0cc33e226733-68463618%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd1d142ca292ae43491f7849a0894cb9e0d113cc2' => 
    array (
      0 => 'D:\\workspace\\hush-framework\\tpl\\backend\\template\\acl/user/list.tpl',
      1 => 1274950988,
    ),
  ),
  'nocache_hash' => '28654c0cc33e226733-68463618',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("frame/head.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>


<div class="maintop">
<img src="<?php echo $_smarty_tpl->getVariable('_root')->value;?>
img/icon_arrow_right.png" class="icon" /> 后台用户列表
</div>

<div class="mainbox">

<table class="tlist" >
	<thead>
		<tr class="title">
			<th align="left">&nbsp;ID</th>
			<th align="left">用户名</th>
			<th align="left">所属角色列表</th>
			<th align="right">操作&nbsp;</th>
		</tr>  
	</thead>
	<tbody>
		<?php  $_smarty_tpl->tpl_vars['user'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('userList')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['user']->key => $_smarty_tpl->tpl_vars['user']->value){
?>
		<tr>
			<td align="left"><?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
</td>
			<td align="left"><a href='useredit?id=<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
'><u><?php echo $_smarty_tpl->tpl_vars['user']->value['name'];?>
</u></a></td>
			<td align="left"><?php echo $_smarty_tpl->tpl_vars['user']->value['role'];?>
</td>
			<td align="right">
				<a href="useredit?id=<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
">编辑</a>
				<?php if ($_smarty_tpl->getVariable('_admin')->value['name']==$_smarty_tpl->getVariable('_sa')->value){?> | 
				<?php if ($_smarty_tpl->tpl_vars['user']->value['name']==$_smarty_tpl->getVariable('_sa')->value){?>删除<?php }else{ ?><a href="javascript:$.form.confirm('userdel?id=<?php echo $_smarty_tpl->tpl_vars['user']->value['id'];?>
', '确认删除用户“<?php echo $_smarty_tpl->tpl_vars['user']->value['name'];?>
”？');">删除</a><?php }?>
				<?php }?>
			</td>
		</tr>
		<?php }} ?>
	</tbody>
	<?php if ($_smarty_tpl->getVariable('_acl')->value->isAllowed($_smarty_tpl->getVariable('_admin')->value['role'],'acl_user_add')){?>
	<tfoot>
		<tr>
			<td colspan="4">
				<button type="button" class="btn1s" onclick="javascript:location.href='useradd';">新增</button>
			</td>
		</tr>
	</tfoot>
	<?php }?>
</table>

<?php $_template = new Smarty_Internal_Template("frame/page.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>


</div>

<?php $_template = new Smarty_Internal_Template("frame/foot.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
