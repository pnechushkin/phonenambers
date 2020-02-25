<div>
    <nav class="text-center">
        <ul class="pager">
            @if($page_now>1)
                <li><a href="{{$url}}"><<</a></li>
                <li><a href="{{$url}}/{{$preview_page}}"><</a></li>
            @endif
            @for($i=1;$i<=$last_page;$i++)
                @if($i==$page_now)
                    <li class="active"><a href="{{$url}}/{{$i}}">{{ $i }}</a></li>
                @else
                    <li><a href="{{ $url }}/{{$i}}">{{ $i}}</a></li>
                @endif
            @endfor
            @if($next_page < $last_page )
                <li><a href="{{$url}}/{{$next_page}}">></a></li>
                <li><a href="{{$url}}/{{$last_page}}">>></a></li>
            @endif
        </ul>
    </nav>
</div>
<div>
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- canada -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-6745501291018582"
         data-ad-slot="7173274369"
         data-ad-format="auto"
         data-full-width-responsive="true"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
</div>