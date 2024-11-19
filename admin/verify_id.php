<?php
session_start();
include('includes/dbconnection.php');

if (strlen($_SESSION['hlmsaid']) == 0) {
    header('location:logout.php');
    exit();
}

// Get user ID from URL
$userID = $_GET['id'];

// Fetch Aadhaar from the database
$query = $dbh->prepare("SELECT Aadhaar FROM tbluser WHERE ID = :id");
$query->bindParam(':id', $userID, PDO::PARAM_INT);
$query->execute();
$result = $query->fetch(PDO::FETCH_ASSOC);
$aadhaar = $result['Aadhaar'];

if (!$aadhaar) {
    echo "Aadhaar not found for this user.";
    exit();
}

// SOAP endpoint URL and WSDL
$wsdl = "https://apis-uat.experian.co.za/IDVService?wsdl";

// SOAP options
$options = [
    'trace' => true, // Enables tracing for debugging
    'exceptions' => true, // Throws exceptions on errors
];

try {
    // Create a new SOAP client
    $client = new SoapClient($wsdl, $options);

    // Prepare the SOAP request parameters based on the XML structure
    $params = [
        'Auth' => [
            'Username' => '1234-1',  // Replace with correct Username
            'Password' => 'devtest'  // Replace with correct Password
        ],
        'SystemSettings' => [
            'Version' => '1.0',
            'Origin'  => 'SOAP_UI' // Origin fixed for testing
        ],
        'SearchCriteria' => [
            'IdentityNumber' => $aadhaar,
            'IdentityType'   => 'SID', // Fixed SID for South African ID
            'WantPhoto'      => 'Y'    // Always requests photo as 'Y'
        ]
    ];

    // Make the SOAP request
    $response = $client->__soapCall('RequestIDVInfo', [$params]);

    // Redirect to display page with serialized response for readability
    header("Location: display_verification.php?response=" . urlencode(serialize($response)));
    exit();

} catch (SoapFault $fault) {
    // Display the error code and message for debugging
    echo "<p>Error: {$fault->faultcode}, {$fault->faultstring}</p>";
    exit();
}
