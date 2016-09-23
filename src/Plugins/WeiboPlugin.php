<?php
/**
 * Created by PhpStorm.
 * User: leo108
 * Date: 2016/9/22
 * Time: 10:53
 */

namespace Leo108\CASServer\OAuth\Weibo\Plugins;

use Leo108\CASServer\OAuth\OAuthUser;
use Leo108\CASServer\OAuth\Plugin;
use Overtrue\Socialite\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class WeiboPlugin extends Plugin
{
    /**
     * WeiboPlugin constructor.
     */
    public function __construct()
    {
        parent::__construct(
            'weibo_id',
            '',
            [
                'cn' => '微博',
                'en' => 'Weibo',
            ]
        );
    }

    /**
     * @param Request $request
     * @param string  $callback
     * @return RedirectResponse
     */
    public function gotoAuthUrl(Request $request, $callback)
    {
        return app('cas.server.weibo')->setRequest($request)->redirect($callback);
    }

    /**
     * @param Request $request
     * @return OAuthUser
     */
    public function getOAuthUser(Request $request)
    {
        /* @var User $user */
        $user      = app('cas.server.weibo')->setRequest($request)->user();
        $oauthUser = new OAuthUser();
        $oauthUser->setId($user->getId())
            ->setName($user->getName())
            ->setAvatar($user->getAvatar())
            ->setOriginal($user->getOriginal())
            ->setToken($user->getToken()->getToken())
            ->addBind($this->fieldName, $user->getId());

        return $oauthUser;
    }
}
