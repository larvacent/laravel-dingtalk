<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace Larva\DingTalk\Robot;

use Illuminate\Support\ServiceProvider;

/**
 * Class DingTalkServiceProvider
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class DingTalkRobotServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->singleton('dingtalk-robot', function () {
            return new DingTalkRobotManage($this->app);
        });
    }
}
