@extends('web.layout')

@section('content')
    <section class="page owner" id="page-owner">
        <div class="container">
            <div class="page-header">
                <ul class="page-path">
                    <li><a href="#" class="page-path-link">Главная</a></li>
                    <li><a href="#" class="page-path-link isActive">Об основателе</a></li>
                </ul>
                <div class="page-title">
                    <h1>Об основателе</h1>
                </div>
            </div>
        </div>
    </section>

<!--    <section class="page section-green">
        <div class="container">
            <div class="owner-block">
                <div class="owner-text-block">
                    <p>Основатель – Жартыбаев Айбек Ергалиевич, президент компании ALYP GROUP,  успешный бизнесмен, бизнес-коуч, бизнес-психолог</p>
                    <ul>
                        <li>Опыт в МЛМ-бизнесе 12 лет. В том числе, опыт управления сетевым бизнесом на руководящей позиции – 5 лет (с 2017 года)</li>
                        <li>Стал лучшим бизнес-тренером в 2018 году по рейтингу Национальной палаты предпринимателей «Атамекен»</li>
                        <li>Победитель в номинации «Идея года» в 2019 году на Международном бизнес-форуме в Алматы</li>
                        <li>Прошел курс обучения у Брайана Трейси – мирового эксперта в области психологии успеха</li>
                        <li>Обучался у бизнес-тренера, мультимиллионера, Саимурода Давлатова</li>
                        <li>У самого известного менталиста XXI века, бизнес-психолога, телепата Лиора Сушарда</li>
                        <li>Обучался у квантового психолога Скаковой Балдырган</li>
                        <li>Имеет богатый опыт построения самых разноплановых бизнесов, от сельскохозяйственной до тендер- и IT-сферы. Успешно правляет несколькими из них в настоящее время</li>
                        <li>Женат, двое детей.</li>
                    </ul>
                </div>
                <div class="owner-img-block">
                    <div class="owner-img">
                        <img src="/alyp_group/img/img-section4-1.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
        <img src="/alyp_group/img/icons/ill-section-green-elem1.png" alt="" class="section-green-ill1">
        <img src="/alyp_group/img/icons/ill-section-green-elem2.png" alt="" class="section-green-ill2">
    </section>-->

    <section class="page section-cofounder">
        <div class="container">
            <div class="section-header">
                <h1 class="section-title">Сооснователи</h1>
            </div>
            <div class="section-body">
                <div class="cofounder-btns-mobile">
                    <div class="swiper-button-prev-2">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle r="20" transform="matrix(-1 0 0 1 20 20)" fill="#8BC23B"/>
                            <path d="M11.4699 20.5303C11.177 20.2374 11.177 19.7626 11.4699 19.4697L16.2428 14.6967C16.5357 14.4038 17.0106 14.4038 17.3035 14.6967C17.5964 14.9896 17.5964 15.4645 17.3035 15.7574L13.0609 20L17.3035 24.2426C17.5964 24.5355 17.5964 25.0104 17.3035 25.3033C17.0106 25.5962 16.5357 25.5962 16.2428 25.3033L11.4699 20.5303ZM27.2002 20.75L12.0002 20.75L12.0002 19.25L27.2002 19.25L27.2002 20.75Z" fill="white"/>
                        </svg>
                    </div>
                    <div class="swiper-button-next-2">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="20" fill="#8BC23B"/>
                            <path d="M28.5301 20.5303C28.823 20.2374 28.823 19.7626 28.5301 19.4697L23.7572 14.6967C23.4643 14.4038 22.9894 14.4038 22.6965 14.6967C22.4036 14.9896 22.4036 15.4645 22.6965 15.7574L26.9391 20L22.6965 24.2426C22.4036 24.5355 22.4036 25.0104 22.6965 25.3033C22.9894 25.5962 23.4643 25.5962 23.7572 25.3033L28.5301 20.5303ZM12.7998 20.75L27.9998 20.75L27.9998 19.25L12.7998 19.25L12.7998 20.75Z" fill="white"/>
                        </svg>
                    </div>
                </div>
                <div class="cofounder-block">
                    <div class="swiper-button-prev-2">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle r="20" transform="matrix(-1 0 0 1 20 20)" fill="#8BC23B"/>
                            <path d="M11.4699 20.5303C11.177 20.2374 11.177 19.7626 11.4699 19.4697L16.2428 14.6967C16.5357 14.4038 17.0106 14.4038 17.3035 14.6967C17.5964 14.9896 17.5964 15.4645 17.3035 15.7574L13.0609 20L17.3035 24.2426C17.5964 24.5355 17.5964 25.0104 17.3035 25.3033C17.0106 25.5962 16.5357 25.5962 16.2428 25.3033L11.4699 20.5303ZM27.2002 20.75L12.0002 20.75L12.0002 19.25L27.2002 19.25L27.2002 20.75Z" fill="white"/>
                        </svg>
                    </div>
                    <div class="swiper cofounderSwiper">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="cofounder-img">
                                    <img src="/alyp_group/img/img-section4-2.jpg" alt="">
                                </div>
                                <div class="cofounder-text owner-text-block">
                                    <div class="cofounder-name">
                                        <p>Ермугамбетов Абзал Омиртаевич</p>
                                    </div>
                                    <ul>
                                        <li>В сфере МЛМ-бизнеса с 2013 года по настоящее время</li>
                                        <li>За эти годы построил бизнес-команду из более 5000 человек в трех странах мира и СНГ</li>
                                        <li>Проходил обучение у известного бизнеса-тренера, профессора бизнеса и маркетинга, доктора экономических наук, доктора психологических наук, Саидмурода Давлатова.</li>
                                        <li>Обучался у квантового психолога Скаковой Балдырган</li>
                                        <li>С 2017 года – региональный международный директор компании GoSauda</li>
                                        <li>2022 – один из учредителей компании Alyp Group</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="cofounder-img">
                                    <img src="/alyp_group/img/img-section4-4.jpg" alt="">
                                </div>
                                <div class="cofounder-text owner-text-block">
                                    <div class="cofounder-name">
                                        <p>Жунисов Еркебулан Толегенович</p>
                                        <p>инвестор, ментор</p>
                                    </div>
                                    <ul>
                                        <li>2006-2017 Нефтяник, начинал с разнорабочего поднялся до Инженера ОТ и ТБ , ООС</li>
                                        <li>В сфере МЛМ бизнеса с 2017 года</li>
                                        <li>учредитель компании LTD GOSAUDA</li>
                                        <li>генеральный директор ОСОО GOSOODA</li>
                                        <li>Региональный директор International Mentors Group по СНГ</li>
                                        <li>Совет директоров GOSAUDA</li>
                                        <li>Директор компании GOTRAVEL AGENCY</li>
                                        <li>Единственный бриллиантовый директор GOSAUDA</li>
                                        <li>2022 – один из учредителей  компании Alyp Group</li>
                                        <li>Воспитал более 15 директоров международного класса по развитию электронной коммерции в странах СНГ</li>
                                        <li>Проходил обучение у известного бизнеса-тренера, профессора бизнеса и маркетинга, доктора экономических наук, доктора психологических наук, Саидмурода Давлатова</li>
                                    </ul>
                                </div>
                            </div>
