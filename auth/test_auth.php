<?php
require_once "utils/auth.php";

$user = authGuard();
response(true, "Token valid", $user);
