<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Novel;

class NovelController extends Controller
{
    public function chapters($novelId)
    {
        $course = Novel::findOrFail($novelId);
        $chapters = $course->chapters()->orderBy('sort')->get();

        return $chapters;
    }
}
