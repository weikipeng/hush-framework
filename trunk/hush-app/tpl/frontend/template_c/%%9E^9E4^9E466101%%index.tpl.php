<?php /* Smarty version 2.6.25, created on 2010-06-07 18:00:10
         compiled from index%5Cindex.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frame/head.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

	<img src="<?php echo $this->_tpl_vars['_root']; ?>
img/logo.gif" />
	
	<div style="padding:8px 0px 8px 0px"><hr/></div>
	
	<h1 style="font-size:14pt"><?php echo $this->_tpl_vars['welcome']; ?>
</h1>
	
	<ul style="margin:10px">
		<li><img src="<?php echo $this->_tpl_vars['_root']; ?>
img/icon_star.png" class="icon" /> ZendFramework 和 Smarty 的完美结合（MVC）</li>
		<li><img src="<?php echo $this->_tpl_vars['_root']; ?>
img/icon_star.png" class="icon" /> 优化的 ZendFramework Url Mapping 机制（比 ZF 快 N 倍）</li>
		<li><img src="<?php echo $this->_tpl_vars['_root']; ?>
img/icon_star.png" class="icon" /> 完善的 Full Stack 前后台框架结构（带调试框架）</li>
		<li><img src="<?php echo $this->_tpl_vars['_root']; ?>
img/icon_star.png" class="icon" /> 提供多数据库连接池，多数据库服务器负载均衡</li>
		<li><img src="<?php echo $this->_tpl_vars['_root']; ?>
img/icon_star.png" class="icon" /> 强大的 ACL 权限控制系统（可扩展）</li>
		<li><img src="<?php echo $this->_tpl_vars['_root']; ?>
img/icon_star.png" class="icon" /> 易安装，易配置，易扩展</li>
	</ul>
	
	<h1 style="font-size:14pt">Hush Framework Performance Test :</h1>
	
	<ul style="margin:10px">
		<li><img src="<?php echo $this->_tpl_vars['_root']; ?>
img/icon_arrow_right.png" class="icon" /> 路由模式 : <a href="/?debug=time">执行时间</a></li>
		<li><img src="<?php echo $this->_tpl_vars['_root']; ?>
img/icon_arrow_right.png" class="icon" /> 传统模式 : <a href="/app/index.php?debug=time">执行时间</a></li>
	</ul>
	
	<h1 style="font-size:14pt">Hush Url Mapping Engine Test :</h1>
	
	<ul style="margin:10px">
		<li><img src="<?php echo $this->_tpl_vars['_root']; ?>
img/icon_round.png" class="icon" /> 普通映射 : <a href="/test/mapping">/test/mapping</a></li>
		<li><img src="<?php echo $this->_tpl_vars['_root']; ?>
img/icon_round.png" class="icon" /> 分页演示 : <a href="/test/p/1">/test/p/*</a></li>
		<li><img src="<?php echo $this->_tpl_vars['_root']; ?>
img/icon_round.png" class="icon" /> 模糊匹配 : <a href="/test/*">/test/*</a></li>
	</ul>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "frame/foot.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>