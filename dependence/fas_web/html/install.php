<?php
require('system.php');
$lock = R.'/install.lock';
if(!is_file($lock))
{
	$db = db();
	$db->exec('
CREATE TABLE `app_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `payid` varchar(32) COLLATE utf8mb4_bin NOT NULL,
  `order` varchar(22) COLLATE utf8mb4_bin NOT NULL,
  `pay` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `status_time` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;');

	$db->exec('ALTER TABLE `app_order` CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;');

	echo '[ success ]';
	file_put_contents('install.lock',' ');
}
	@unlink(R.'/install.php');