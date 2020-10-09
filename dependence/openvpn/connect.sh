#!/bin/sh
# 用户名 虚拟IP PID
php /var/www/html/openvpn_api/connect.php "$username" "$ifconfig_pool_local_ip" "$daemon_pid"
exit 0
