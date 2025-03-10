<?php

class Validation
{
    public static function Email($email, $redirect)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            addMsg('email.correctness', 'error');
            redirect($redirect);
        }
        return true;
    }

    public static function Length($name, $content, $min, $max, $redirect)
    {
        if (getStrlen($name) < $min || getStrlen($name) > $max) {
            $text = sprintf(Translate::get('string.length'), '«' . $content . '»', $min, $max);
            addMsg($text, 'error');
            redirect($redirect);
        }
        return true;
    }

    public static function Url($url, $text, $redirect)
    {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {

            $text = sprintf(Translate::get('url.correctness'), '«' . $url . '»');
            addMsg($text, 'error');
            redirect($redirect);
        }
        return true;
    }

    public static function Slug($slug, $text, $redirect)
    {
        if (!preg_match('/^[a-zA-Z0-9-]+$/u', $slug)) {

            $text = sprintf(Translate::get('slug.correctness'), '«' . $text . '»');
            addMsg($text, 'error');
            redirect($redirect);
        }
        return true;
    }
}
