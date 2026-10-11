<?php
/**
 * @param string $type "sukses" atau "gagal"
 * @param string $message
 */

function setFlash(string $type, string $message): void
{
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message,
    ];
}

function showFlash(): void
{
    if (!empty($_SESSION['flash'])) {
        $type = htmlspecialchars($_SESSION['flash']['type']);
        $message = htmlspecialchars($_SESSION['flash']['message']);

        echo "<div class=\"flash flash-{$type}\">{$message}</div>";

        unset($_SESSION['flash']);
    }
}