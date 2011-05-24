{include file="frame/head.tpl"}

<div class="maintop">
<img src="{$_root}img/icon_arrow_right.png" class="icon" /> 后台用户列表
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
		{foreach $userList as $user}
		<tr>
			<td align="left">{$user.id}</td>
			<td align="left"><a href='userEdit?id={$user.id}'><u>{$user.name}</u></a></td>
			<td align="left">{$user.role}</td>
			<td align="right">
				<a href="userEdit?id={$user.id}">编辑</a>
				{if $_admin.name eq $_sa} | 
				{if $user.name eq $_sa}删除{else}<a href="javascript:$.form.confirm('userDel?id={$user.id}', '确认删除用户“{$user.name}”？');">删除</a>{/if}
				{/if}
			</td>
		</tr>
		{/foreach}
	</tbody>
	{if $_acl->isAllowed($_admin.role, 'acl_user_add')}
	<tfoot>
		<tr>
			<td colspan="4">
				<button type="button" class="btn1s" onclick="javascript:location.href='useradd';">新增</button>
			</td>
		</tr>
	</tfoot>
	{/if}
</table>

{include file="frame/page.tpl"}

</div>

{include file="frame/foot.tpl"}