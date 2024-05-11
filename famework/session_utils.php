<?php

/**
 * Populates the session with default values
 * @return void
 */
function session_defaults() {

}

/**
 * Makes sure the session is setup
 * @return void
 */
function session_start_if_none() {
    if (isset($_SESSION)) {
        return;
    }

    session_start();
    session_defaults();
}