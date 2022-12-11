<?php
declare(strict_types = 1);

namespace Vokuro\Plugins\Mail;

use Phalcon\Di\Injectable;
use Phalcon\Mvc\View;
use Swift_Mailer;
use Swift_Message as Message;
use Swift_SmtpTransport as Smtp;

class Mail extends Injectable
{
    /**
     * 根据预定义的模板发送电子邮件
     * 
     * @param array  $to
     * @param string $subject
     * @param string $name
     * @param array  $params
     */
    public function send($to, $subject, $name, $params)
    {
        // 设置
        $mailSettings = $this->config->mail;
        $template = $this->getTemplate($name, $params);

        // 创建信息
        $message = new Message();
        $message->setSubject($subject)->setTo($to)->setFrom([
            $mailSettings->fromEmail => $mailSettings->fromName
        ])->setBody($template, 'text/html');

        $transport = new Smtp($mailSettings->smtp->server, $mailSettings->smtp->port, $mailSettings->smtp->security);
        $transport->setUsername($mailSettings->smtp->username)->setPassword($mailSettings->smtp->password);

        return (new Swift_Mailer($transport))->send($message);
    }

    /**
     * 应用在电子邮件中使用的模板
     * 
     * @param string $name
     * @param array  $params
     */
    public function getTemplate(string $name, array $params)
    {
        $parameters = array_merge([
            'publicUrl' => $this->config->application->publicUrl
        ], $params);

        return $this->view->getRender('emailTemplates', $name, $parameters, function (View $view) {
            $view->setRenderLevel(View::LEVEL_LAYOUT);
        });
    }
}
