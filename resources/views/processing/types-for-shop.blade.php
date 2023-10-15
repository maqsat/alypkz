@extends('layouts.profile')

@section('in_content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="m-b-20">Выберите удобный вид оплаты</h4>
                            <!-- Row -->
                            <div class="row img-for-pay">
<!--                                <div class="col-lg-3 col-md-6  img-responsive">
                                    &lt;!&ndash; Card &ndash;&gt;
                                    <div class="card">
                                        <div class="card-block">
                                            <h4 class="card-title">Оплатить с основного баланса - ${{ $balance }}</h4>
                                            <p class="card-text">Баллы распределяются по активационному бонусу</p>
                                            <a href="/pay-prepare?type=balance&@if(!is_null($basket))basket={{ $basket->id }} @endif" class="btn btn-info m-t-10">Оплатить ${{ $all_cost }}</a>
                                        </div>
                                    </div>
                                    &lt;!&ndash; Card &ndash;&gt;
                                </div>-->
                                <div class="col-lg-3 col-md-6  img-responsive">
                                    <!-- Card -->
                                    <div class="card">
                                        <div class="card-block">
                                            <h4 class="card-title">Баланс кешбек - ${{ $cashback }}</h4>
                                            <p class="card-text">30% от суммы можно оплатить с баланса кешбек</p>
                                            <div class="m-b-30">
                                                <label>Потратить кешбек </label>
                                                <input type="checkbox" class="js-switch"  id="js-switch" data-color="#55ce63" data-secondary-color="#f62d51" /></div>
                                                <div class="inner">

                                                </div>
                                        </div>
                                    </div>
                                    <!-- Card -->
                                </div>
                            </div>
                            <div class="row img-for-pay">
                                <div class="col-lg-2 col-md-6  img-responsive">
                                    <!-- Card -->
                                    <div class="card">
                                        <img class="card-img-top img-responsive " src="/nrg/chek.jpeg" alt="Card image cap">
                                        <div class="card-block">
                                            <h4 class="card-title">Скан квитанции</h4>
                                            <p class="card-text">Прикрепите Скан квитанции к форме</p>
                                            <div class="inner-link">
                                                <a href="/pay-prepare?type=manual&@if(!is_null($basket))basket={{ $basket->id }} @endif" class="btn btn-success m-t-10">Оплатить ${{ $all_cost }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Card -->
                                </div>
<!--                                <div class="col-lg-2 col-md-6  img-responsive">
                                    &lt;!&ndash; Card &ndash;&gt;
                                    <div class="card">
                                        <img class="card-img-top img-responsive" src="/nrg/paypost.png" alt="Card image cap">
                                        <div class="card-block">
                                            <h4 class="card-title">PayPost</h4>
                                            <p class="card-text">В карте должен быть подключен 3D secure</p>
                                            <a href="/pay-prepare?type=paypost&@if(!is_null($basket))basket={{ $basket->id }}@endif" class="btn btn-success m-t-10">Оплатить ${{ $all_cost }}</a>
                                        </div>
                                    </div>
                                    &lt;!&ndash; Card &ndash;&gt;
                                </div>-->
                                {{--<div class="col-lg-2 col-md-6  img-responsive">
                                    <!-- Card -->
                                    <div class="card">
                                        <img class="card-img-top img-responsive" src="https://opencartforum.com/screenshots/monthly_2018_11/robokassa.thumb.png.b405b854136ced060d31d9a19ad41189.png" alt="Card image cap">
                                        <div class="card-block">
                                            <h4 class="card-title">Robokassa</h4>
                                            <p class="card-text">Поддерживает все карты Visa и Master Card</p>
                                            <a href="/pay-prepare?type=robokassa&@if(!is_null($basket))basket={{ $basket->id }}@endif" class="btn btn-success m-t-10">Оплатить ${{ $all_cost }}</a>
                                        </div>
                                    </div>
                                    <!-- Card -->
                                </div>--}}
<!--                                <div class="col-lg-2 col-md-6  img-responsive">
                                    &lt;!&ndash; Card &ndash;&gt;
                                    <div class="card">
                                        <img class="card-img-top img-responsive" src="https://makoli.com/wp-content/uploads/payeer-logo.png" alt="Card image cap">
                                        <div class="card-block">
                                            <h4 class="card-title">Payeer</h4>
                                            <p class="card-text">Оплачивайте через электронный кошелёк</p>
                                            <a href="/pay-prepare?type=payeer&@if(!is_null($basket))basket={{ $basket->id }}@endif" class="btn btn-success m-t-10">Оплатить ${{ $all_cost }}</a>
                                        </div>
                                    </div>
                                    &lt;!&ndash; Card &ndash;&gt;
                                </div>-->
                                {{--<div class="col-lg-2 col-md-6  img-responsive">
                                    <!-- Card -->
                                    <div class="card">
                                        <img class="card-img-top img-responsive" src="/nrg/paybox.png" alt="Card image cap">
                                        <div class="card-block">
                                            <h4 class="card-title">Paybox</h4>
                                            <p class="card-text">Поддерживает все карты Visa и Master Card</p>
                                            <a href="/pay-prepare?type=paybox&@if(!is_null($basket))package={{ $basket->id }}@endif" class="btn btn-success m-t-10">Оплатить ${{ $all_cost }}</a>
                                        </div>
                                    </div>
                                    <!-- Card -->
                                </div>--}}
                                {{--<div class="col-lg-2 col-md-6  img-responsive">
                                    <!-- Card -->
                                    <div class="card">
                                        <img class="card-img-top img-responsive" src="https://indigo24.com/img/logo.png" alt="Card image cap">
                                        <div class="card-block">
                                            <h4 class="card-title">indigo24</h4>
                                            <p class="card-text">Отечественный электронный кошелёк</p>
                                            <a href="/pay-prepare?type=indigo&@if(!is_null($basket))basket={{ $basket->id }}@endif" class="btn btn-success m-t-10">Оплатить ${{ $all_cost }}</a>
                                        </div>
                                    </div>
                                    <!-- Card -->
                                </div>--}}
                            </div>
                            <!-- Row -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        @include('layouts.footer')
    </div>
@endsection

@section('body-class')
    fix-header card-no-border fix-sidebar
@endsection

@push('scripts')

    <script src="/monster_admin/main/js/toastr.js"></script>
    <script src="/monster_admin/assets/plugins/toast-master/js/jquery.toast.js"></script>
    <script src="/monster_admin/assets/plugins/switchery/dist/switchery.min.js"></script>

    @if (session('status'))
        <script>
            $.toast({
                heading: 'Пустая корзина!',
                text: '{{ session('status') }}',
                position: 'top-right',
                loaderBg:'#ffffff',
                icon: 'error',
                hideAfter: 60000,
                stack: 6
            });

        </script>
    @endif

    <script>
        jQuery(document).ready(function() {
            // Switchery
            var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
            $('.js-switch').each(function() {
                new Switchery($(this)[0], $(this).data());
            });
        });

        $('.js-switch').change(function () {
            var yes = document.getElementById("js-switch");
            var cost = {{ $all_cost }};
            var cashback = {{ $cashback }};

            if(cost*0.3 > cashback){
                var new_cost = cost - cashback;
                var spent_cashback = cashback;
            }
            else{
                var new_cost = cost - cost*0.3;
                var spent_cashback = cost*0.3;
            }


            if (yes.checked == true){
                $( ".inner" ).html( "<p> C кешбека будет оплачено: " + spent_cashback + "$ <br> C денгами будет оплачено: "+ new_cost +"$ </p>" );
                $( ".inner-link" ).html( "<a href=\"/pay-prepare?type=manual&cashback=1&@if(!is_null($basket))basket={{ $basket->id }} @endif\" class=\"btn btn-success m-t-10\">Оплатить $" +new_cost +"</a>" );
            }
            else{
                $( ".inner-link" ).html( '<a href="/pay-prepare?type=manual&@if(!is_null($basket))basket={{ $basket->id }} @endif" class="btn btn-success m-t-10">Оплатить ${{ $all_cost }}</a>' );
                $( ".inner" ).html("");
            }

        });

    </script>
@endpush


@push('styles')
    <link href="/monster_admin/assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">
    <link href="/monster_admin/assets/plugins/switchery/dist/switchery.min.css" rel="stylesheet" />
@endpush
