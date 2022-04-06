<?php

defined('BASEPATH') or exit('No direct script access allowed');

function json_output($statusCode, $response)
{
    $CI = &get_instance();
    $CI->output->set_status_header($statusCode);
    $CI->output->set_content_type('application/json');
    $CI->output->set_output(json_encode($response));
}
