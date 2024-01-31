<?php


/**
 * print_r2
 *
 * @param  mixed $arr
 * @return void
 */
function print_r2($arr)
{
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}


/**
 * render_copyright
 *
 * @return void
 */
function render_copyright()
{
    $year = date("Y");

    echo " $year Otto Wiman";
}

?>