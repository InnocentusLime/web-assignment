<?php

require "blocks.php";

session_start_if_none();
if (is_null(get_current_user_id())) {
    respond_with_error("LOGOUT_API_NO_ACTIVE_USER");
    exit;
}

nuke_session_user();
respond_with_json_ok("LOGOUT_API_OK");