<!--                            <div class="swiper-slide">
                                <div class="cofounder-img">
                                    <img src="/alyp_group/img/img-section4-5.jpg" alt="">
                                </div>
                                <div class="cofounder-text owner-text-block">
                                    <div class="cofounder-name">
                                        <p>Аширбеков Жандос Ерланович</p>
                                    </div>
                                    <ul>
                                        <li>2009-2015 – работал в сфере госзакупа. Оборот составил 1 млн$</li>
                                        <li>2015-2017 – сооснователь компании TopFliht сообщество молодых предпринимателей. Руководил отделом продаж, вырастил за это время оборот компании до 2 млн$</li>
                                        <li>2017 –  сооснователь International Mentors Group</li>
                                        <li>2019 – запустил приложение-маркетплейс Gosauda</li>
                                        <li>2021 – открыл представительства Gosauda в Кыргызстане, Турции, Казахстане, Узбекстане</li>
                                        <li>2022 – открыл платформу для торговли между Турцией и Казахстаном.</li>
                                        <li>2022 – запустил Alyp group</li>
                                    </ul>
                                </div>
                            </div>-->
                            <div class="swiper-slide">
                                <div class="cofounder-img">
                                    <img src="/alyp_group/img/img-section4-6.jpg" alt="">
                                </div>
                                <div class="cofounder-text owner-text-block">
                                    <div class="cofounder-name">
                                        <p>Камиев Асылбек Аймуратович</p>
                                    </div>
                                    <ul>
                                        <li>Президент и основатель Business Academy IMG, бизнесмен, бизнес тренер, инфо-продюсер</li>
                                        <li>Опыт в МЛМ-бизнесе с 2010 года</li>
                                        <li>Успешно прошел курс «Онлайн Продюсер» Бакытбая Сабырбекова</li>
                                        <li>Прошел обучение у бизнес-тренера Женис Есенгельдина, на темы: «Бизнес-модель», «32 дневный бизнес-практикум»,  «Финансовая грамотность»</li>
                                        <li>Директор компании Gosauda</li>
                                        <li>Глава совета директоров компании IMG</li>
                                        <li>Учредитель компании Alyp Group</li>
                                        <li>Награжден медалью «Батыр шапағаты» имени Бауржан Момышулы</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="cofounder-img">
                                    <img src="/alyp_group/img/img-section4-7.jpg" alt="">
                                </div>
                                <div class="cofounder-text owner-text-block">
                                    <div class="cofounder-name">
                                        <p>Утегенов Галымбек Сапарбергенович</p>
                                        <p>«Ұлт Жанашыры»</p>
                                    </div>
                                    <ul>
                                        <li>Награжден орденом «НАМЫС» имени Б. Момышұлы</li>
                                        <li>2002-2018 – работал в Қазақстан Темір Жолы машинистом 2-го класса</li>
                                        <li>С 2018 года в бизнесе</li>
                                        <li>В 2022 году вошел в ТОП-30 успешных предпринимателей Казахстана</li>
                                        <li>Учредитель Gosauda Казахстан, Кыргызстан</li>
                                        <li>Генеральный Директор компании Gosauda в Турции</li>
                                        <li>Учредитель компании Alyp Group</li>
                                        <li>Экспорт-импорт разного вида товаров между странами Турция, Казахстан, Кыргызстан, Узбекистан, Азербайджан, Европа,Африка</li>
                                        <li>Учредитель Alyp Group Limited</li>
                                    </ul>
                                </div>
                            </div>
