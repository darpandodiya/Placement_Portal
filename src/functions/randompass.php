<?php

//Function to generate random password. 

/*
To generate random password simply pass the desired length of password in this function. 
If you omit length parameter then it will generate 6 character long password by default.

$password1 = generate_password(); // default length 8
$password2 = generate_password(6); // 6 character long password
*/

function generate_password( $length = 6 ) {
$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$password = substr( str_shuffle( $chars ), 0, $length );
return $password;
}
?>