;<?php die(''); ?>
;for security reasons , don't remove or modify the first line

startModule=master_admin
startAction="default:index"

[responses]
html=adminHtmlResponse
htmlauth=adminLoginHtmlResponse

[modules]
jelix.access=2
master_admin.access=2
jacl2db_admin.access=2
jauthdb_admin.access=2

jacl2db.access=2
jauth.access=2
jauthdb.access=2

jcommunity.access=1
jtags.access=1

boosteradmin.access=2
booster.access=1

jcommunity.dbprofile=hfnu
jauthdb_admin.dbprofile=hfnu 

[simple_urlengine_entrypoints]
adminboost="jacl2db~*@classic, jauth~*@classic, jacl2db_admin~*@classic, jauthdb_admin~*@classic, master_admin~*@classic, jcommunity~*@classic, booster~*@classic, jtags~*@classic"

[coordplugins]
auth="adminboost/auth.coord.ini.php"
jacl2="adminboost/jacl2.coord.ini.php"
