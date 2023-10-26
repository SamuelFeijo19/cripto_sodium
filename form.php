<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $key = sodium_crypto_secretbox_keygen();
    $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);

    $formInputData = $_POST["data"];

    $encryptedData = sodium_crypto_secretbox($formInputData, $nonce, $key);

    $_SESSION["session_token"] = base64_encode($nonce . $encryptedData);

    $sessionToken = $_SESSION["session_token"];

    if (!empty($sessionToken)) {
        $decodedToken = base64_decode($sessionToken);
        $nonce = substr($decodedToken, 0, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $encryptedData = substr($decodedToken, SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);

        $decryptedData = sodium_crypto_secretbox_open($encryptedData, $nonce, $key);

        if ($decryptedData !== false) {
            // echo "Dados do formulário antes da descriptografia: " . $encryptedData . "<br>";

            echo "Dados do formulário após a descriptografia: " . $decryptedData;
        } else {
            echo "Erro na descriptografia. Os dados podem ter sido adulterados.";
        }
    } else {
        echo "Token de sessão não encontrado na sessão.";
    }
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulário com Token de Sessão</title>
</head>
<body>
    <form method="post" action="form.php">
        <input type="text" name="data" placeholder="Dados do Formulário" required>
        <input type="submit" value="Enviar">
    </form>
</body>
</html>
