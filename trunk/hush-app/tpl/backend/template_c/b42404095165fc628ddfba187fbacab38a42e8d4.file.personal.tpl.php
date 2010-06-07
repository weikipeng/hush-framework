<?php /* Smarty version 3.0rc1, created on 2010-06-07 18:34:37
         compiled from "D:\workspace\hush-framework\hush-app\tpl\backend\template\common\personal.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10764c0ccb3d494b58-04213986%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b42404095165fc628ddfba187fbacab38a42e8d4' => 
    array (
      0 => 'D:\\workspace\\hush-framework\\hush-app\\tpl\\backend\\template\\common\\personal.tpl',
      1 => 1275906254,
    ),
  ),
  'nocache_hash' => '10764c0ccb3d494b58-04213986',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("frame/head.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>


<div class="maintop">
<img src="<?php echo $_smarty_tpl->getVariable('_root')->value;?>
img/icon_arrow_right.png" class="icon" /> 个人信息修改
</div>

<div class="mainbox">

<?php $_template = new Smarty_Internal_Template("frame/error.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>


<form method="post">
<table class="titem" >
	<tr>
		<td class="field">用户名 *</td>
		<td class="value"><input class="common" type="text" name="name" value="<?php echo $_smarty_tpl->getVariable('user')->value['name'];?>
" /></td>
	</tr>
	<tr>
		<td class="field">用户密码</td>
		<td class="value"><input class="common" type="password" name="pass" value="" /></td>
	</tr>
	<tr>
		<td class="submit" colspan="2">
			<input type="submit" value="提交" />
			<input type="button" value="返回" onclick="javascript:history.go(-1);" />
		</td>
	</tr>
</table>
</form>

</div>

<?php $_template = new Smarty_Internal_Template("frame/foot.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
