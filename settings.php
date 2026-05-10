<?php
header('Content-Type: application/json');

$settingsFile = 'settings.json';

// Initialize file if it doesn't exist
if (!file_exists($settingsFile)) {
    file_put_contents($settingsFile, json_encode(['override_number' => null]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read JSON from input
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Check if override_number exists in the request body
    if (isset($input) && array_key_exists('override_number', $input)) {
        $val = $input['override_number'];
        if (is_string($val)) {
            $val = trim($val);
            if ($val === '') {
                $val = null;
            }
        }
        
        $data = ['override_number' => $val];
        file_put_contents($settingsFile, json_encode($data));
        echo json_encode(['success' => true, 'override_number' => $val]);
        exit;
    }
}

// GET request or default response
$data = json_decode(file_get_contents($settingsFile), true);
echo json_encode($data);
?>
