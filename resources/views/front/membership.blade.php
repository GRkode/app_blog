@extends('front.layout')

@section('hero')

    @isset($heros)

        <section id="hero" class="s-hero">

            <div class="s-hero__slider">

                @foreach($heros as $hero)
                    <x-front.hero :post="$hero" />
                @endforeach

            </div>

            <div class="s-hero__social hide-on-mobile-small">
                <p>@lang('Follow')</p>
                <span></span>
                <ul class="s-hero__social-icons">

                </ul>
            </div>

            <div class="nav-arrows s-hero__nav-arrows">
                <button class="s-hero__arrow-prev">
                    <svg viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg" width="15" height="15"><path d="M1.5 7.5l4-4m-4 4l4 4m-4-4H14" stroke="currentColor"></path></svg>
                </button>
                <button class="s-hero__arrow-next">
                    <svg viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg" width="15" height="15"><path d="M13.5 7.5l-4-4m4 4l-4 4m4-4H1" stroke="currentColor"></path></svg>
                </button>
            </div>

        </section>

    @endisset

@endsection

@section('main')


    @subscribed(auth()->user())
        @isset($title)
            <div class="row">
                <div class="column">
                    <h1>{!! $title !!}</h1>
                </div>
            </div>
        @endisset

        <div class="s-bricks">

        <div class="masonry">
            <div class="bricks-wrapper h-group">

                <div class="grid-sizer"></div>

                <div class="lines">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>

                @foreach($posts as $post)

                    <x-front.brick :post="$post" />

                @endforeach

            </div>

        </div>

        <div class="row">
            <div class="column large-12">
                {{ $posts->links('front.pagination') }}
            </div>
        </div>

    </div>
    @else

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="container">
                        <div class="row">
                            @foreach($plans as $plan)
                                <div class="column large-3 medium-6 tab-12 s-footer__info">

                                    <h3>{{$plan->name}}</h3>
                                    <h5>{{$plan->price}} {{$plan->abbreviation}}</h5>

                                    <p>
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                                        A at commodi doloremque in ipsa labore odio officia officiis, possimus quis.
                                    </p>
                                    <p>
                                        <a class="entry__more-link" href="{{route('payment', ['plan'=>$plan->stripe_name])}}">Souscrire</a>
                                    </p>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endif

@endsection
