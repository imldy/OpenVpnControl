#!/bin/bash
port=$1
sed -i "s#^Listen.*#Listen $port #g" /etc/httpd/conf/httpd.conf
read has < <(cat /etc/sysconfig/iptables | grep "dport $port -j ACCEPT" )
if [ -z "$has" ];then
	iptables -A INPUT -p tcp -m tcp --dport $port -j ACCEPT
	service iptables save
fi
service httpd restart