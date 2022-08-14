<?php

use Dapphp\Radius\Radius;

require_once 'C:/Users/Menendezy/Documents/Portail/back/vendor/autoload.php';
// or, if using composer
require_once '/path/to/vendor/autoload.php';

$client = new Radius();

// set server, secret, and basic attributes
$client->setServer('192.168.10.12') // RADIUS server address
       ->setSecret('radius shared secret')
       ->setNasIpAddress('10.0.1.2') // NAS server address
       ->setAttribute(32, 'login');  // NAS identifier

// PAP authentication; returns true if successful, false otherwise
$authenticated = $client->accessRequest($username, $password);

// CHAP-MD5 authentication
$client->setChapPassword($password); // set chap password
$authenticated = $client->accessRequest($username); // authenticate, don't specify pw here

// MSCHAP v1 authentication
$client->setMSChapPassword($password); // set ms chap password (uses openssl or mcrypt)
$authenticated = $client->accessRequest($username);

// EAP-MSCHAP v2 authentication
$authenticated = $client->accessRequestEapMsChapV2($username, $password);

if ($authenticated === false) {
    // false returned on failure
    echo sprintf(
        "Access-Request failed with error %d (%s).\n",
        $client->getErrorCode(),
        $client->getErrorMessage()
    );
} else {
    // access request was accepted - client authenticated successfully
    echo "Success!  Received Access-Accept response from RADIUS server.\n";
}
// Authenticating against a RADIUS cluster (each server needs the same secret).
// Each server in the list is tried until auth success or failure.  The
// next server is tried on timeout or other error.
// Set the secret and any required attributes first.

$servers = [ 'server1.radius.domain', 'server2.radius.domain' ];
// or
$servers = gethostbynamel("radius.site.domain"); // gets list of IPv4 addresses to a given host

$authenticated = $client->accessRequestList($servers, $username, $password);
// or
$authenticated = $client->accessRequestEapMsChapV2List($servers, $username, $password);


// Setting vendor specific attributes
// Many vendor IDs are available in \Dapphp\Radius\VendorId
// e.g. \Dapphp\Radius\VendorId::MICROSOFT
$client->setVendorSpecificAttribute($vendorId, $attributeNumber, $rawValue);

// Retrieving attributes from RADIUS responses after receiving a failure or success response
$value = $client->getAttribute($attributeId);

// Get an array of all received attributes
$attributes = getReceivedAttributes();

// Debugging
// Prior to sending a request, call
$client->setDebug(true); // enable debug output on console
// Shows what attributes are sent and received, and info about the request/response