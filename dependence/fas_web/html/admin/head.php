<?php
	require('system.php');
?>
<!DOCTYPE html>
<html lang="cn" >
<head>
<meta charset="utf-8" />
<title><?=$title?:"FAS后台管理"?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="stylesheet" href="/css/bootstrap.min.css" />
<script src="/css/jquery.min.js"></script>
<script src="/css/jquery-ui.js"></script>
<script src="/css/bootstrap.min.js"></script>
<script src="js/amcharts.js" type="text/javascript"></script>
<script src="js/serial.js" type="text/javascript"></script>
<script src="js/pie.js" type="text/javascript"></script>
<link rel="stylesheet" href="/css/font-awesome.min.css">
            <link type="text/css" href="/css/custom-theme/jquery-ui-1.10.0.custom.css" rel="stylesheet" />
            <!--[if IE 7]>
            <link rel="stylesheet" href="assets/css/font-awesome-ie7.min.css">
            <![endif]-->
            <!--[if lt IE 9]>
            <link rel="stylesheet" type="text/css" href="css/custom-theme/jquery.ui.1.10.0.ie.css"/>
            <![endif]-->
            <link href="/assets/css/docs.css" rel="stylesheet">
            <link href="/assets/js/google-code-prettify/prettify.css" rel="stylesheet">
</head>
<body>
<style type="text/css">

*{
	padding:0px;
	list-style:none;	
	font-family: "Helvetica Neue", Helvetica, Arial, "Hiragino Sans GB", "Hiragino Sans GB W3", "WenQuanYi Micro Hei", "Microsoft YaHei UI", "Microsoft YaHei";
	
}

html,body{
	background:#efefef;
	padding:0px;
	margin:0px;
	font-family: "Helvetica Neue", Helvetica, Arial, "Hiragino Sans GB", "Hiragino Sans GB W3", "WenQuanYi Micro Hei", "Microsoft YaHei UI", "Microsoft YaHei", 
	background:#f5f5fa;
	background-image:url("/public/images/bg.png");	
	min-height:400px;
}
a:link{
text-decoration:none;
}
a:visited{
text-decoration:none;
}
a:hover{
	text-decoration:none;
	transition:.3s;	
}
a:active{
text-decoration:none;
}
 .container{
	
}
.content-main{
	background:#fff;
	padding:20px 20px;

}
.btn,input[type="text"], input[type="password"],input,.form-control,.ui-autocomplete-input, textarea, .uneditable-input{
	-webkit-border-radius: 0px;
    -moz-border-radius: 0px;
    border-radius: 0px;
	padding-left:10px;
	padding-right:10px;
}
.control-label{
	color:#555;
	font-weight:normal;
}
.btn:hover{
	transition: background-color .3s;	
}
.tip{
	padding:15px;
	margin:10px 0px;
	color:#fff;
}
.tip a{
	color:#fff;
}
.tip-success{
	background:#5bb85d;
}
.tip-error{
	background:#d8554d;
}
.bg-color-green{
	background-color:#4CAF50;
}
.box-title{
	background:#30b1d5;
	padding:10px 20px;
	border:1px solid #f8f8f8;
	margin-bottom:10px;
	color:#fff;
}
.box{
	background:#fff;
	padding:20px 20px 20px 20px;
	position:relative;
	border:1px solid #f8f8f8;
}
.box-z{
	display:none;
	position:absolute;
	top:0px;
	left:0px;
	width:100%;
	height:100%;
	z-index:997;
}

.sile{
	width:220px;
	height:100%;
	overflow-y:auto;
	background:#39435C;
	position:fixed;
	left:0px;
	top:0px;
	min-height:550px;
	z-index:999;
	padding-bottom:20px;
	overflow-x:hidden;
}

@keyframes myfirst
{
   
}
.admin-logo{
	display:block;
	margin:auto;
	width:130px;
	height:130px;
	cursor:pointer;
	animation: myfirst 15s linear infinite; 
}
.admin-logo:hover{
	animation-play-state:paused;
	
}
/*transition: 1s;*/
.section{
	width:100%;
	padding:10px 0px;
	
}
.section>li{
	padding:0px 0px;
	margin-bottom:4px;
}

