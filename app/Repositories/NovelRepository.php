<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Repositories;

use Exception;
use App\Models\Order;
use App\Models\OrderGoods;
use Illuminate\Support\Facades\DB;

class NovelRepository
{
    public function createOrder($user, $course)
    {
        if ($user->joinNovels()->whereId($course->id)->first()) {
            return '该数据已购买啦';
        }

        DB::beginTransaction();
        try {
            // 创建订单
            $order = $user->orders()->save(new Order([
                'charge' => $course->charge,
                'status' => Order::STATUS_UNPAY,
                'order_id' => gen_order_no($user),
            ]));
            // 关联商品
            $order->goods()->save(new OrderGoods([
                'user_id' => $user->id,
                'num' => 1,
                'charge' => $course->charge,
                'goods_id' => $course->id,
                'goods_type' => OrderGoods::GOODS_TYPE_BOOK,
            ]));


            DB::commit();

            return $order;
        } catch (Exception $exception) {
            DB::rollBack();
            exception_record($exception);

            return '系统出错';
        }
    }
}
