@extends('layouts.backend')

@section('title')
    文章列表
@endsection

@section('body')

    <div class="row row-cards">
        <div class="col-sm-12">
            <a href="{{ route('backend.novel.create') }}" class="btn btn-primary">添加</a>
        </div>
        <div class="col-sm-12">
            <form action="" method="get">
                <div class="form-group">
                    <label>文章标题</label>
                    <input type="text" class="form-control" name="keywords" value="{{ request()->input('keywords', '') }}" placeholder="请输入关键字">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">过滤</button>
                    <a href="{{ route('backend.novel.index') }}" class="btn btn-warning">重置</a>
                </div>
            </form>
        </div>
        <div class="col-sm-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>文章</th>
                    <th>价格</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($courses as $course)
                    <tr>
                        <td>{{$course->id}}</td>
                        <td>{{$course->title}}</td>
                        <td><span class="badge badge-info">{{$course->charge}}</span></td>
                        <td>{{$course->created_at}}</td>
                        <td>
                            <a href="{{route('backend.novel.edit', $course)}}" class="btn btn-warning btn-sm">编辑</a>
                            @include('components.backend.destroy', ['url' => route('backend.novel.destroy', $course)])
                            <a href="{{route('backend.novelchapter.index', $course->id)}}" class="btn btn-info btn-sm">章节</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="5">暂无记录</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="col-sm-12">
            {{$courses->render()}}
        </div>
    </div>

@endsection