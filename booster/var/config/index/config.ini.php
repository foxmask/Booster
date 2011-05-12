;<?php die(''); ?>
;for security reasons , don't remove or modify the first line

startModule=booster
startAction="default:index"

[responses]
[modules]
booster.access=2

jtags.access=2

jcommunity.access=2

jacl2db.access=2
[coordplugins]
auth="index/auth.coord.ini.php"
autolocale = "index/autolocale.plugin.ini.php"
jacl2="index/jacl2.coord.ini.php"
[acl2]
driver=db
