;<?php die(''); ?>
;for security reasons , don't remove or modify the first line

startModule=master_admin
startAction="default:index"

[responses]
html=adminHtmlResponse
htmlauth=adminLoginHtmlResponse
[modules]
jacldb.access=0
junittests.access=0
jWSDL.access=0
jauth.access=2
master_admin.access=2
jauthdb.access=2
jauthdb.installparam=defaultuser
jauthdb_admin.access=2
jacl2db.access=2
jacl2db.installparam=defaultuser
jacl2db_admin.access=2
[simple_urlengine_entrypoints]
adminboost="jacl2db~*@classic, jauth~*@classic, jacl2db_admin~*@classic, jauthdb_admin~*@classic, master_admin~*@classic"

[coordplugins]
auth="adminboost/auth.coord.ini.php"

jacl2="adminboost/jacl2.coord.ini.php"
