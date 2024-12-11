<?php

function isValidEmail($email) {
    // Check if the email syntax is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }

    // Extract the domain from the email
    $domain = substr(strrchr($email, "@"), 1);

    // Check if the domain has MX records
    if (!checkdnsrr($domain, 'MX')) {
        return false;
    }

    return true;
}

// Example usage
$email = 'S.77gurumoorthy@gmail.com'; // Replace with the email you want to check
if (isValidEmail($email)) {
    echo "The email address is valid and connected.";
} else {
    echo "The email address is invalid or not connected.";
}
?>
