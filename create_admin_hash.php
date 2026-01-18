<?php
$password = '805011Mic';
$hash = password_hash($password, PASSWORD_BCRYPT);
echo "Password hash for '805011Mic':\n";
echo $hash . "\n\n";
echo "SQL Command:\n";
echo "UPDATE users SET password='$hash' WHERE email='michael@keystoneuoa.com';\n";
