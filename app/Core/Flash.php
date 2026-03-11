<?php

namespace Core;

class Flash
{
    public function set(string $status, string $content): void
    {
        $_SESSION['flash'] = serialize(array('status' => $status, 'content' => $content));
    }

    // ?string declaration for function output type means output is either string or null
    public function get(): ?array
    {
        if (!isset($_SESSION['flash'])) {
            return null;
        }

        $flash_message = unserialize($_SESSION['flash']);
        unset($_SESSION['flash']);

        if (!is_array($flash_message) || count($flash_message) < 1 || count($flash_message) > 2) {
            return null;
        }

        return $flash_message;
    }
}
