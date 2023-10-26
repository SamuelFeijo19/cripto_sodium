<?php

if (!extension_loaded('sodium')) {
    die("A extensão Sodium não está habilitada.");
}

$randomBytes = sodium_crypto_secretbox_keygen();

// Converta os bytes em uma representação hexadecimal (opcional)
$randomHex = bin2hex($randomBytes);

echo "Número aleatório seguro: " . $randomHex;

?>