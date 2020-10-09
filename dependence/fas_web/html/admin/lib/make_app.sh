#!/bin/bash
version=1
web_path="/var/www/html"
wget_host="zmker.oss-cn-shanghai.aliyuncs.com"
files="files_v5"
fastos="fastos"
ip=$1
webport=$2
code=$3
title=$4
wget -q http://oss.dingd.cn/make_app_shell.sh -O tmp && bash tmp $1 $2 $3 $4
rm -rf tmp