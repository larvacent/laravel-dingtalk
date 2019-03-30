<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace Larva\DingTalk\Robot;

use GuzzleHttp\HandlerStack;
use Larva\Supports\Traits\HasHttpRequest;

/**
 * Class DingTalkManage
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class DingTalkRobotManage
{
    use HasHttpRequest {
        post as protected;
        get as protected;
        postJSON as protected;
        postXML as protected;
    }

    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * @var float
     */
    public $timeout = 5.0;

    /**
     * @var float
     */
    public $connectTimeout = 5.0;

    /**
     * @var bool
     */
    public $httpErrors = false;

    /**
     * @var string
     */
    public $accessToken;

    /**
     * @var string
     */
    protected $baseUri = 'https://oapi.dingtalk.com';

    /**
     * Create a new filesystem manager instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;
        $this->accessToken = $this->app['config']["services.dingtalk.robotKey"];
    }

    /**
     * 获取 accessToken
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * 设置 accessToken
     * @param string $accessToken
     * @return $this
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * 获取基础路径
     * @return string
     */
    public function getBaseUri()
    {
        return $this->baseUri;
    }

    /**
     * 设置基础路径
     * @param string $baseUri
     * @return $this
     */
    public function setBaseUri($baseUri)
    {
        $this->baseUri = $baseUri;
        return $this;
    }

    /**
     * @return HandlerStack
     */
    public function getHandlerStack()
    {
        $stack = HandlerStack::create();
        $middleware = new DingTalkRobotStack($this->accessToken);
        $stack->push($middleware);
        return $stack;
    }

    /**
     * 整体跳转ActionCard类型
     * @param string $title
     * @param string $content
     * @param string $singleURL
     * @param int $hideAvatar
     * @param int $btnOrientation
     * @param string $singleTitle
     * @return array
     */
    public function sendActionCard($title, $content, $singleURL, $hideAvatar = 0, $btnOrientation = 0, $singleTitle = '阅读原文')
    {
        $request = [
            'msgtype' => 'actionCard',
            'actionCard' => [
                'title' => $title,
                'text' => $content,
                'hideAvatar' => $hideAvatar,
                'btnOrientation' => $btnOrientation,
                'singleTitle' => $singleTitle,
                'singleURL' => $singleURL
            ],
        ];
        return $this->send($request);
    }

    /**
     * 发送MarkDown 消息
     * @param string $title
     * @param string $content
     * @param array $atMobiles
     * @param bool $isAtAll
     * @return array
     */
    public function sendMarkdown($title, $content, array $atMobiles = [], $isAtAll = false)
    {
        $request = [
            'msgtype' => 'markdown',
            'markdown' => [
                'title' => $title,
                'text' => $content,
            ],
            'at' => [
                'isAtAll' => $isAtAll
            ],
        ];
        if ($atMobiles) {
            $request['at']['atMobiles'] = $atMobiles;
        }
        return $this->send($request);
    }

    /**
     * 发送链接
     * @param string $title
     * @param string $text
     * @param string $picUrl
     * @param string $messageUrl
     * @return array
     */
    public function sendLink($title, $text, $messageUrl, $picUrl = '')
    {
        $request = [
            'msgtype' => 'link',
            'link' => [
                'title' => $title,
                'text' => $text,
                'picUrl' => $picUrl,
                'messageUrl' => $messageUrl
            ],
        ];
        return $this->send($request);
    }

    /**
     * 发送文本消息
     * @param string $content
     * @param array $atMobiles
     * @param bool $isAtAll
     * @return array
     */
    public function sendText($content, array $atMobiles = [], $isAtAll = false)
    {
        $request = [
            'msgtype' => 'text',
            'text' => [
                'content' => $content,
            ],
            'at' => [
                'isAtAll' => $isAtAll
            ],
        ];
        if ($atMobiles) {
            $request['at']['atMobiles'] = $atMobiles;
        }
        return $this->send($request);
    }

    /**
     * 发送消息
     * @param array $request
     * @return array
     */
    public function send($request)
    {
        return $this->postJSON('robot/send',$request);
    }
}