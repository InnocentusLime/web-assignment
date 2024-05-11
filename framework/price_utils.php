<?php

/**
 * Formats the price into the fancy $X.YY format
 * @param int $price Price in cents
 * @return string
 */
function format_price($price) {
    $dollars = intdiv($price, 100);
    $cents = $price % 100;

    return sprintf("$%d.%02d", $dollars, $cents);
}