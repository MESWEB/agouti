<?php

use App\Models\User\{SettingModel, UserModel};
use JacksonJeans\Mail;
use JacksonJeans\MailException;

class SendEmail
{
    // https://github.com/JacksonJeans/php-mail
    public static function mailText($uid, $type, array $variables = [])
    {
        $u_data = UserData::get();
        $user   = UserModel::getUser($uid, 'id');

        require_once __DIR__ . '/../Language/mail/' . $u_data['lang'] . '.php';

        if (is_null($uid)) {
            return false;
        }

        if ($type == 'appealed') {
            $setting = SettingModel::getNotifications($uid);
            if ($setting['setting_email_appealed'] == 0) {
                return true;
            }
        }

        $text_footer    = sprintf($data['footer'], Config::get('meta.url'));
        $user_email     = $user['email'];
        $url            = Config::get('meta.url');

        switch ($type) {
            case 'changing.password':
                $subject    = sprintf($data['changing.password.subject'], Config::get('meta.name'));
                $message    = sprintf($data['changing.password.message'], $url . $variables['newpass_link']);
                break;
            case 'appealed':
                $subject    = sprintf($data['appealed.subject'], Config::get('meta.name'));
                $message    = sprintf($data['appealed.message'], $url . getUrlByName('notifications'));
                break;
            case 'activate.email':
                $subject    = sprintf($data['activate.email.subject'], Config::get('meta.name'));
                $message    = sprintf($data['activate.email.message'], $url . $variables['link']);
                break;
            case 'invite.reg':
                $user_email = $variables['invitation_email'];
                $subject    = sprintf($data['invite.reg.subject'], Config::get('meta.name'));
                $message    = sprintf($data['invite.reg.message'], $url . $variables['link']);
                break;
            default:
                $user_email = $variables['email'];
                $subject    = sprintf($data['test.subject'], Config::get('meta.name'));
                $message    = $data['test.message'];
                break;
        }

        self::send($user_email, $subject, $message . $text_footer);

        return true;
    }

    public static function send($email, $subject = '', $message = '')
    {
        if (Config::get('general.smtp')) {
            $mail = new Mail('smtp', [
                'host'      => 'ssl://' . Config::get('general.smtphost'),
                'port'      => Config::get('general.smtpport'),
                'username'  => Config::get('general.smtpuser'),
                'password'  => Config::get('general.smtppass')
            ]);

            $mail->setFrom(Config::get('general.smtpuser'))
                ->setTo($email)
                ->setSubject($subject)
                ->setHTML($message, true)
                ->send();
        } else {
            $mail = new Mail();
            $mail->setFrom(Config::get('general.email'), Config::get('meta.title'));

            $mail->to($email)
                ->setSubject($subject)
                ->setHTML($message, true)
                ->send();
        }
    }
}
