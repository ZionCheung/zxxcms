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

    /**
     * @param string $username 激活的账号
     * @param string $password 激活密码
     * @param string $email 邮箱
     * @param string $ip 添加IP
     * @param string $link 激活链接
     * @return string
     * # 激活邮件模版
     */
    public static function activationMailTemplate (string $username, string $password, string $email, string $ip, string $link) : string
    {
        $projectName = Config::get('developer.project-name'); # 本站主题
        $owner = Config::get('developer.developer-eng-username'); # 本站所有者
        $ownerEmail = Config::get('developer.developer-email'); # 本站所有者邮箱
        $part = '<div style="background-color:#ECECEC; padding: 35px;">';
        $part .= '<table cellpadding="0" align="center" style="width: 600px; margin: 0px auto; text-align: left; position: relative; border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-right-radius: 5px; border-bottom-left-radius: 5px; font-size: 14px; font-family:微软雅黑, 黑体; line-height: 1.5; box-shadow: rgb(153, 153, 153) 0px 0px 5px; border-collapse: collapse; background-position: initial initial; background-repeat: initial initial;background:#fff;"><tbody><tr>';
        $part .= '<th valign="middle" style="height: 25px; line-height: 25px; padding: 15px 35px; border-bottom-width: 1px; border-bottom-style: solid; border-bottom-color: #42a3d3; background-color: #49bcff; border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-right-radius: 0px; border-bottom-left-radius: 0px;"><font face="微软雅黑" size="5" style="color: rgb(255, 255, 255); ">注册成功! (恭喜您,成为'.$projectName.'的管理员)</font></th></tr>';
        $part .= '<tr><td><div style="padding:25px 35px 40px; background-color:#fff;"><h2 style="margin: 5px 0px; "><font color="#333333" style="line-height: 20px; "><font style="line-height: 22px; " size="4">';
        $part .= '亲爱的 '.$username.'</font></font></h2>';
        $part .= '<p>首先感谢您加入本站,您的账号已注册成功,请认真核对你的账号信息,准确无误后,点击下面的链接激活账号后,才能正常使用哦!<br>
                        您的账号：<b>'.$username.'</b><br>
                        您的密码：<b>'.$password.'</b><br>
                        您的邮箱：<b>'.$email.'</b><br>
                        您注册时的日期：<b>'.date('Y-m-d H:i:s', time()).'</b><br>
                        您注册时的IP：<b>'.$ip.'</b><br>
                        激活链接：<b>'.$link.'</b><br>
                        由于管理员权限巨大,当您在使用本网站时，遵守当地法律法规,并认真查阅本网站的使用条款,合理合法的进行网站的管理工作。<br>
                        如果您有什么疑问可以联系本站所有人，Name:'.$owner.' Email: '.$ownerEmail.'</p>
                    <p align="right">'.$projectName.'管理系统</p>
                    <p align="right">'.date('Y年m月d日 H时i分s秒',time()).'</p>';
        $part .= '<div style="width:700px;margin:0 auto;"><div style="padding:10px 10px 0;border-top:1px solid #ccc;color:#747474;margin-bottom:20px;line-height:1.3em;font-size:12px;"><p>此为系统邮件，请勿回复<br> 若非本人操作,请忽略本邮件</p><p>激活链接有效期为24小时,请尽快激活,超时请联系网站管理者,重新获取验证链接!</p></div></div></div></td></tr></tbody></table></div>';
        return $part;
    }
}
