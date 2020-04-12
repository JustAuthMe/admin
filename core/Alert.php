<?php


namespace PitouFW\Core;


class Alert {
    private static function alert($type, $message) {
        $_SESSION['alert'] = [
            'type' => $type,
            'message' => $message
        ];
    }

    public static function success($message) {
        self::alert('success', $message);
    }

    public static function error($message) {
        self::alert('error', $message);
    }

    public static function handle() {
        if (!isset($_SESSION['alert']) || !is_array($_SESSION['alert']) || !isset($_SESSION['alert']['type'], $_SESSION['alert']['message'])) {
            return;
        }

        $type = $_SESSION['alert']['type'] === 'success' ? 'success' : 'danger';
        $isError = $type !== 'success';
        $message = $_SESSION['alert']['message'];
        $html = '<div class="alert alert-' . $type . '">' . ($isError ? 'Erreur : ' : '') . $message . '</div>';

        unset($_SESSION['alert']);
        return $html;
    }
}