<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Requests\Backend;

use Overtrue\Pinyin\Pinyin;
use Illuminate\Foundation\Http\FormRequest;

class NovelContentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'novel_id' => 'required',
            'title' => 'required|max:255',
            'short_description' => 'required|max:255',
            'content' => 'required',
            'published_at' => 'required|date',
            'is_show' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'novel_id.required' => '请选择章节所属文章',
            'title.required' => '请输入章节标题',
            'title.max' => '章节标题长度不能超过255个字符',
            'short_description.required' => '请输入章节内容简短介绍',
            'short_description.max' => '章节内容简短介绍长度不能超过255个字符',
            'description.required' => '请输入章节内容详细介绍',
            'published_at.required' => '请选择章节内容上线时间',
            'published_at.date' => '请选择正确的章节内容上线时间',
            'is_show.required' => '请选择章节内容是否显示',
        ];
    }

    public function filldata()
    {
        $data = [
            'user_id' => $this->input('user_id', 0),
            'novel_id' => $this->input('novel_id'),
            'title' => $this->input('title'),
            'view_num' => $this->input('view_num', 0),
            'short_description' => $this->input('short_description'),
            'content' => $this->input('content'),
            'seo_keywords' => $this->input('seo_keywords', ''),
            'seo_description' => $this->input('seo_description', ''),
            'published_at' => $this->input('published_at'),
            'is_show' => $this->input('is_show'),
            'charge' => $this->input('charge', 0),
            'chapter_id' => $this->input('chapter_id', 0),
            'duration' => $this->input('duration'),
        ];

        if ($this->isMethod('post')) {
            $data['slug'] = implode('-', (new Pinyin())->convert($data['title']));
        }

        return $data;
    }
}
