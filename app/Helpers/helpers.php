<?php

/**
 * @return string
 */
function get_register_regex(): string
{
    return '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';
}
