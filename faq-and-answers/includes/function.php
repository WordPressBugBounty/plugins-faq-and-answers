<?php
if (!defined('ABSPATH')) {
    exit;
}
function faa_is_premium()
{
    return AFAQ_HAS_PRO ? faa_fs()->can_use_premium_code() : false;  
}