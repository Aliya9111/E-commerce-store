@props(['ratingsPer','fontSize'])
<li style="font-size: {{$fontSize}}px" class="d-inline">
    @for($i = 1; $i <= 5; $i++)
        @if($i <= floor($ratingsPer) || $i - 0.1 == $ratingsPer ||$i - 0.9 == $ratingsPer)  
            {{-- Full Star or 0.1,0.9 --}}
            <small class="fa-solid fa-star text-warning"></small>
        @elseif($i - 0.2 == $ratingsPer || $i - 0.3 == $ratingsPer || $i - 0.4 == $ratingsPer || $i - 0.5 == $ratingsPer || $i - 0.6 == $ratingsPer || $i - 0.7 == $ratingsPer)
            {{-- 0.2 -> 0.8 Star --}}
            <small class="fa-regular fa-star-half-stroke text-warning"></small>
            {{-- Empty Star --}}
        @else    
            <small class="fa-regular fa-star text-warning"></small>
        @endif
    @endfor
</li>