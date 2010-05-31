{include file="frame/head.tpl"}

	<img src="{$_root}img/logo.gif" />
	
	<br/><br/><hr/><br/>
	
	<h1 style="font-size:14pt">{$welcome}</h1>
	
	<ul style="margin:10px">
		<li><img src="{$_root}img/icon_star.png" class="icon" /> ZendFramework 和 Smarty 的完美结合（MVC）</li>
		<li><img src="{$_root}img/icon_star.png" class="icon" /> 优化的 ZendFramework Url Mapping 机制（比 ZF 快 N 倍）</li>
		<li><img src="{$_root}img/icon_star.png" class="icon" /> 完善的 Full Stack 前后台框架结构（带调试框架）</li>
		<li><img src="{$_root}img/icon_star.png" class="icon" /> 提供多数据库连接池，多数据库服务器负载均衡</li>
		<li><img src="{$_root}img/icon_star.png" class="icon" /> 强大的 ACL 权限控制系统（可扩展）</li>
		<li><img src="{$_root}img/icon_star.png" class="icon" /> 易安装，易配置，易扩展</li>
	</ul>
	
	<h1 style="font-size:14pt">Hush Framework Performance Test :</h1>
	
	<ul style="margin:10px">
		<li><img src="{$_root}img/icon_arrow_right.png" class="icon" /> 路由模式 : <a href="/?debug=time">执行时间</a></li>
		<li><img src="{$_root}img/icon_arrow_right.png" class="icon" /> 传统模式 : <a href="/app/index.php?debug=time">执行时间</a></li>
	</ul>
	
	<h1 style="font-size:14pt">Hush Url Mapping Engine Test :</h1>
	
	<ul style="margin:10px">
		<li><img src="{$_root}img/icon_round.png" class="icon" /> 普通映射 : <a href="/test/mapping">/test/mapping</a></li>
		<li><img src="{$_root}img/icon_round.png" class="icon" /> 分页演示 : <a href="/test/p/1">/test/p/*</a></li>
		<li><img src="{$_root}img/icon_round.png" class="icon" /> 模糊匹配 : <a href="/test/*">/test/*</a></li>
	</ul>

{include file="frame/foot.tpl"}