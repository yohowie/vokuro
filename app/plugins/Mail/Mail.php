<?php
declare(strict_types = 1);

namespace Vokuro\Plugins\Mail;

use Phalcon\Di\Injectable;
use Phalcon\Mvc\View;
use PHPMailer\PHPMailer\PHPMailer;

class Mail extends Injectable
{
    /**
     * @var PHPMailer
     */
    private $mailer;

    public function registerMailer($config): void
    {
        $this->mailer = new PHPMailer(true);
        $this->mailer->isSMTP();
        $this->mailer->isHTML(true);
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mailer->CharSet = PHPMailer::CHARSET_UTF8;
        $this->mailer->SMTPAuth = true;

        $this->mailer->setFrom($config['fromEmail'], $config['fromName']);
        $this->mailer->Host = $config['server'];
        $this->mailer->Port = $config['port'];
        $this->mailer->Username = $config['username'];
        $this->mailer->Password = $config['password'];
    }
    /**
     * 根据预定义的模板发送电子邮件
     *
     * @param array  $to
     * @param string $subject
     * @param string $name
     * @param array  $params
     */
    public function send(array $to, $subject, $name, $params): void
    {
        $this->mailer->Subject = $subject;
        foreach ($to as $key => $val) {
            $this->mailer->addAddress($key, $val);
        }
        $this->mailer->Body = $this->getTemplate($name, $params);;

        $this->mailer->send();
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
