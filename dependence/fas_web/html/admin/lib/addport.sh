#!/bin/bash
port=$2
type=$1

/root/res/proxy.bin -l $port -d
read has < <(cat /etc/sysconfig/iptables | grep "dport $port -j ACCEPT" )
if [ -z "$has" ];then
	iptables -A INPUT -p $type -m $type --dport $port -j ACCEPT
	service iptables save
fi
read has2 < <(cat /root/res/portlist.conf | grep "port $port tcp" )
if [ -z "$has2" ];then
	echo -e "port $port tcp">>/root/res/portlist.conf
fi