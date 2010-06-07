<?php /* Smarty version 3.0rc1, created on 2010-06-07 18:28:18
         compiled from "D:\workspace\hush-framework\hush-app\tpl\backend\template\test\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:316804c0cc9c26d8ee3-42927339%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cb05a7e2a31cbeb6b47c47d20eacf6d28b94469a' => 
    array (
      0 => 'D:\\workspace\\hush-framework\\hush-app\\tpl\\backend\\template\\test\\index.tpl',
      1 => 1275906252,
    ),
  ),
  'nocache_hash' => '316804c0cc9c26d8ee3-42927339',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("frame/head.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>


<div class="maintop">
<img src="<?php echo $_smarty_tpl->getVariable('_root')->value;?>
img/icon_arrow_right.png" class="icon" /> <b>测试应用</b>
</div>

<div class="mainbox">
	
	<h1 style="font-size:14pt"><?php echo $_smarty_tpl->getVariable('welcome')->value;?>
</h1>
	
	<ul style="margin-top:10px">
		<li><img src="<?php echo $_smarty_tpl->getVariable('_root')->value;?>
img/icon_star.png" class="icon" /> ZendFramework 和 Smarty 的完美结合（MVC）</li>
		<li><img src="<?php echo $_smarty_tpl->getVariable('_root')->value;?>
img/icon_star.png" class="icon" /> 优化的 ZendFramework Url Mapping 机制（比 ZF 快 N 倍）</li>
		<li><img src="<?php echo $_smarty_tpl->getVariable('_root')->value;?>
img/icon_star.png" class="icon" /> 完善的 Full Stack 前后台框架结构（带调试框架）</li>
		<li><img src="<?php echo $_smarty_tpl->getVariable('_root')->value;?>
img/icon_star.png" class="icon" /> 提供多数据库连接池，多数据库服务器负载均衡</li>
		<li><img src="<?php echo $_smarty_tpl->getVariable('_root')->value;?>
img/icon_star.png" class="icon" /> 强大的 ACL 权限控制系统（可扩展）</li>
		<li><img src="<?php echo $_smarty_tpl->getVariable('_root')->value;?>
img/icon_star.png" class="icon" /> 易安装，易配置，易扩展</li>
	</ul>
	
	<h1 style="font-size:14pt">Hush Framework Debug Test :</h1>
	
	<ul style="margin:10px">
		<li><img src="<?php echo $_smarty_tpl->getVariable('_root')->value;?>
img/icon_arrow_right.png" class="icon" /> 调试页面 : <a href="?debug=time">执行时间</a></li>
		<li><img src="<?php echo $_smarty_tpl->getVariable('_root')->value;?>
img/icon_arrow_right.png" class="icon" /> 调试全部 : <a href="?debug=time,sql">时间&SQL</a></li>
	</ul>
	
	<h1 style="font-size:14pt">JQuery UI Demos :</h1>
	
	<div id="jquery-ui-demos">
		<div style="margin:10px;">
			<p>Date: <input type="text" id="datepicker"></p>
		</div>
		<script type="text/javascript">
		$(function() {
			$("#datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
		});
		</script>
	</div>
	
</div>

<?php $_template = new Smarty_Internal_Template("frame/foot.tpl", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
