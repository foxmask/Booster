;<?php die(''); ?>
;for security reasons , don't remove or modify the first line

startModule=booster
startAction="default:index"

[responses]

[modules]

jelix.access=2

master_admin.access=2
jacl2db_admin.access=2
jauthdb_admin.access=2

jacl2db.access=2
jauth.access=2
jauthdb.access=1

jcommunity.access=2
jtags.access=2

booster.access=2

[coordplugins]
auth="index/auth.coord.ini.php"
autolocale="index/autolocale.plugin.ini.php"
jacl2="index/jacl2.coord.ini.php"

[acl2]
driver=db

