<?php

function smarty_modifier_unserialize_to_array($string)
{
    return print_r(unserialize($string),true);
}

?>