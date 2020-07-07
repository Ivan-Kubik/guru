@extends('layouts.app')
@section('content')
    <div class="block_category">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Каталог</h1>
                </div>
                <div class="col-lg-12">
                    @include('parts.category_nav')
                    <div class="cat_container">
                        <div id="load_content" class="row">
                            @foreach($leaders as $user)
                                @php
                                    if ($user->profile) {$profile = $user->profile;} else{$profile = null;}
                                @endphp
                                <div class="col-lg-4 col-md-6">
                                    <div class="event-list-autor">
                                        <img src="assets/site/images/slider_img_autor.jpg" alt=""
                                             class="img-fluid img-list-autor">
                                        <div class="block-list-autor">
                                            <a href="javascript:void(0);" class="location-event">
                                                {{ $profile->city }}
                                                @if($profile->city and $profile->country), @endif
                                                {{ $profile->country }}
                                            </a>
                                            <a href="{{ route('site.author.show', ['id'=>$user->id]) }}"
                                               class="name-autor">{{$user->name}}</a>
                                            <p class="text-autor">
                                                @if($profile)
                                                    {{$profile->excerpt}}
                                                @endif
                                            </p>
                                            <div class="rating-event">
                                                @if($profile)
                                                    <div class="rating">
                                                        {!! get_rating_template($user->profile->raiting) !!}
                                                        @if($user->comments->count() > 0)
                                                            <span class="review-count">&nbsp;({{ $user->comments->count() }} {{ Lang::choice('Отзыв|Отзыва|Отзывов', $user->comments->count()) }})</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="event-footer">
                                                <div class="event-tags">
                                                    @php
                                                        $tours = $user->tours_with_category;
                                                       if ($tours){
                                                           $cats = [];
                                                           foreach ($tours as $tour) {

                                                                 if (!in_array($tour->category->id, $cats)){
                                                                     // TODO id category

                                                                     echo "<a href=\"".route('site.catalog.category.name', ['id' => $tour->category->id])."\">{$tour->category->title}</a>";
                                                                 }
                                                                   $cats[] = $tour->category->id;
                                                           }
                                                       }
                                                    @endphp
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div id="remove_el" class="col-lg-12 after-posts">
                                <button type="button" class="btn-load-more" id="btn-load-more"
                                        data-next-url="{{ $leaders->nextPageUrl() }}">
                                    Показать еще
                                    <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts_footer')
    <script>
        $(document).ready(function () {
            $(document).on('click', '#btn-load-more', function (e) {
                e.preventDefault();
                var next_url = $('#btn-load-more').data('next-url');
                if (next_url === '' || next_url === null) {
                    $('#remove_el').remove();
                    return;
                }
                const btn = $(this);
                const loader = btn.find('span');

                $.ajax({
                    url: next_url,
                    type: 'GET',
                    beforeSend: function () {
                        btn.attr('disabled', true);
                        loader.addClass('d-inline-block');
                    },
                    success: function (response) {
                        $('#remove_el').remove();
                        $('#load_content').append(response);
                    },
                    error: function () {
                        alert('Ошибка!');
                        loader.removeClass('d-inline-block');
                        btn.attr('disabled', false);
                    }
                });
            })
        });
    </script>
@endsection
