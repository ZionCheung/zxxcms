<?php
/**
 * User: ZionCheung.
 * Date: 2019-09-25
 * Project: zxxcms
 * Class: SendMail.php
 */
namespace lib;

use PHPMailer\PHPMailer\PHPMailer;
use think\Config;

class SendMail
{
    protected $toMail;
    protected $toName;
    protected $subject;
    protected $content;
    protected $attachment = null;
    private $charset;
    private $smtpSecure = 'ssl';
    private $host;
    private $port = 465;
    private $username;
    private $password;

    # 构建邮件参数
    public function __construct($toMail, $toName, $subject, $conent, $attachment = null)
    {
        $this ->charset = Config::get('mail.mail-charset');
        $this ->smtpSecure = Config::get('mail.mail-smtp-secure');
        $this ->host = Config::get('mail.mail-host');
        $this ->port = Config::get('mail.mail-port');
        $this ->username = Config::get('mail.mail-username');
        $this ->password = Config::get('mail.mail-password');
        $this ->toMail = trim($toMail);
        $this ->toName = $toName;
        $this ->subject = $subject;
        $this ->content = $conent;
        $this ->attachment = $attachment;
    }

    # 执行发送邮件
    public function sendMailAction ()
    {
        $mail = new PHPMailer();
        $mail ->CharSet = $this->charset; #字符集防乱码
        $mail ->IsSMTP();  #设定使用SMTP服务
        $mail ->SMTPDebug = 0; #SMTP调试功能 0=关闭 1 = 错误和消息 2 = 消息
        $mail ->SMTPAuth = true; #启用 SMTP 验证功能
        $mail ->SMTPSecure = $this->smtpSecure; #使用安全协议
        $mail ->Host = $this->host; # SMTP 服务器
        $mail ->Port = $this->port; # SMTP服务器的端口号
        $mail ->Username = $this->username; # SMTP服务器用户名
        $mail ->Password = $this->password; # SMTP服务器密码
        $mail ->SetFrom($this->username, 'zxxcms'); #
        $replyEmail = ''; # 留空则为发件人EMAIL
        $replyName = '';  # 回复名称（留空则为发件人名称）
        $mail ->AddReplyTo($replyEmail, $replyName);
        $mail ->Subject = $this->subject;
        $mail->MsgHTML($this->content);
        $mail ->AddAddress($this->toMail, $this->toName);
        if (is_array($this->attachment)) { # 添加附件
            foreach ($this->attachment as $file) {
                is_file($file) && $mail->AddAttachment($file);
            }
        }
        return $mail->Send() ? true : $mail->ErrorInfo;
    }
}
