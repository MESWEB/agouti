<?php

use Hleb\Constructor\Handlers\Request;

class Integration
{
    // Captcha v2
    private static function callApi($params)
    {
        $api_url = 'https://www.google.com/recaptcha/api/siteverify';

        // https://github.com/php-mod/curl
        if (!function_exists('curl_init')) {

            $data = @file_get_contents($api_url . '?' . http_build_query($params));
        } else {

            $curl = curl_init();

            if (strpos($api_url, 'https') !== false) {
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            }
            curl_setopt($curl, CURLOPT_URL, $api_url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_TIMEOUT, 5);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);

            $data = curl_exec($curl);

            curl_close($curl);
        }

        if (!$data) {
            return false;
        }
        $data = json_decode($data, true);

        return !empty($data['success']);
    }

    // Проверка в AuthControllerе
    public static function checkCaptchaCode()
    {
        $response = Request::getPost('g-recaptcha-response');

        if (!$response) {
            return false;
        }

        return self::callApi(array(
            'secret'   => Config::get('general.private_key'),
            'response' => $response,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ));
    }

    // Discord
    public static function AddWebhook($text, $title, $url)
    {
        $text = strip_tags($text, '<p>');
        $text = preg_replace(array('/(<p>)/', '(<\/p>)'), array('', '\n'), $text);

        // Проверяем имя бота и YOUR_WEBHOOK_URL
        if (!$webhookurl = Config::get('general.webhook_url')) {
            return false;
        }
        if (!$usernamebot = Config::get('general.name_bot')) {
            return false;
        }

        $content    = sprintf(Translate::get('content.added'), Translate::get('post'));
        $color      = hexdec("3366ff");

        // Формируем даты
        $timestamp  = date("c", strtotime("now"));

        $json_data  = json_encode([

            // Сообщение над телом
            "content" => $content,

            // Ник бота который отправляет сообщение
            "username" => $usernamebot,

            // URL Аватара.
            // Можно использовать аватар загруженный при создании бота
            "avatar_url" => Config::get('general.icon_url'),

            // Преобразование текста в речь
            "tts" => false,

            // Загрузка файла
            // "file" => "",

            // Массив Embeds
            "embeds" => [
                [
                    // Заголовок
                    "title" => $title,

                    // Тип Embed Type, не меняем
                    "type" => "rich",

                    // Описание
                    "description" => $text,

                    // Ссылка в заголовке url
                    "url" => Config::get('meta.url') . $url,

                    // Таймштамп, обязательно в формате ISO8601
                    "timestamp" => $timestamp,

                    // Цвет границы слева, в HEX
                    "color" => $color,

                    // Подпись и аватар в подвале sitename
                    "footer" => [
                        "text" => Config::get('general.name_bot'),
                        "icon_url" => Config::get('general.icon_url'),
                    ],
                ]
            ]

        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $ch = curl_init($webhookurl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $response = curl_exec($ch);
        // echo $response;
        curl_close($ch);
    }
}
