<!DOCTYPE html>
<html lang="en" class="app">
<head>
<meta charset="utf-8" />
<title>Heyday Revision</title>
<meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico" media="screen" />

<link rel="stylesheet" href="/res/css/app.v2.css" type="text/css" />
<link rel="stylesheet" href="/res/css/font.css" type="text/css" cache="false" />
<!-- <link rel="stylesheet" href="/res/js/fuelux/fuelux.css" type="text/css" cache="false" /> -->
<link rel="stylesheet" href="/res/css/landing.css" type="text/css" cache="false" />
</head>
<body>
<section class="vbox">
<header class="bg-dark dk header navbar navbar-fixed-top-xs">
	<div class="navbar-header aside-xl"> 
		<a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="#nav"> <i class="fa fa-bars"></i> </a>
		<a href="#" class="navbar-brand" data-toggle="fullscreen"><img src="/res/images/logo_b.png" style="max-height: 35px; width: 90px;">
			<span style="font-size: 14px;">模考管理平台</span>
		</a> 
		<a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user"> <i class="fa fa-cog"></i> </a> 
	</div>
</header>
<section>
    <section class="hbox stretch">
		<aside class="bg-light lter b-r aside-md hidden-print" id="nav">
			<section class="vbox">
				<section class="w-f scrollable">
					<div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333"> <!-- nav -->
						<nav class="nav-primary hidden-xs text-mt">
							<ul class="nav">
								<li class="ds"> <a href="/mkadc"> <i class="fa fa-tachometer icon"> <b class="bg-dark"></b> </i> <span>统计信息</span> </a> </li>
								<li class="es"> <a href="/mkadc/examination" > <i class="fa fa-tags" aria-hidden="true"><b class="bg-dark"></b> </i> <span>模考管理</span> </a> </li>
								<li class="stun"> <a href="/mkadc/student" > <i class="fa fa-address-card-o" aria-hidden="true"><b class="bg-dark"></b> </i> <span>考生管理</span> </a> </li>
								<li class="mock"> <a href="/mkadc/mock" > <i class="fa fa-history" aria-hidden="true"><b class="bg-dark"></b> </i> <span>历史模考</span> </a> </li>
							</ul>
						</nav>
					</div>
				</section>
			</section>
		</aside>