<?php
require_once "../utils/response.php";
require_once "../utils/auth.php";

// 🔐 pastikan user login
authGuard();

// JWT stateless → logout di client
response(true, "Logout berhasil");
