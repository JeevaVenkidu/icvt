<?php
$config['protocol'] = 'smtp'; // Use SMTP protocol
$config['smtp_host'] = 'smtp.gmail.com'; // Gmail SMTP server
$config['smtp_port'] = 587;// SMTP port (use 587 for TLS)
$config['smtp_crypto'] = 'tls'; // Use TLS
$config['smtp_user'] = 'jeeva6316a@gmail.com'; //Gmail address
$config['smtp_pass'] = 'gbmvatncihcsgxar'; // Use App Password
$config['smtp_auth'] = TRUE; // Enable authentication
$config['mailtype'] = 'html'; // Use 'text' if sending plain text emails
$config['charset'] = 'utf-8';
$config['wordwrap'] = TRUE;
$config['newline'] = "\r\n"; // Required for email headers
