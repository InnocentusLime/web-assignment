<?php
require "../famework/session_utils.php";

/**
 * Just to begin the html
 * @param string $title Page title
 * @return void
 */
function begin_common_html_with_head($title = "") {
    echo "<!DOCTYPE html>";
    echo "<html><head>";
    echo "<title>$title</title>";
    echo "<link rel=\"stylesheet\" href=\"style.css\">";
    echo "</head>";
    echo "<body>";
}

/**
 * Just to end the html
 * @return void
 */
function end_common_html() {
    echo "</body>";
    echo "</html>";
}

/**
 * Does some repeatable things like adding the html opening, creating
 * a session, opening the main tag and adding a header.
 * @param string $title Page title
 * @return void
 */
function begin_common_page($title = "") {
    begin_common_html_with_head($title);
    readfile("../components/header.html");
    echo "<main>";
    session_start_if_none();
}

/**
 * Closes all the tags opened by begin_common_page
 * @return void
 */
function end_common_page() {
    echo "</main>";
    readfile("../components/footer.html");
    end_common_html();
}