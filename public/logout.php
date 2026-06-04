<?php
require_once __DIR__ . '/../src/bootstrap.php';
logoutUser();
redirect(publicUrl('index.php'));
