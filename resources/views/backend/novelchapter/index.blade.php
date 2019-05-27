@extends('layouts.backend')

@section('title')
    {{$course->title.'的文章章节'}}
@endsection

@section('body')

    <div class="row row-cards">
        <div class="col-sm-12 mb-2">
            <div class="btn-group justify-content-end">
                <a href="{{route('backend.novel.index')}}" class="btn btn-info">返回文章列表</a>
                <a href="{{route('backend.novelchapter.create', $course->id)}}" class="btn btn-primary">添加</a>
            </div>
        </div>
        <div class="col-sm-12">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>排序</th>
                    <th>章节名</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @forelse($rows as $row)
                    <tr>
                        <td>{{$row->id}}</td>
                        <td>{{$row->sort}}</td>
                        <td>{{$row->title}}</td>
                        <td>
                            <a href="{{route('backend.novelchapter.edit', $row)}}"
                               class="btn btn-warning btn-sm">编辑</a>
                            @include('components.backend.destroy', ['url' => route('backend.novelchapter.destroy', $row)])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="4">暂无记录</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection