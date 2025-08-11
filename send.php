<?php
// ====== Token Bot Saya ======
$token   = "7986605328:AAEdV2eAQl6nYKSUk7EFGMmZaFUTrHspT5A";
$chat_id = "7378003525";
// =====================================

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fromName = trim($_POST['fromName'] ?? '');
    $message  = trim($_POST['message'] ?? '');

    if ($message === '') {
        echo json_encode(["status" => "error", "msg" => "Pesan tidak boleh kosong"]);
        exit;
    }

    // Format pesan
    $text = $message;
    if ($fromName !== '') {
        $text .= "\n\n— " . $fromName;
    }

    // Kirim ke Telegram
    $url = "https://api.telegram.org/bot{$token}/sendMessage";
    $data = [
        'chat_id' => $chat_id,
        'text'    => $text,
        'parse_mode' => 'HTML'
    ];

    $options = [
        "http" => [
            "header"  => "Content-Type: application/x-www-form-urlencoded\r\n",
            "method"  => "POST",
            "content" => http_build_query($data),
        ]
    ];

    $context  = stream_context_create($options);
    $result   = file_get_contents($url, false, $context);

    if ($result === FALSE) {
        echo json_encode(["status" => "error", "msg" => "Gagal mengirim pesan"]);
    } else {
        echo json_encode(["status" => "success", "msg" => "Pesan berhasil dikirim"]);
    }
}
?>