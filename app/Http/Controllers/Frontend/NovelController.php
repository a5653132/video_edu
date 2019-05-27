<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Repositories\NovelRepository;
use Illuminate\Http\Request;
use App\Models\Novel;
use Illuminate\Support\Facades\Auth;

class NovelController extends FrontendController
{
    //
    public function index()
    {
        $courses = Novel::show()
            ->published()
            ->orderByDesc('created_at')
            ->paginate(6);

        ['title' => $title, 'keywords' => $keywords, 'description' => $description] = config('meedu.seo.novel_list');

        return v('frontend.novel.index', compact('courses', 'title', 'keywords', 'description'));
    }


    public function show($id, $slug)
    {
        $course = Novel::with(['comments', 'user', 'comments.user'])
            ->show()
            ->published()
            ->whereId($id)
            ->firstOrFail();


        $title = sprintf('文章《%s》', $course->title);
        $keywords = $course->keywords;
        $description = $course->description;

        $comments = $course->comments()->orderByDesc('created_at')->get();


        return v('frontend.novel.show', compact(
            'course',
            'title',
            'keywords',
            'description',
            'comments'
        ));
    }


    public function showBuyPage($id)
    {
        $course = Novel::findOrFail($id);
        $title = sprintf('购买书籍《%s》', $course->title);

        return v('frontend.novel.buy', compact('course', 'title'));
    }

    public function buyHandler(NovelRepository $repository, $id)
    {
        $course = Novel::findOrFail($id);
        $user = Auth::user();

        $order = $repository->createOrder($user, $course);

        if (! ($order instanceof Order)) {
            flash($order, 'warning');

            return back();
        }

        flash('下单成功，请尽快支付', 'success');

        return redirect(route('order.show', $order->order_id));
    }

}