<!--                            <div class="swiper-slide">
                                <div class="cofounder-img">
                                    <img src="/alyp_group/img/img-section4-3.jpg" alt="">
                                </div>
                                <div class="cofounder-text owner-text-block">
                                    <div class="cofounder-name">
                                        <p>Игенов Думан Боранбаевич </p>
                                    </div>
                                    <ul>
                                        <li>Награжден орденом «НАМЫС» имени Б. Момышұлы</li>
                                        <li>2011 - 2014 – работа в сфере сетевого маркетинга</li>
                                        <li>Занимался госзакупками ИП Eagles, продажа мяса</li>
                                        <li>2014-2016 – Заместитель директора TopFlaiht</li>
                                        <li>2017 – Генеральный директор ТОО Onlinе Sauda</li>
                                        <li>Автор идеи мобильного приложения GoSauda</li>
                                        <li>2022 – учредитель Alyp Group</li>
                                    </ul>
                                </div>
                            </div>-->
                        </div>
                    </div>
                    <div class="swiper-button-next-2">
                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="20" fill="#8BC23B"/>
                            <path d="M28.5301 20.5303C28.823 20.2374 28.823 19.7626 28.5301 19.4697L23.7572 14.6967C23.4643 14.4038 22.9894 14.4038 22.6965 14.6967C22.4036 14.9896 22.4036 15.4645 22.6965 15.7574L26.9391 20L22.6965 24.2426C22.4036 24.5355 22.4036 25.0104 22.6965 25.3033C22.9894 25.5962 23.4643 25.5962 23.7572 25.3033L28.5301 20.5303ZM12.7998 20.75L27.9998 20.75L27.9998 19.25L12.7998 19.25L12.7998 20.75Z" fill="white"/>
                        </svg>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
