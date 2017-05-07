<?php

namespace Smsapp\Lib;

class ISanitize
{
    /**
     * Remove all tags and comments
     *
     * @param mixed $input
     */
    public function cleanInput($input)
    {
        $search = array(
            '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
            '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
            '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
        );

        $output = preg_replace($search, '', $input);
        return $output;
    }

    /**
     * Prepair input for cleaning
     *
     * @param mixed $input
     */
    public function sanitize($input)
    {
        if (is_array($input)) {
            foreach ($input as $var => $val) {
                $output[$var] = $this->sanitize($val);
            }
        } else {
            if (get_magic_quotes_gpc()) {
                $input = stripslashes($input);
            }
            $input = trim($input);
            $input = $this->cleanInput($input);
            $output = $input;
        }
        return $output;
    }

    /**
     * Return only digits
     *
     * @param mixed $num
     */
    public function sanitizeNum($num)
    {   
        $num = preg_replace('/\D/', '', $num);
        return $num;
    }

    /**
     * Return only letters upper and lower case, and white space
     *
     * @param mixed $name
     */
    public function sanitizeName($name)
    {
        $name = preg_replace('/[^a-zA-Z\s]/', '', $name);
        return $name;
    }

    public function filterThis($string)
    {
        if (get_magic_quotes_gpc()) {
            $string = stripslashes($string);
        }
        $string  = filter_var($string, FILTER_SANITIZE_STRING);
        return $string;
    }
}
