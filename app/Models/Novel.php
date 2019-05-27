<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Novel extends Model
{
    //
    use SoftDeletes;

    const SHOW_YES = 1;
    const SHOW_NO = -1;

//    protected $table = 'courses';

    protected $fillable = [
        'user_id', 'title', 'slug', 'thumb', 'charge',
        'short_description', 'description', 'seo_keywords',
        'seo_description', 'published_at', 'is_show',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeShow($query)
    {
        return $query->where('is_show', self::SHOW_YES);
    }

    public function scopeNotShow($query) {
        return $query->where('is_show', self::SHOW_NO);
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', date('Y-m-d H:i:s'));
    }

    /**
     * 评论.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(NovelComment::class, 'novel_id', 'id');
    }

    public function getDescription()
    {
        return $this->description;
    }



    /**
     * 该文章下面的章节.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function novel_content()
    {
        return $this->hasMany(NovelContent::class, 'novel_id', 'id');
    }



    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chapters()
    {
        return $this->hasMany(NovelChapter::class, 'novel_id');
    }

    public function hasChapters()
    {

        return $this->chapters()->exists();

    }
    /**
     * 是否存在缓存.
     *
     * @return bool|mixed
     */
    public function hasChaptersCache()
    {

        if (config('meedu.system.cache.status', -1) != 1) {
            return $this->hasChapters();
        }

        return Cache::remember(
            "course_{$this->id}_has_chapters",
            config('meedu.system.cache.expire', 60),
            function () {
                return $this->hasChapters();
            }
        );
    }


    /**
     * 章节缓存.
     *
     * @return \Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getChaptersCache()
    {
        if (config('meedu.system.cache.status', -1) != 1) {
            return $this->getChapters();
        }

        return Cache::remember(
            "course_{$this->id}_chapter_videos",
            config('meedu.system.cache.expire', 60),
            function () {
                return $this->getChapters();
            }
        );
    }

    /**
     * 获取章节
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getChapters()
    {
        return $this->chapters()->orderBy('sort')->get();
    }


    /**
     * 评论处理.
     *
     * @param string $content
     *
     * @return false|Model
     */
    public function commentHandler(string $content)
    {
        $comment = $this->comments()->save(new NovelComment([
            'user_id' => Auth::id(),
            'content' => $content,
        ]));

        return $comment;
    }



    /**
     * @return mixed
     */
    public function getAllPublishedAndShowVideosCache()
    {
        if (config('meedu.system.cache.status', -1) != 1) {
            return $this->getAllPublishedAndShowVideos();
        }

        return Cache::remember(
            "course_{$this->id}_videos",
            config('meedu.system.cache.expire', 60),
            function () {
                return $this->getAllPublishedAndShowVideos();
            }
        );
    }

    /**
     * 获取所有已出版且显示的视频.
     *
     * @return mixed
     */
    public function getAllPublishedAndShowVideos()
    {
        return $this->novel_content()
            ->published()
            ->show()
            ->orderBy('published_at')
            ->get();
    }
}
