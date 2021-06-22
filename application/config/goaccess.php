<?php
defined('BASEPATH') OR exit('No direct script access allowed');



$config["//sip2.skyrim.dev/dashboard/dashboard/goaccess"] = 'goaccess -f /var/log/httpd/access_log';

#$config["//sip2.mediavista.id/dashboard/dashboard/goaccess"] = 'goaccess -f /var/www/vhosts/logs/sip2.mediavista.id/vhost_access_log';

$cmd = "goaccess -f /var/www/vhosts/logs/www.pixadelix.com/vhost_access_log /var/www/vhosts/logs/sip2.mediavista.id/vhost_access_log /var/www/vhosts/logs/www.mediavista.id/vhost_access_log /var/www/vhosts/logs/etalasebintaro.com/vhost_access_log /var/www/vhosts/logs/etalasemedianetwork.id/vhost_access_log /var/www/vhosts/logs/miles.pixadelix.com/vhost_access_log /var/www/vhosts/logs/rajaampatkjl.com/vhost_access_log --ignore-crawlers";

$config["//sip2.mediavista.id/dashboard/dashboard/goaccess"] = "$cmd";

$config["//pdsi.mediavista.id/webstat"] = "goaccess -f /var/www/logs/access.log --ignore-crawlers";

$config["//getlost.id/app/webstat"] = "goaccess -f /var/www/vhosts/logs/www.getlost.id/vhost_access_log /var/www/vhosts/logs/www.panoramaevents.id/vhost_access_log --ignore-crawlers";

