<?php
// =============================================
// LOGOUT
// =============================================

require_once "auth/middleware.php";

logoutUser();

header("Location: login.php");
exit;
?>