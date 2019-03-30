<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace Larva\DingTalk\Robot;

use Illuminate\Support\Facades\Facade;

/**
 * Class DingTalkRobot
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class DingTalkRobot extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'dingtalk-robot';
    }
}