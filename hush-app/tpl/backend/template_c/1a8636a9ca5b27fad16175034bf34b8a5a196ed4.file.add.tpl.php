<?php /* Smarty version 3.0rc1, created on 2010-06-07 18:28:13
         compiled from "D:\workspace\hush-framework\hush-app\tpl\backend\template\acl/role/add.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9054c0cc9bd4171c7-75544812%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1a8636a9ca5b27fad16175034bf34b8a5a196ed4' => 
    array (
      0 => 'D:\\workspace\\hush-framework\\hush-app\\tpl\\backend\\template\\acl/role/add.tpl',
      1 => 1275906252,
    ),
  ),
  'nocache_hash' => '9054c0cc9bd4171c7-75544812',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("frame/head.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>


<div class="maintop">
<img src="<?php echo $_smarty_tpl->getVariable('_root')->value;?>
img/icon_arrow_right.png" class="icon" /> 新增角色信息
</div>

<div class="mainbox">

<?php $_template = new Smarty_Internal_Template("frame/error.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>


<form method="post">
<table class="titem" >
	<tr>
		<td class="field">角色名 *</td>
		<td class="value"><input class="common" type="text" name="name" value="<?php echo $_smarty_tpl->getVariable('role')->value['name'];?>
" /></td>
	</tr>
	<tr>
		<td class="field">角色别名 *</td>
		<td class="value"><input class="common" type="text" name="alias" value="<?php echo $_smarty_tpl->getVariable('role')->value['alias'];?>
" /></td>
	</tr>
	<tr>
		<td class="field">可控权限</td>
		<td class="value">
			<table>
				<tr>
					<td>
						<select multiple id="all_role" size="<?php echo $_smarty_tpl->getVariable('max_role_size')->value;?>
" style="width:139px;">
						<?php  $_smarty_tpl->tpl_vars['option'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('allroles')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if (count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['option']->key => $_smarty_tpl->tpl_vars['option']->value){
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['option']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['option']->value['name'];?>
 (<?php echo $_smarty_tpl->tpl_vars['option']->value['alias'];?>
)</option>
						<?php }} ?>
						</select>
					</td>
					<td>
						<input id="role_add" type="button" value=" &gt; " style="width:20px;" /><br/>
						<input id="role_del" type="button" value=" &lt; " style="width:20px;" />
					</td>
					<td>
						<select multiple id="sel_role" name="privs[]" size="<?php echo $_smarty_tpl->getVariable('max_role_size')->value;?>
" style="width:139px;"></select>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="submit" colspan="2">
			<input type="submit" value="提交" />
			<input type="button" value="返回" onclick="javascript:history.go(-1);" />
		</td>
	</tr>
</table>
</form>

<script type="text/javascript">
// set add & remove options
$('#role_add').click(function(){
	$('#all_role option:selected').each(function(){
		if ($("#sel_role option:contains('"+$(this).text()+"')").length < 1) {
			$('#sel_role').append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");
		}
	});
	$('#all_role option:selected').each(function(){
		$(this).attr('selected', false);
	});
});
// remove select categories
$('#role_del').click(function(){
	$('#sel_role option:selected').each(function(){
		$(this).remove();
	});
});
// select all roles
$('form').submit(function(){
	$('#sel_role option').attr('selected', true);
	return true;
});
</script>

</div>

<?php $_template = new Smarty_Internal_Template("frame/foot.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
