<?php



//---------Password Reset Token generator -------------------------------------------//
$length = 30;
$tk = substr(str_shuffle("qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM1234567890"), 1, $length);

//------------Dummy Password Generator----------------------------------------------//
$length = 8;
$rc = substr(str_shuffle("QWERTYUIOPLKJHGFDSAZXCVBNM1234567890"), 1, $length);

// ------- ID--------------------------------------------------------------------//
$length = date('y');
$ID = bin2hex(random_bytes($length));

// ------- Checksum--------------------------------------------------------------------//
$length = 12;
$checksum = bin2hex(random_bytes($length));

// ---Codes----------------------------------------------------------------//
$alpha = 1;
$beta = 4;
$a = substr(str_shuffle("QWERTYUIOPLKJHGFDSAZXCVBNM"), 1, $alpha);
$b = substr(str_shuffle("1234567890"), 1, 4);

$alpha = 10;
$paycode = substr(str_shuffle("QWERTYUIOPLKJHGFDSAZXCVBNM1234567890"), 1, $alpha);

/* System Admin Default Password */
$length = 8;
$defaultPass = substr(str_shuffle("QWERTYUIOPwertyuioplkjLKJHGFDSAZXCVBNM1234567890qhgfdsazxcvbnm"), 1, $length);

/* System Generated OTP */
$otp = substr(str_shuffle("1234567890"), 1, 4);


/* System Generated ID */
$length = date('y');
$sys_gen_id = bin2hex(random_bytes($length));

/* Alternative Sys Generated ID 1 */
$length = date('y');
$sys_gen_id_alt_1 = bin2hex(random_bytes($length));

/* Alternative System Generated ID 2 */
$length = date('y');
$sys_gen_id_alt_2 = bin2hex(random_bytes($length));
/* user id */
$staff_id = 'STF-' . substr(str_shuffle("1234567890"), 1, 4);
/* user_generated password */
do {
    $user_gen_password = substr(str_shuffle("QWERTYUIOPLKJHGFDSAZXCVBNM1234567890qwertyuioplkjhgfdsazxcvbnm!@#$%^&*()"), 1, 12);
} while (
    strlen($user_gen_password) < 8 ||
    !preg_match('/[A-Z]/', $user_gen_password) ||
    !preg_match('/[a-z]/', $user_gen_password) ||
    !preg_match('/[0-9]/', $user_gen_password) ||
    !preg_match('/[\W_]/', $user_gen_password)
);
/* Auth Token */
$auth_gen_token = substr(str_shuffle("QWERTYUIOPLKJHGFDSAZXCVBNM1234567890"), 1, 4);
