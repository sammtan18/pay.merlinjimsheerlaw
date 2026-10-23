<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Get data from your HTML form fields
    $name = $_POST['visitor_name'];
    $message = $_POST['visitor_message'];
    
    // 2. Put your Telegram Bot configuration here
    $botToken = "YOUR_TELEGRAM_BOT_TOKEN";
    $chatId = "YOUR_TELEGRAM_CHAT_ID";
    
    // 3. Construct your notification layout
    $text = "New Website Message:\nName: $name\nMessage: $message";
    
    // 4. Send the request to the Telegram API
    $url = "https://telegram.org" . $botToken . "/sendMessage?chat_id=" . $chatId . "&text=" . urlencode($text);
    
    // Use file_get_contents or cURL to trigger the URL
    $response = file_get_contents($url);
    
    if ($response) {
        // Redirect back to a thank you page or your original HTML page
        header("Location: index.html?status=success");
        exit();
    } else {
        echo "Error sending message to Telegram.";
    }
}
?>
