<?php
declare(strict_types=1);

namespace Vokuro\Plugins\Auth;

use Phalcon\Di\Injectable;
use Vokuro\Models\FailedLogins;
use Vokuro\Models\RememberTokens;
use Vokuro\Models\SuccessLogins;
use Vokuro\Models\Users;

class Auth extends Injectable
{
    /**
     * 检查用户凭据
     *
     * @param array $credentials
     * @throws Exception
     */
    public function check(array $credentials)
    {
        // 检查用户是否存在
        $user = Users::findFirstByEmail($credentials['email']);
        if ($user == false) {
            $this->registerUserThrottling(0);
            throw new Exception('错误的电子邮箱/密码组合');
        }

        // 检查密码
        if (!$this->security->checkHash($credentials['password'], $user->password)) {
            $this->registerUserThrottling($user->id);
            throw new Exception('错误的电子邮箱/密码组合');
        }

        // 检查用户是否被标记
        $this->checkUserFlags($user);
        // 登录成功
        $this->saveSuccessLogin($user);

        // 如果用户选择记住账号则保存信息
        if (isset($credentials['remember'])) {
            $this->createRememberEnvironment($user);
        }

        $this->session->set('auth-identity', [
            'id' => $user->id,
            'name' => $user->name,
            'profile' => $user->profile->name
        ]);
    }

    /**
     * 保存用户登录成功的信息
     *
     * @param Users $user
     * @throws Exception
     */
    public function saveSuccessLogin(Users $user)
    {
        $successLogin = new SuccessLogins();
        $successLogin->users_id = $user->id;
        $successLogin->ip_address = $this->request->getClientAddress();
        $successLogin->user_agent = $this->request->getUserAgent();
        if (!$successLogin->save()) {
            throw new Exception((string) $successLogin->getMessages()[0]);
        }
    }

    /**
     * 登录节流用于降低暴力破解和攻击
     *
     * @param integer $userId
     */
    public function registerUserThrottling($userId)
    {
        $failedLogin = new FailedLogins();
        $failedLogin->users_id = $userId;
        $failedLogin->ip_address = $this->request->getClientAddress();
        $failedLogin->attempted = time();
        $failedLogin->save();

        $attempts = FailedLogins::count([
            'ip_address = ?0 AND attempted > ?1',
            'bind' => [
                $this->request->getClientAddress(),
                time() - 3600 * 6
            ]
        ]);

        switch ($attempts) {
            case 1:
            case 2:
                break;
            case 3:
            case 4:
                sleep(2);
                break;
            default:
                sleep(4);
                break;
        }
    }

    /**
     * 创建记住我的环境设置相关的 cookie 和生成令牌
     *
     * @param Users $user
     */
    public function createRememberEnvironment(Users $user)
    {
        $userAgent = $this->request->getUserAgent();
        $token = md5($user->email . $user->password . $userAgent);

        $remember = new RememberTokens();
        $remember->users_id = $user->id;
        $remember->token = $token;
        $remember->user_agent = $userAgent;

        if ($remember->save() != false) {
            $expire = time() + 86400 * 8;
            $this->cookies->set('RMU', $user->id, $expire);
            $this->cookies->set('RMT', $token, $expire);
        }
    }

    /**
     * 检查 cookies 中是否有 RMU
     *
     * @return boolean
     */
    public function hasRememberMe()
    {
        return $this->cookies->has('RMU');
    }

    /**
     * 使用 cookies 中的信息登录
     *
     * @return \Phalcon\Http\ResponseInterface
     */
    public function loginWithRememberMe()
    {
        $userId = $this->cookies->get('RMU')->getValue();
        $cookieToken = $this->cookies->get('RMT')->getValue();

        $user = Users::findFirstById($userId);
        if ($user) {
            $userAgent = $this->request->getUserAgent();
            $token = md5($user->email . $user->password . $userAgent);

            if ($cookieToken == $token) {
                $remember = RememberTokens::findFirst([
                    'users_id = ?0 AND token = ?1',
                    'bind' => [
                        $user->id,
                        $token
                    ]
                ]);
                if ($remember) {
                    if (((time() - $remember->created_at) / (86400 * 8)) < 8) {
                        $this->checkUserFlags($user);

                        $this->session->set('auth-identity', [
                            'id' => $user->id,
                            'name' => $user->name,
                            'profile' => $user->profile->name
                        ]);

                        $this->saveSuccessLogin($user);

                        return $this->response->redirect('users');
                    }
                }
            }
        }

        $this->cookies->get('RMU')->delete();
        $this->cookies->get('RMT')->delete();

        return $this->response->redirect('session/login');
    }

    /**
     * 检查用户是否被 banned/inactive/suspended
     *
     * @param Users $user
     * @throws Exception
     */
    public function checkUserFlags(Users $user)
    {
        if ($user->active != 'Y') {
            throw new Exception('用户处于非活动状态');
        }

        if ($user->banned != 'N') {
            throw new Exception('该用户被禁止');
        }

        if ($user->suspended != 'N') {
            throw new Exception('用户被挂起');
        }
    }

    /**
     * 返回当前用户名称
     *
     * @return string
     */
    public function getIdentity(): string
    {
        $identity = $this->session->get('auth-identity');

        return $identity['name'];
    }
}
