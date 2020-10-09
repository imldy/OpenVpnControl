<?php
	$data["status"] = "success";
	$m = new Map();
	$data["versionCode"] = $m->type("cfg_sj")->getValue("versionCode",100);
	$data["url"] = $m->type("cfg_sj")->getValue("url");
	$data["content"] = $m->type("cfg_sj")->getValue("content");
	die(json_encode($data));
