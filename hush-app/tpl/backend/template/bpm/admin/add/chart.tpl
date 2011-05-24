{include file="frame/head.tpl"}

<div class="maintop">
<img src="{$_root}img/icon_arrow_right.png" class="icon" /> 为流程 “{$flow.bpm_flow_name}” 定义流程步骤
</div>

<div class="mainbox">

{include file="frame/error.tpl"}

<form id="save_chart_form" method="post">
<input type="hidden" name="bpm_flow_id" value="{$smarty.get.flowId}" />
<div style="margin-bottom:10px;">
	<input id="add_node" type="button" value="添加节点" />&nbsp;
	<input id="clear_path" type="button" value="清除路径" />&nbsp;
	<input id="save_chart_as_xml" type="button" value="保存流程" />
</div>
</form>

<div class="flow_chart_box">
	<canvas id="canvasBox" width="800" height="600" style="border:1px solid black"></canvas>
	<div id="flowChartDragBox" class="flow_chart_drag_box">
		{foreach $nodeList as $node}
		<div id="drag{$node.bpm_node_id}" class="flow_chart_drag_flow flow_chart_node_type_{$node.bpm_node_type} flow_chart_node_attr_{$node.bpm_node_attr}" style="left:{$node.bpm_node_pos_left}px;top:{$node.bpm_node_pos_top}px">
			{$node.bpm_node_id} - {$node.bpm_node_name}
		</div>
		{/foreach}
	</div>
</div>

<script type="text/javascript">
var FlowChart = 
{
	canvas : null,
	
	initCanvas : function (canvasId)
	{
		this.canvas = document.getElementById(canvasId);
		if (!this.canvas.getContext) alert('请检查你的浏览器是否支持 Canvas 控件.');
	},
	
	drawLine : function (e1, e2)
	{
		try {
		
			e1 = $('#' + e1);
			e2 = $('#' + e2);
			w1 = parseInt(e1.width(), 10);
			w2 = parseInt(e2.width(), 10);
			h1 = parseInt(e1.height(), 10);
			h2 = parseInt(e2.height(), 10);
			l1 = parseInt(e1.position().left, 10);
			l2 = parseInt(e2.position().left, 10);
			t1 = parseInt(e1.position().top, 10);
			t2 = parseInt(e2.position().top, 10);
			
			sPos = { 'x' : l1 + w1 / 2, 'y' : t1 + h1 / 2 }
			ePos = { 'x' : l2 + w2 / 2, 'y' : t2 + h2 / 2 }
			
			var ctx = this.canvas.getContext('2d');
			ctx.lineWidth = 1;
			ctx.beginPath();
			ctx.moveTo(sPos.x, sPos.y);
			ctx.lineTo(ePos.x, ePos.y);
			ctx.closePath();
			ctx.strokeStyle = "#66CC00";
			ctx.stroke();
			
			this.drawArrow(sPos, ePos);
			
		} catch (e) {}
	},
	
	drawArrow : function (p1, p2)
	{
		la = 10;
		lx = p2.x - p1.x;
		ly = p2.y - p1.y;
		lz = Math.sqrt(Math.pow(lx, 2) + Math.pow(ly, 2));
		xb = p1.x + (lx / 2);	// 中间点坐标 x
		yb = p1.y + (ly / 2);	// 中间点坐标 y
		xa = la * (lx / lz);	// 箭头三角形关键长度 x
		ya = la * (ly / lz);	// 箭头三角形关键长度 y
		x1 = xb + xa;			// 箭头顶点坐标 x
		y1 = yb + ya;			// 箭头顶点坐标 y
		x2 = xb + (ya / 2);		// 箭头边点坐标 x
		y2 = yb - (xa / 2);		// 箭头边点坐标 y
		x3 = xb - (ya / 2);		// 箭头边点坐标 x
		y3 = yb + (xa / 2);		// 箭头边点坐标 y
		
		var ctx = this.canvas.getContext('2d');
		ctx.beginPath();
		ctx.moveTo(x1, y1);
		ctx.lineTo(x2, y2);
		ctx.lineTo(x3, y3);
		ctx.closePath();
		ctx.fillStyle = "#66CC00";
		ctx.fill();
	},
	
	clearAll : function ()
	{
		var ctx = this.canvas.getContext('2d');
		ctx.clearRect(0,0,800,600);
	},
	
	debug : function (msg)
	{
		if (!$('#flowchartdebug').length) {
			$('<div id="flowchartdebug"></div>').css({
				'width' : 200,
				'height' : 200,
				'background' : 'white',
				'border' : '1px solid red',
				'position' : 'absolute',
				'right' : 0,
				'top' : 0
			}).appendTo('body');
		}
		$('#flowchartdebug').html(msg);
	}
}

$(document).ready(function(){
	FlowChart.initCanvas('canvasBox');
	{foreach $pathList as $path}FlowChart.drawLine('drag{$path.bpm_node_id_from}', 'drag{$path.bpm_node_id_to}');
	{/foreach}
	$('#flowChartDragBox').find('div').draggable({
		containment: '#flowChartDragBox',
		drag: function(){
			FlowChart.clearAll();
			{foreach $pathList as $path}FlowChart.drawLine('drag{$path.bpm_node_id_from}', 'drag{$path.bpm_node_id_to}');
{/foreach}
		},
		stop: function(){
			var nodeId = parseInt($(this).attr('id').substr(4), 10);
			var nodePosLeft = parseInt($(this).position().left, 10);
			var nodePosTop = parseInt($(this).position().top, 10);
			$.post('/bpm/adminNodeUpdatePos', {
				'nodeId' : nodeId,
				'nodePosLeft' : nodePosLeft,
				'nodePosTop' : nodePosTop
			}, function(data){
								
			});
		}
	}).click(function(){
		var nodeId = parseInt($(this).attr('id').substr(4), 10);
		$.overlay.frame('/bpm/adminNodeEdit/flowId/{$smarty.get.flowId}/nodeId/' + nodeId, function(){});
	});
});

$('#add_node').click(function(){
	$.overlay.frame('/bpm/adminNodeAdd/flowId/{$smarty.get.flowId}', function(){});
});
$('#clear_path').click(function(){
	$.get('/bpm/adminPathClear/flowId/{$smarty.get.flowId}', function(){
		location.reload();
	});
});
$('#save_chart_as_xml').click(function(){
	$('#save_chart_form').submit();
});
</script>

</div>

{include file="frame/foot.tpl"}