<?php
    function sanitize($data) {
        return htmlspecialchars(trim($data));
    }

    function redirect($route) {
        header("Location: /index.php?route=" . $route);
        exit();
    }

    function generateUniqueId($items) {
        if (empty($items)) return 1;
        return max(array_column($items, 'id')) + 1;
    }

    function validateDate($date, $format = 'Y-m-d H:i:s') {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
?>