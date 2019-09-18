<?php

if(!function_exists('filterData'))
    {
      function filterData(&$str)
      {
          $str = preg_replace("/\t/", "\\t", $str);
          $str = preg_replace("/\r?\n/", "\\n", $str);
          if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
      }
    }
   
?>