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

use Illuminate\Support\Facades\Log;

class PaymentController extends FrontendController
{
    /**
     * 支付回调.
     *
     * @param $payment
     *
     * @return mixed
     */
    public function callback($payment)
    {     Log::info(111111);

        $payments = config('meedu.payment');
        if (! isset($payments[$payment])) {
            abort(404);
        }
        $handler = $payments[$payment]['handler'];

        return app()->make($handler)->callback();
    }
}
