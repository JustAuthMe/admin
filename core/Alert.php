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

    public static function warning($message) {
        self::alert('warning', $message);
    }

    public static function error($message) {
        self::alert('error', $message);
    }

    public static function handle() {
        if (!isset($_SESSION['alert']) || !is_array($_SESSION['alert']) || !isset($_SESSION['alert']['type'], $_SESSION['alert']['message'])) {
            return;
        }

        $type = $_SESSION['alert']['type'];
        $theme = $type === 'error' ? 'danger' : ($type === 'warning' ? 'warning' : ($type === 'success' ? 'success' : 'info'));
        $isError = $type === 'error';
        $isWarning = $type === 'warning';
        $message = $_SESSION['alert']['message'];
        $html = '<div class="alert alert-' . $theme . ' mb-5">' . ($isError ? 'Error : ' : ($isWarning ? 'Warning : ' : '')) . $message . '</div>';

        unset($_SESSION['alert']);
        return $html;
    }
}