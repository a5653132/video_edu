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

use App\Models\NovelContent;
use App\Models\Novel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\NovelContentRequest;

class NovelContentController extends Controller
{
    public function index(Request $request)
    {
        $keywords = $request->input('keywords', '');

        $videos = NovelContent::with(['novel'])
            ->when($keywords, function ($query) use ($keywords) {
                return $query->where('title', 'like', "%{$keywords}%");
            })
            ->orderByDesc('published_at')
            ->select([
                'id', 'user_id', 'novel_id', 'title',
                'slug', 'charge', 'view_num',
                'short_description', 'content',
                'seo_keywords', 'seo_description',
                'published_at', 'is_show', 'created_at',
                'updated_at',
            ])
            ->paginate($request->input('page_size', 10));

        $videos->appends($request->input());

        return view('backend.novel_content.index', compact('videos'));
    }

    public function create()
    {
        $courses = Novel::all();

        return view('backend.novel_content.create', compact('courses'));
    }

    public function store(NovelContentRequest $request, NovelContent $video)
    {
        $video->fill($request->filldata())->save();
        flash('添加成功', 'success');

        return back();
    }

    public function edit($id)
    {
        $video = NovelContent::findOrFail($id);
        $courses = Novel::all();
        return view('backend.novel_content.edit', compact('video', 'courses'));
    }

    public function update(NovelContentRequest $request, $id)
    {
        $video = NovelContent::findOrFail($id);
        $video->fill($request->filldata())->save();
        flash('编辑成功', 'success');

        return back();
    }

    public function destroy($id)
    {
        NovelContent::destroy($id);
        flash('删除成功', 'success');

        return back();
    }
}
