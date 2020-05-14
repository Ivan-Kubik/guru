@extends('layouts.app')
@section('content')
    @if($tour->gallery)
    <div class="block_event_image">
        <div class="container-fluid no-padding">
            @php
                $gallery = json_decode($tour->gallery);
            @endphp
            <div class="row">
                @isset($gallery[0])
                <div class="col-lg-6 col-md-6 col-sm-6 col-12 no-padding">
                    <div class="event-gallery-large">
                        <div data-fancybox="gallery" href="{{ $gallery[0] }}" style="background-image: url({{ $gallery[0] }});"></div>
                    </div>
                </div>
                @endisset
                <div class="col-lg-6 col-md-6 col-sm-6 col-12 no-padding">
                    <div class="event-gallery-small">
                        @isset($gallery[1])
                        <div class="event-gallery-small__block">
                            <div data-fancybox="gallery" href="{{ $gallery[1] }}" style="background-image: url({{ $gallery[1] }});"></div>
                        </div>
                        @endisset
                        @isset($gallery[2])
                        <div class="event-gallery-small__block">
                            <div data-fancybox="gallery" href="{{ $gallery[2] }}" style="background-image: url({{ $gallery[2] }});"></div>
                        </div>
                        @endisset
                        @isset($gallery[3])
                        <div class="event-gallery-small__block">
                            <div data-fancybox="gallery" href="{{ $gallery[3] }}" style="background-image: url({{ $gallery[3] }});"></div>
                        </div>
                        @endisset
                        @isset($gallery[4])
                        <div class="event-gallery-small__block">
                            <div data-fancybox="gallery" href="{{ $gallery[4] }}" style="background-image: url({{ $gallery[4] }});"></div>
                        </div>
                        @endisset
                    </div>
                    @isset($gallery[5])
                    <div class="event-gallery-none">
                        <div data-fancybox="gallery" href="{{ $gallery[5] }}" style="background-image: url({{ $gallery[5] }});">Другие фото</div>
                        @isset($gallery[6])
                            @for($i = 6; $i < (count($gallery) - 6); $i++)
                                <div data-fancybox="gallery" href="{{ $gallery[$i] }}" style="background-image: url({{ $gallery[$i] }});"></div>
                            @endfor
                        @endisset
                    </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="block_event_content">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h1 class="event-title">{{ $tour->title }}</h1>
                    <div class="event-details">
                        <div class="event-dateils_block">
                            <div class="rating-tour">
                                <div class="rating">
                                    {!! get_raiting_template($tour->rating) !!}
                                    @if($comments->count() > 0)
                                    <a href="#reviews" class="review-count">Отзывов - <span>{{ $comments->count() }}</span></a>
                                    @endif
                                </div>
                            </div>
                            <div class="event-date">
                                @php
                                    $start = \Carbon\Carbon::create($tour->date_start);
                                    $end = \Carbon\Carbon::create($tour->date_end);
                                    $diff = $start->diffInDays($end);
                                @endphp
                                <span class="event-date-icon"></span>
                                {{ $start->formatLocalized('%e %B') }}
                                - {{ $end->formatLocalized('%e %B %Y') }}
                                ( {{ $diff }} {{ Lang::choice('День|Дня|Дней', $diff) }} )
                            </div>
                        </div>
                        <div class="event-dateils_block">
                            <div class="event-pin">
                                <span class="event-pin-icon"></span>
                                <span>{{ $tour->country }}, {{ $tour->city }}</span>
                            </div>
                            <div class="event-group">
                                <div class="event-group-icon"></div>
                                <span>Группа {{ $tour->count_person }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="block-booking block-booking-mobile">
                        <p class="event-subtitle-text">
                            Забронировать мероприятие
                        </p>
                        <div class="event-date">
                            <span class="event-date-icon"></span>
                            <span>
                                {{ $start->formatLocalized('%e %B') }}
                                - {{ $end->formatLocalized('%e %B %Y') }}
                                ( {{ $diff }} {{ Lang::choice('День|Дня|Дней', $diff) }} )
                            </span>
                        </div>
                        <a href="#" class="note-schedule">Другие мероприятия организации</a>
                        <div class="booking__select selected">
                            <label class="booking__variant">
                                <input type="radio" name="booking" value="1" checked>
                                <span class="radio"></span>
                                <div class="price-img">
                                    @php $images = json_decode($tour->gallery)  @endphp
                                    <img src="{{ $images[0] ?? null }}" alt="" class="img-fluid">
                                </div>
                                <div class="price-info">
                                    <p class="cost-tour">{{ number_format($tour->price_base / 100) }} <span>RUB</span></p>
                                    <p>{{ $tour->count_person }}</p>
                                    {{ $tour->info_description }}
                                </div>
                            </label>
                        </div>
                        @foreach($tour->variants as $variant)
                            <div class="booking__select">
                                <label class="booking__variant">
                                    <input type="radio" name="booking" value="2">
                                    <span class="radio"></span>
                                    <div class="price-img">
                                        <img src="{{ $variant->photo_variant }}" alt="" class="img-fluid">
                                    </div>
                                    <div class="price-info">
                                        <p class="cost-tour">{{ number_format($variant->price_variant / 100) }} <span>RUB</span></p>
                                        <p>{{ $variant->amount_variant }}</p>
                                        {{ $variant->text_variant }}
                                    </div>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <div class="event-list">
                        <h2 class="event-subtitle">Информация о мероприятии</h2>
                        {!! $tour->info_excerpt !!}
                    </div>
                    <div class="event-details-text">
                        <h2 class="event-subtitle">Подробнее о мероприятии</h2>
                        <p class="event-detailt-autor">Ваши гиды:</p>
                        <div class="event_list__autor">
                            @foreach($tour->leaders as $leader)
                                <?php //dd($leader->profile); ?>
                            <a href="{{ route('site.author.show', ['id' => $leader->id]) }}" target="_blank" title="{{ $leader->name }}">
                                <img src="{{ json_decode($leader->profile->avatar)[0] ?? '' }}" alt="фото автора" class="img-fluid">
                                <span>{{ $leader->name }}</span>
                            </a>
                            @endforeach
                        </div>
                        <div class="article">
                        {{ $tour->info_description }}
                        </div>
                    </div>
                    <div class="event-details-accordion">
                        <div class="event-accordion accordion-schedule">
                            <div class="accordion-btn">График мероприятия:</div>
                            <div class="panel article">
                            {{ $tour->timetable }}
                            </div>
                        </div>
                    </div>
                    <div class="event-details-accordion">
                        <div class="event-accordion accordion-security">
                            <div class="accordion-btn">Безопастность:</div>
                            <div class="panel article">
                                <ul class="list-security">
                                    <li>@if($tour->first_aid != '' and $tour->first_aid != null) {{ $tour->first_aid }} @endif</li>
                                    <li>@if($tour->first_aid != '' and $tour->first_aid != null) {{ $tour->drinking_water }} @endif</li>
                                    <li>@if($tour->first_aid != '' and $tour->first_aid != null) {{ $tour->communication }} @endif</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="event-details-accordion">
                        <div class="event-accordion accordion-place">
                            <div class="accordion-btn">Место проведения:</div>
                            <div class="panel article">
                                <div class="event-pin">
                                    <span class="event-pin-icon"></span>
                                    <span>{{ $tour->country }}, {{ $tour->city }}</span>
                                </div>
                                <div class="block_place">
                                    @php
                                    $link = generate_google_map_link([$tour->street, $tour->house, $tour->city, $tour->country]);
                                    @endphp
                                    <iframe width="100%" height="350" frameborder="0" style="border:0" src="{{ $link }}" allowfullscreen></iframe>
                                </div>
                                <div class="block_place">
                                    {{ $tour->adress_desk }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="event-details-accordion">
                        <div class="event-accordion accordion-accommodation">
                            <div class="accordion-btn">Проживание и удобства:</div>
                            <div class="panel article">
                                <div class="img-accordion-block">
                                    @php
                                    if ($tour->accommodation_photo){
                                            $acc_gall = json_decode($tour->accommodation_photo) ?? [];
                                    }else{$acc_gall = [];}
                                    @endphp
                                    @foreach($acc_gall as $img)
                                    <div class="img-accordion-double">
                                        <img src="{{ $img }}" alt="" class="img-fluid">
                                    </div>
                                        @php if($loop->index == 2) break; @endphp
                                    @endforeach
                                </div>
                                <ul class="list-accommodation">
                                    @if($tour->conditioner)
                                    <li><span class="icon-accommodation"></span>Кондиционер</li>
                                    @else
                                        <li class="noactive"><span class="icon-accommodation"></span>Кондиционер</li>
                                    @endif
                                    @if($tour->wifi)
                                        <li><span class="icon-accommodation"></span>Бесплатный Wifi</li>
                                    @else
                                        <li class="noactive"><span class="icon-accommodation"></span>Бесплатный Wifi</li>
                                    @endif
                                    @if($tour->pool)
                                        <li><span class="icon-accommodation"></span>Бассейн</li>
                                    @else
                                        <li class="noactive"><span class="icon-accommodation"></span>Бассейн</li>
                                    @endif
                                    @if($tour->towel)
                                        <li><span class="icon-accommodation"></span>Полотенца</li>
                                    @else
                                        <li class="noactive"><span class="icon-accommodation"></span>Полотенца</li>
                                    @endif
                                    @if($tour->kitchen)
                                        <li><span class="icon-accommodation"></span>Кухня</li>
                                    @else
                                        <li class="noactive"><span class="icon-accommodation"></span>Кухня</li>
                                    @endif
                                    @if($tour->coffee_tea)
                                        <li><span class="icon-accommodation"></span>Кофе/Чай</li>
                                    @else
                                        <li class="noactive"><span class="icon-accommodation"></span>Кофе/Чай</li>
                                    @endif
                                </ul>
                                {{ $tour->accommodation_description }}
                            </div>
                        </div>
                    </div>
                    <div class="event-details-accordion">
                        <div class="event-accordion accordion-meals">
                            <div class="accordion-btn">Питание:</div>
                            <div class="panel article">
                                <div class="img-accordion-block">
                                    @php
                                        if ($tour->gallery_meals){
                                                $mea_gall = json_decode($tour->gallery_meals);
                                        }else{$mea_gall = [];}
                                    @endphp
                                    @foreach($mea_gall as $img)
                                    <div class="img-accordion-double">
                                        <img src="{{ $img }}" alt="" class="img-fluid">
                                    </div>
                                    @endforeach
                                </div>
                                <ul class="list-meals">
                                    @if($tour->vegan)
                                        <li><span class="icon-meals"></span>Веган</li>
                                    @else
                                        <li class="noactive"><span class="icon-meals"></span>Веган</li>
                                    @endif
                                    @if($tour->vegetarianism)
                                            <li><span class="icon-meals"></span>Вегетариа́нство</li>
                                    @else
                                            <li class="noactive"><span class="icon-meals"></span>Вегетариа́нство</li>
                                    @endif
                                    @if($tour->fish)
                                            <li><span class="icon-meals"></span>Рыба</li>
                                    @else
                                            <li class="noactive"><span class="icon-meals"></span>Рыба</li>
                                    @endif
                                    @if($tour->ayurveda)
                                            <li><span class="icon-meals"></span>Аюрведа</li>
                                    @else
                                            <li class="noactive"><span class="icon-meals"></span>Аюрведа</li>
                                    @endif
                                    @if($tour->meat)
                                            <li><span class="icon-meals"></span>Мясо</li>
                                    @else
                                            <li class="noactive"><span class="icon-meals"></span>Мясо</li>
                                    @endif
                                    @if($tour->organic)
                                            <li><span class="icon-meals"></span>Органическая</li>
                                    @else
                                            <li class="noactive"><span class="icon-meals"></span>Органическая</li>
                                    @endif
                                    @if($tour->gluten_free)
                                            <li><span class="icon-meals"></span>Без глютена</li>
                                    @else
                                            <li class="noactive"><span class="icon-meals"></span>Без глютена</li>
                                    @endif
                                    @if($tour->milk_free)
                                            <li><span class="icon-meals"></span>Без молока</li>
                                    @else
                                            <li class="noactive"><span class="icon-meals"></span>Без молока</li>
                                    @endif
                                    @if($tour->nuts_free)
                                            <li><span class="icon-meals"></span>Без орехов</li>
                                    @else
                                            <li class="noactive"><span class="icon-meals"></span>Без орехов</li>
                                    @endif
                                </ul>
                                {{ $tour->meals_desc }}
                            </div>
                        </div>
                    </div>
                    <div class="event-details-accordion">
                        <div class="event-accordion accordion-included">
                            <div class="accordion-btn">Включено в мероприятие:</div>
                            <div class="panel article">
                                {{ $tour->included }}
                                <p class="title-place">Не включено:</p>
                                {{ $tour->no_included }}
                            </div>
                        </div>
                    </div>
                    <div class="event-details-accordion" id="reviews">
                        <div class="event-accordion accordion-reviews">
                            <div class="accordion-btn">
                                @if($comments->count() > 0) Отзывы клиентов: @else Отзывов пока нет @endif
                            </div>
                            <div class="panel reviews-read">
                                <div class="rating-accordion-block">
                                    <div class="rating-accordion">
                                        <div class="rating">
                                            {!! get_raiting_template($tour->rating, false) !!}
                                            @if($tour->rating > 0)
                                            <span class="review-text">Средний рейтинг {{ $tour->rating }} из 5.0</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="rating-feedback">
                                        @auth
                                        <a class="btn-review" data-src="#form-reviews" data-fancybox="" href="">Добавить отзыв</a>
                                        @else
                                        <div class="review-aut">Чтобы оставить отзыв <a href="{{ route('login') }}">авторизуйтесь</a>.</div>
                                        @endauth
                                    </div>
                                </div>
                                @if($comments->count() > 0)
                                <p class="title-shedule">Отзывов - {{ $comments->count() }}</p>
                                @endif
                                <div class="block-reviews">
                                    @foreach($comments as $comment)
                                    <article class="block-reviews_elem article">
                                        <div class="review_header">
                                            <p class="title-review">{{ $comment->title }}</p>
                                            <div class="rating">
                                                {!! get_raiting_template($comment->rating) !!}
                                            </div>
                                        </div>
                                        <div class="review_main">
                                            <p class="text-review">{{ $comment->comment }}</p>
                                        </div>
                                        <div class="review_footer">
                                            <span class="review-autor">{{ $comment->user->name }}</span> -
                                            <span class="review-date">{{ $comment->updated_at->formatLocalized('%e %B %Y') }}</span>
                                        </div>
                                    </article>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php //dd($similar_tours); ?>
                    @if($similar_tours->count() > 1)
                    <div class="event-details-accordion">
                        <div class="event-accordion accordion-similar">
                            <div class="accordion-btn">Похожие мероприятие:</div>
                            <div class="panel article">
                                <ul class="list_similar_events">
                                    @foreach($similar_tours as $item)
                               {{--      если не это мероприятие    --}}
                                        @if($item->id != $tour->id)
                                    <li class="similar_events_elem">
                                        <a href="{{ route('site.catalog.tour.show', ['event' => $item->id]) }}" class="similar-link">
                                            <?php
                                            $gal = json_decode($item->gallery) ?? [];
                                            ?>
                                            @isset($gal[0])
                                            <img src="{{ $gal[0] }}" alt="" class="img-fluid">
                                            @endisset
                                            <p>{{ $item->title }}</p>
                                            <div class="rating-accordion">
                                                <div class="rating">
                                                    {!! get_raiting_template($item->rating, false) !!}
                                                    @if($item->rating > 0)
                                                    <span class="review-text">{{ $item->rating }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="col-lg-4">
                    <div class="block-booking">
                        <p class="event-subtitle-text">
                            Забронировать мероприятие
                        </p>
                        <div class="event-date">
                            <span class="event-date-icon"></span>
                            <span>
                                {{ $start->formatLocalized('%e %B') }}
                                - {{ $end->formatLocalized('%e %B %Y') }}
                                ( {{ $diff }} {{ Lang::choice('День|Дня|Дней', $diff) }} )
                            </span>
                        </div>
                        <a href="#" class="note-schedule">Другие мероприятия организации</a>
                        <div class="booking__select selected">
                            <label class="booking__variant">
                                <input type="radio" name="booking" value="1" checked>
                                <span class="radio"></span>
                                <div class="price-img">
                                    @php $images = json_decode($tour->gallery)  @endphp
                                    <img src="{{ $images[0] ?? null }}" alt="" class="img-fluid">
                                </div>
                                <div class="price-info">
                                    <p class="cost-tour">{{ number_format($tour->price_base / 100) }} <span>RUB</span></p>
                                    <p>{{ $tour->count_person }}</p>
                                    <p>{{ $tour->info_excerpt }}</p>
                                </div>
                            </label>
                        </div>
                        @foreach($tour->variants as $variant)
                        <div class="booking__select">
                            <label class="booking__variant">
                                <input type="radio" name="booking" value="2">
                                <span class="radio"></span>
                                <div class="price-img">
                                    <img src="{{ $variant->photo_variant }}" alt="" class="img-fluid">
                                </div>
                                <div class="price-info">
                                    <p class="cost-tour">{{ number_format($variant->price_variant / 100) }} <span>RUB</span></p>
                                    <p>{{ $variant->amount_variant }}</p>
                                    <p>{{ $variant->text_variant }}</p>
                                </div>
                            </label>
                        </div>
                        @endforeach
                        <div class="booking__event">
                            <p class="note-schedule"><span>Бронирования</span> места составляет <span>14%</span> от суммы!</p>
                            <a href="#" class="btn-booking">Забронировать место</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @auth
    <div class="fancybox-content" id="form-reviews" style="display: none;">
        <div class="form-title">Оставить отзыв</div>
        <form action="{{ route('site.tour.rating.estimate') }}" autocomplete="off" method="post">
            @csrf
            <div class="form-reviews-block">
                <span>Оценка:</span>
                <div class="star-rating">
                    <div class="star-rating__wrap">
                        <input class="star-rating__input" id="star-rating-5" type="radio" name="rating" value="5">
                        <label class="star-rating__ico fa fa-star-o" for="star-rating-5" title="5 out of 5 stars"></label>
                        <input class="star-rating__input" id="star-rating-4" type="radio" name="rating" value="4">
                        <label class="star-rating__ico fa fa-star-o" for="star-rating-4" title="4 out of 5 stars"></label>
                        <input class="star-rating__input" id="star-rating-3" type="radio" name="rating" value="3">
                        <label class="star-rating__ico fa fa-star-o" for="star-rating-3" title="3 out of 5 stars"></label>
                        <input class="star-rating__input" id="star-rating-2" type="radio" name="rating" value="2">
                        <label class="star-rating__ico fa fa-star-o" for="star-rating-2" title="2 out of 5 stars"></label>
                        <input class="star-rating__input" id="star-rating-1" type="radio" name="rating" value="1">
                        <label class="star-rating__ico fa fa-star-o" for="star-rating-1" title="1 out of 5 stars"></label>
                    </div>
                </div>
            </div>
            <input type="hidden" name="tour_id" value="{{ $tour->id }}">
            <div class="form-reviews-block"><span>Заголовок отзыва:</span><input type="text" name="title"></div>
            <div class="form-reviews-block"><span>Текст отзыва:</span><textarea name="comment" id=""></textarea></div>
            <div class="form-reviews-block"><button type="submit">Добавить отзыв</button></div>
        </form>
    </div>
    @endauth
@endsection
@section('scripts_footer')

@endsection
