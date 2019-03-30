<?php
/**
 * @copyright Copyright (c) 2018 Jinan Larva Information Technology Co., Ltd.
 * @link http://www.larvacent.com/
 * @license http://www.larvacent.com/license/
 */

namespace Larva\DingTalk\Robot;

use Psr\Http\Message\RequestInterface;

/**
 * Class DingTalkRobotStack
 *
 * @author Tongle Xu <xutongle@gmail.com>
 */
class DingTalkRobotStack
{
    /** @var array Configuration settings */
    private $access_token = '';

    /**
     * constructor.
     * @param string $accessToken
     */
    public function __construct($accessToken)
    {
        $this->access_token = $accessToken;
    }

    /**
     * Called when the middleware is handled.
     *
     * @param callable $handler
     *
     * @return \Closure
     */
    public function __invoke(callable $handler)
    {
        return function ($request, array $options) use ($handler) {
            $request = $this->onBefore($request);
            return $handler($request, $options);
        };
    }

    /**
     * 请求前调用
     * @param RequestInterface $request
     * @return RequestInterface
     */
    private function onBefore(RequestInterface $request)
    {
        $query = \GuzzleHttp\Psr7\parse_query($request->getUri()->getQuery());
        $query['access_token'] = $this->access_token;
        $request = \GuzzleHttp\Psr7\modify_request($request, ['body' => $request->getBody()->getContents(), 'query' => http_build_query($query)]);
        return $request;
    }
}