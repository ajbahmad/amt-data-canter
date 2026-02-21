<?php
function rp($nominal) 
{
    if (is_numeric($nominal)) {
        return 'Rp ' . number_format($nominal, 0, ',', '.');    
    } else {
        return $nominal;
    }
}