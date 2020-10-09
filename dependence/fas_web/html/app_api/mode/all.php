<style>
.mainmenu{
	list-style:none;
	padding:0px;
	margin:0px;
	font-size:16px;
}
.mainmenu li i{
	font-size:16px;
}
.mainmenu a{
	display:block;
	padding:8px 15px;
	color:#222;
	background:#fff;
	font-size:16px;
	border-bottom:1px solid #efefef;
}
.mainmenu a:hover{
	background:#f8f8f8;
}
</style>
<ul class="mainmenu">


<li><a href="<?php echo '?act=theme&app_key='.$_GET['app_key'].'&username='.$_GET['username'].'&password='.$_GET['password'];?>" ><i class="icon-heart"></i>&nbsp;&nbsp;主题切换</a></li>

<li><a href="<?php echo '?act=list_gg&app_key='.$_GET['app_key'].'&username='.$_GET['username'].'&password='.$_GET['password'];?>" ><i class="icon-envelope"></i>&nbsp;&nbsp;消息通知</a></li>

<li><a href="<?php echo '?act=info&app_key='.$_GET['app_key'].'&username='.$_GET['username'].'&password='.$_GET['password'];?>" ><i class="icon-flag"></i>&nbsp;&nbsp;使用记录</a></li>

<li><a href="<?php echo '?act=top&app_key='.$_GET['app_key'].'&username='.$_GET['username'].'&password='.$_GET['password'];?>" ><i class="icon-group
"></i>&nbsp;&nbsp;流量排行</a></li>

<li><a href="<?php echo '?act=user_info&app_key='.$_GET['app_key'].'&username='.$_GET['username'].'&password='.$_GET['password'];?>" ><i class="icon-user"></i>&nbsp;&nbsp;个人中心</a></li>

<li style="margin-top:15px"><a href="<?php echo '?act=help&app_key='.$_GET['app_key'].'&username='.$_GET['username'].'&password='.$_GET['password'];?>" ><i class="icon-question-sign"></i>&nbsp;&nbsp;客户服务</a></li>
<li ><a href="html/help.html" ><i class="icon-question-sign"></i>&nbsp;&nbsp;使用帮助</a></li>
<li><a href="javascript:void(0)" onclick="window.myObj.goUpdate()"><i class="icon-refresh"></i>&nbsp;&nbsp;检测更新</a></li>

<li><a href="javascript:void(0)" onclick="window.myObj.goLogin()"><i class="icon-exchange"></i>&nbsp;&nbsp;账户切换</a></li>         

</ul>