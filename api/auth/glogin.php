<?php
require "./google-api-php/vendor/autoload.php";
  
  $clientId="946923186704-t0mnak1ib7sqb377jcbdssdhdc4rhmoa.apps.googleusercontent.com";
  $clientSecret="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";
  $redirectURI = 'https://localhost/bit_hostel/api/auth/login.php';
  
  $client=new Google\Client();
  $client->setApplicationName('BIT HOSTELS');
  $client->setClientId($clientId);
  $client->setClientSecret($clientSecret);
  $client->setRedirectURI($redirectURI);
  $client->addScope("email");
  $client->addScope("profile");
  ?>