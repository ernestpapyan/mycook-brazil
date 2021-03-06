@extends('layouts.default')
@section('title', 'Home')
@section('content')

    <section class="hero-image" style="background-image: url('/assets/img/hero-image-01.jpg')">
        <div class="hero-image__mask"></div>

        <div class="hero-image__content">
            <div class="hero-image__headline">Delivery de comida caseira online</div>
            <div class="hero-image__subline">Comida de verdade. Da cozinha do chef para sua mesa.</div>
            
            <div class="hero-image__search">
                <div id="queryHome">
                    <query-home></query-home>
                </div>
            </div> 

        </div>
 
    </section>

    <section class="feature">
    <div class="container">
        <div class="row">
                <div class="col-md-6">
                    <img class="feature__image mb-3 mb-lg-0" src="/assets/img/family-eating.jpg">
                </div>
                <div class="col-md-6">
                    <div class="feature__headline mb-3">Delivery com os <strong>melhores chefs</strong> ao alcance de suas mãos.</div>
                    <div class="feature__subline mb-3">É rápido e fácil!</div>
                    <div class="feature__copy mb-3">
                        Mycook é a plataforma ideal para pedir aquela comida caseira pagando menos, de uma forma rápida e fácil.
                        Quem não gosta de uma comida caseira bem feita? 
                        Para todos os momentos e ocasiões, peça pelo mycook!
                    </div>
                    <a href="{{ route('comoFunciona') }}" class="btn btn-outline-primary feature__read-more">Saiba mais</a>
                </div>
          </div>
        </div>
    </section>

    <section class="soon">
        <div class="container">
            <img class="soon__image" src="/assets/img/em-breve.png">
        </div>
    </section>

@endsection

@section('script')
    <script>
        var queryHome = new Vue({
            el: '#queryHome'
        });

        // Hero fill browser window
        var heroImage = $('.hero-image');
        var heroImageMask = $('.hero-image__mask');
        var win = $(window);
        resizeHero();
        //reload only if width size changes
        var width = $(window).width();
        win.on('resize', function(){
            if($(this).width() != width){
                resizeHero();
            }
        });
        function resizeHero() {
            if (win.width() > 320 && win.width() < 1920) {
                heroImage.height(win.height() - 96);
                heroImageMask.height(win.height() - 96);
            } else {
                heroImage.css('height', '');
                heroImageMask.css('height', '');
            }
        }
    </script>
@endsection