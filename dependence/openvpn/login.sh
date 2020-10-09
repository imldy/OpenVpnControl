#!/bin/bash
source /etc/openvpn/auth_config.conf
#用户名 密码 远端端口（服务器） 远端IP 本机端口 本机ip 协议
read status < <(php /var/www/html/openvpn_api/login.php "$username" "$password" "$remote_port_1" "$address" "$untrusted_port" "$untrusted_ip" "$proto_1" "$daemon_pid")
if [[ "$status" == "success" ]];then
	read has < <(cat /var/www/html/openvpn_api/online_1194.txt | grep ",$username,")
	if [ -n "$has" ];then
		/root/res/sha "$username" 7075
	fi
	read has < <(cat /var/www/html/openvpn_api/online_1195.txt | grep ",$username,")
	if [ -n "$has" ];then
		/root/res/sha "$username" 7076
	fi
	read has < <(cat /var/www/html/openvpn_api/online_1196.txt | grep ",$username,")
	if [ -n "$has" ];then
		/root/res/sha "$username" 7077
	fi
	read has < <(cat /var/www/html/openvpn_api/online_1197.txt | grep ",$username,")
	if [ -n "$has" ];then
		/root/res/sha "$username" 7078
	fi
	read has < <(cat /var/www/html/openvpn_api/user-status-udp.txt | grep ",$username,")
	if [ -n "$has" ];then
		/root/res/sha "$username" 7079
	fi
exit 0
else
exit 1
fi
