<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Backend;

use App\Models\Novel;
use App\Models\NovelChapter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CourseChapterRequest;

class NovelChapterController extends Controller
{
    public function index($courseId)
    {
        $course = Novel::findOrFail($courseId);

        $rows = $course->chapters()->orderBy('sort')->get();

        return view('backend.novelchapter.index', compact('rows', 'course'));
    }

    public function create($courseId)
    {
        $course = Novel::findOrFail($courseId);

        return view('backend.novelchapter.create', compact('course'));
    }


    public function store(CourseChapterRequest $request, $courseId)
    {
        $course = Novel::findOrFail($courseId);

        $course->chapters()->save(new NovelChapter($request->filldata()));
        flash('添加成功', 'success');

        return back();
    }

    public function edit($id)
    {
        $one = NovelChapter::findOrFail($id);
        return view('backend.novelchapter.edit', compact('one'));
    }

    public function update(CourseChapterRequest $request, $id)
    {
        $one = NovelChapter::findOrFail($id);
        $one->fill($request->filldata())->save();
        flash('编辑成功', 'success');

        return back();
    }

    public function destroy($id)
    {
        $courseChapter = NovelChapter::findOrFail($id);
        if ($courseChapter->novel_content()->count()) {
            flash('无法删除，该章节下面存在文章', 'warning');
        } else {
            $courseChapter->delete();
            flash('删除成功', 'success');
        }

        return back();
    }
}
