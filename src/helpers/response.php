<?php

function e($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

function e_nl($text) {
    return nl2br(htmlspecialchars($text, ENT_QUOTES, 'UTF-8'));
}
