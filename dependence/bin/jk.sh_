#!/bin/bash
source /etc/openvpn/auth_config.conf
while true
do
	read nowtime < <(date +%s)
	(mysql -h$mysql_host -P$mysql_port -u$mysql_user -p$mysql_pass -N -e "use $mysql_data;update openvpn set i=0,online=0 where endtime <= $nowtime OR irecv+isent>maxll;")
	sleep 60
done