.section>li>a{
	color:#fff;
	font-size:13px;
	display:block;
	padding:0px 31px;
	height:35px;
	line-height:35px;	
}
.section .section-sub{
	display:none;

}
.section .active>a{
	color:#fff;
	background:#425164;
	border-left:3px solid #00AAFF;
	padding:0px 31px 0px 28px;
}
.section .icon{
	float:left;
	height:35px;
	width:20px;
	line-height:35px;	
	margin-right:15px;
	font-size:18px;
}

.angle{
	float:right;
	height:35px;
	line-height:35px;

}
.section .active .icon{
	color:#00AAFF;
}

.section>li>a:hover{
	background:#425164;
	transition: background .3s;
}
.section .active .section-sub{
	display:block;
	background:#425164;
	background:#425164;
	border-left:3px solid #00AAFF;
}

.section .section-sub>li{
	margin:0px;
}
.section-sub>li>a{
	color:#999;
	font-size:13px;
	padding:0px 20px 0px 66px;
	width:100%;
	height:30px;
	line-height:30px;
	display:block;
}
.section .active .section-sub>li>a{
	padding:0px 20px 0px 63px;
}

.section-sub>li>a:hover{
	color:#efefef;
}
.content-box{
	padding:0px;
	margin-left:220px;
	
}

.main-top-box{
	min-height:50px;
}
.main-top{
    background: #fff;
   
	border-bottom:1px solid #ccc;
}
.main-top{
	position:fixed;
	top:0px;
	left:0px;
	width:100%;
	z-index:998;
	padding-left:220px;
	
	
}
.main-top>div{
	padding:0px 15px;
}
.top-tips{
	display:none;
	float:left;
	height:50px;
	line-height:50px;
	text-align:center;
	overflow-x:hidden;
	cursor:pointer;
	color:#222;
}
.gonggao{
	display:none;
	background:#f8f8f8;
	padding:10px;
	margin:10px 0px;
	text-indent:2em;
}
.nav-left{
	float:left;
	line-height:50px;
	height:50px;
}
.nav-right{
	float:right;
	line-height:50px;
	height:50px;
}
.nav-right a{
	
}

.content-in{
	margin:20px;
}
.icon-reorders{
		display:none;
}	
.shows{
	font-size:22px;
	position:relative;
	top:3px;
}

@media screen and (max-width:768px){
      /*不大于768px的设备尺寸中 响应式布局的特定样式*/
	body,html{
		overflow-x:hidden;
		width:100%;
	}
	.box-z{
		display:block;
	}
	.content-box{
		padding:0px;
		margin-left:0px;
	}
	.sile{
		display:none;
		width:100%;
	}
	.main-top{
		padding-left:0px;
		background:#39435C;
		padding:0px;
	}
	.gonggao{
		background:#fff;
		margin:0px -15px 0px -15px;
	}	
	.top-tips{
		float:right;
		width:200px;
		overflow: hidden;
		color:#fff;
		text-overflow:ellipsis;
		white-space: nowrap;
	}
	.icon-reorders{
		display:block;
	}	
	.content-in{
		margin:0px;
	}
	.section{
		margin-top:50px;
	}
	.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12{
		padding-left:0px;
		padding-right:0px;
	}
	.row{
		margin:0px;
	}
}
</style>
<?php 
if($login_allow && (($_SESSION["dd"]["username"] == "admin" && $_SESSION["dd"]["password"] == "admin")|| strlen($_SESSION["dd"]["password"]) < 4 )){
	?>
	<!-- 模态框（Modal） -->
<div class="modal fade" id="anquan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
						aria-hidden="true">×
				</button>
				<h4 class="modal-title" id="myModalLabel">
					安全信息警告
				</h4>
			</div>
			<div class="modal-body">
				<span class="glyphicon glyphicon-warning-sign" style="color: rgb(255, 38, 30); font-size: 34px;"> 风险警告</span><hr>

系统检测到您使用的是系统默认密码或者密码长度过短，这具有相当大的安全风险！请您立即 进入【系统设置】->【<a href="user.php">管理密码</a>】 修改密码！
<pre>
为了您的系统安全 请勿使用纯数字密码、简易密码、默认密码！这很容易被入侵！同时我们推荐您手动修改数据库管理地址phpmyadmin的文件名字。无论是不是随机!
</pre>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" 
						data-dismiss="modal">我知道了
				</button>
				
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
$(function () { $('#anquan').modal({

})});
</script>
	<?php
}
?>
