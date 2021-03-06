<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Frontend;

use Exception;
use App\Models\SmsRecord;
use Overtrue\EasySms\EasySms;
use App\Http\Requests\Frontend\SmsSendRequest;
use Illuminate\Support\Facades\Auth;

class SmsController extends FrontendController
{
    public function send(SmsSendRequest $request)
    {
        $data = $request->filldata();

        $method = 'send'.$data['method'];
        try {
            throw_if(! method_exists($this, $method), new Exception('参数错误'));

            return $this->{$method}($data['mobile']);
        } catch (Exception $exception) {
            exception_record($exception);

            return exception_response($exception, '短信验证码发送失败');
        }
    }

    public function sendRegister($mobile)
    {
        return $this->sendHandler($mobile, 'sms_register', 'register');
    }

    public function sendPasswordReset($mobile)
    {
        return $this->sendHandler($mobile, 'sms_password_reset', 'password_reset');
    }

    public function sendMobileBind($mobile)
    {
        return $this->sendHandler($mobile, 'sms_mobile_bind', 'mobile_bind');
    }

    /**
     * 发送验证码逻辑.
     *
     * @param $mobile
     * @param $sessionKey
     * @param $templateId
     *
     * @return array
     *
     * @throws \Overtrue\EasySms\Exceptions\InvalidArgumentException
     * @throws \Overtrue\EasySms\Exceptions\NoGatewayAvailableException
     */
    protected function sendHandler($mobile, $sessionKey, $templateId)
    {
        $code = mt_rand(1000, 9999);
        //$code = 1234;
        session([$sessionKey => $code]);
        $config = config('sms_new');

        $easySms = new EasySms($config);
        $data = [
            'template' => 'SMS_24850304',
            'data' => [
                'verify' => $code,
                'name' => '用户',
                'intro' => '呢！'
            ],
        ];

        $sendResponse = $easySms->send($mobile, $data);
        // Log
        SmsRecord::createData($mobile, $data, $sendResponse);
	
	
        return $this->success('验证码发送成功');
    }
}
