<div class="novel_content">
    <div class="novel_title">{{$video->title}}</div>
    <div class="novel_sub_title"> << {{$video->novel->title}} >> &nbsp;&nbsp;&nbsp; 更新于 {{$video->created_at}}</div>
    {!! $video->content !!}
</div>