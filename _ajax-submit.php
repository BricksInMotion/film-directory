<?php
require_once 'src/common-utils.php';

$ajax_data = escape_xss(get_json('php://input'));
