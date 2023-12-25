<?php

// This file contains general-purpose functions:

// Function to escape HTML for output
function escape_html($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Function to format a date
function format_date($dateString) {
    $date = new DateTime($dateString);
    return $date->format('F j, Y, g:i a');
}

?>