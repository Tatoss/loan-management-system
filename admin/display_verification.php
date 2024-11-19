<?php
// Start session
session_start();

// Check if the response is set in the URL
if (!isset($_GET['response'])) {
    echo "No data available for this ID verification.";
    exit();
}

// Unserialize the SOAP response
$response = unserialize(urldecode($_GET['response']));

// Check if there was an error in the response
if (isset($response->BureauResponse->ResponseStatus) && $response->BureauResponse->ResponseStatus === 'Failure') {
    echo "<p><strong>Error:</strong> " . htmlspecialchars($response->BureauResponse->ErrorDescription) . "</p>";
    exit();
}

// Check if the response has the correct structure for valid data
if (isset($response->BureauResponse->ReturnData->IDVerificationDataBlock)) {
    $data = $response->BureauResponse->ReturnData->IDVerificationDataBlock;

    // Display the response in a readable format
    echo "<h2>ID Verification Result</h2>";
    echo "<p><strong>Transaction ID:</strong> " . htmlspecialchars($data->TransNo) . "</p>";
    echo "<p><strong>Identity Number:</strong> " . htmlspecialchars($data->IdentityNumber) . "</p>";
    echo "<p><strong>Name:</strong> " . htmlspecialchars($data->Name) . "</p>";
    echo "<p><strong>Surname:</strong> " . htmlspecialchars($data->Surname) . "</p>";
    echo "<p><strong>Smart Card Issued:</strong> " . htmlspecialchars($data->SmartCardIssued) . "</p>";
    echo "<p><strong>Date of ID Issued:</strong> " . htmlspecialchars($data->DateOfIdIssued) . "</p>";
    echo "<p><strong>ID Sequence No:</strong> " . htmlspecialchars($data->IdSeqNo) . "</p>";
    echo "<p><strong>Deceased:</strong> " . htmlspecialchars($data->Deceased) . "</p>";
    echo "<p><strong>Date of Deceased:</strong> " . htmlspecialchars($data->DateOfDeceased) . "</p>";
    echo "<p><strong>ID Blocked:</strong> " . htmlspecialchars($data->IdnBlocked) . "</p>";
    echo "<p><strong>Marital Status:</strong> " . htmlspecialchars($data->MaritalStatus) . "</p>";
    echo "<p><strong>Date of Marriage:</strong> " . htmlspecialchars($data->DateOfMarriage) . "</p>";
    echo "<p><strong>On HANIS:</strong> " . htmlspecialchars($data->OnHanis) . "</p>";
    echo "<p><strong>On NPR:</strong> " . htmlspecialchars($data->OnNpr) . "</p>";
    echo "<p><strong>Birthplace Country Code:</strong> " . htmlspecialchars($data->BirthPlaceCountryCode) . "</p>";

    // Decode and display the photo if available
    if (!empty($data->Photo)) {
        echo "<p><strong>Photo:</strong> <br><img src='data:image/jpeg;base64," . htmlspecialchars($data->Photo) . "' alt='ID Photo' /></p>";
    }

} else {
    echo "<p>Failed to retrieve valid data from the API response.</p>";
}
?>
