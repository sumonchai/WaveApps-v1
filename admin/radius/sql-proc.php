<?php
require_once($_SERVER['DOCUMENT_ROOT']."/assets/func/sqlQu.php");
$login->login_redir();

require "../../assets/func/valid-input.php";

include "../../assets/func/sql/radius/user/user-list.php";
include "../../assets/func/sql/radius/user/new-user.php";
include "../../assets/func/sql/radius/user/edit-user.php";
include "../../assets/func/sql/radius/user/remove-user.php";

include "../../assets/func/sql/radius/group/group-list.php";
include "../../assets/func/sql/radius/group/new-group.php";
include "../../assets/func/sql/radius/group/edit-group.php";
include "../../assets/func/sql/radius/group/remove-group.php";

include "../../assets/func/sql/radius/router/router-list.php";
include "../../assets/func/sql/radius/router/new-router.php";
include "../../assets/func/sql/radius/router/edit-router.php";
include "../../assets/func/sql/radius/router/remove-router.php";

include "../../assets/func/sql/radius/session/session-list.php";
