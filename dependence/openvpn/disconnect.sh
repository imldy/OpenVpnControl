#!/bin/sh
cd /var/www/html/
php openvpn_api/disconnect.php "$common_name" "$bytes_received" "$bytes_sent"