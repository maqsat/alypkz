@extends('web.layout')

@section('content')
    <section class="page start" id="page-start">
        <div class="container">
            <div class="page-header">
                <ul class="page-path">
                    <li><a href="#" class="page-path-link">Главная</a></li>
                    <li><a href="#" class="page-path-link isActive">Начать бизнес</a></li>
                </ul>
                <div class="page-title">
                    <h1>Начать бизнес</h1>
                </div>
            </div>
            <div class="page-body">
                <div class="start-block">
                    <div class="start-text-block">
                        <p>Маркетинг компании ALYP GROUP был построен на основе анализа деятельности 50 самых успешных мировых МЛМ-компаний. </p>
                        <p>Это простая, эффективная и работающая на перспективу бизнес-схема.</p>
                        <p>В компании существует 3 пакета регистрации. Каждый из них имеет свои преимущества.</p>
                    </div>
                </div>
                <div class="start-block">
                    <div class="start-title">3 пакета регистрации</div>
                    <div class="start-cards">
                        <div class="start-card-items">
                            <div class="start-card-images">
                                <img src="/alyp_group/img/icons/ic-green-bank.svg" alt="">
                                <img src="/alyp_group/img/icons/ic-green-bank.svg" alt="">
                            </div>
                            <div class="start-card-text">
                                <h2>Стартовый</h2>
                                <h4>100$</h4>
                                <p>2 банки</p>
                            </div>
                        </div>
                        <div class="start-card-items">
                            <div class="start-card-images">
                                <img src="/alyp_group/img/icons/ic-green-bank.svg" alt="">
                                <img src="/alyp_group/img/icons/ic-green-bank.svg" alt="">
                                <img src="/alyp_group/img/icons/ic-green-bank.svg" alt="">
                            </div>
                            <div class="start-card-text">
                                <h2>Бизнес</h2>
                                <h4>500$</h4>
                                <p>10 банок</p>
                            </div>
                        </div>
                        <div class="start-card-items">
                            <div class="start-card-images">
                                <img src="/alyp_group/img/icons/ic-green-bank.svg" alt="">
                                <img src="/alyp_group/img/icons/ic-green-bank.svg" alt="">
                                <img src="/alyp_group/img/icons/ic-green-bank.svg" alt="">
                                <img src="/alyp_group/img/icons/ic-green-bank.svg" alt="">
                            </div>
                            <div class="start-card-text">
                                <h2>VIP</h2>
                                <h4>1000$</h4>
                                <p>20 банок</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="start-other" id="start-other">
        <div class="start-other-section -referal">
            <div class="container-std">
                <div class="start-other-text">
                    <h3>Реферальный бонус</h3>
                    <h4>Создайте свою бизнес-команду</h4>
                    <p>С ALYP GROUP вы можете стать не только независимым партнером, но и руководителем бизнес-команды. Создайте собственную команду.</p>
                    <p>За каждого приглашенного вами в бизнес партнера вы получаете бонус<br>
                        в размере <span class="text-big-sum">10%</span> от его пакета регистрации</p>
                </div>
                <div class="start-other-img">
                    <img src="/alyp_group/img/img-start-section-1.jpg" alt="">
                </div>
            </div>
        </div>
        <div class="start-other-section -lkb">
            <div class="container-std">
                <div class="start-other-img">
                    <img src="/alyp_group/img/img-start-section-2.jpg" alt="">
                </div>
                <div class="start-other-text">
                    <h3>Бинарный бонус и ЛКБ-бонус ОТ 5% до 15%</h3>
                    <h4>Создайте свою бизнес-команду</h4>
                    <p>Бинарный бонус выплачивается, когда лично-приглашенные с левой и правой стороны образуют пару.</p>
                    <p>ЛКБ - это личный командный бонус. Складывается от товарооборота личной команды.</p>
                    <p>ЛКБ можно получить, закрывая статусы или зайти на пакеты:</p>
                    <h3><span class="text-big-sum">500$</span> и <span class="text-big-sum">100$</span></h3>
                </div>
            </div>
        </div>
        <div class="start-other-section -status">
            <div class="container-std">
                <div class="start-other-text">
                    <h3>Статусы</h3>
                    <h4>Статусы склыдваются из товарооборота вашей личной команды по следующим суммам:</h4>
                    <table class="start-table">
                        <thead>
                        <tr>
                            <td>Старший партнер</td> <td>5000$</td> <td>ЛКБ 5% </td> <td>Travel-бонус</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>Менеджер</td> <td>10 000$</td> <td>ЛКБ 10%</td> <td>-</td>
                        </tr>
                        <tr>
                            <td>Старший менеджер</td> <td>50 000$ </td> <td>ЛКБ 10%</td> <td>-</td>
                        </tr>
                        <tr>
                            <td>Директор</td> <td>100 000$</td> <td>ЛКБ 10%</td> <td>Место в совете директоров</td>
                        </tr>
                        <tr>
                            <td>Золотой директор</td> <td>100 000$</td> <td>ЛКБ 10%</td> <td>Авто/квартирный бонус</td>
                        </tr>
                        <tr>
                            <td>Алып директор</td> <td>1 000 000$</td> <td>3% МТО </td> <td>Пассивный доход</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="start-table-result">
                        МТО 3%
                    </div>
                    <div class="start-other-text -addition">
                        <p><b>Бонус от мирового товарооборота в размере 3%</b> выплачивается с момента закрытия <b>статуса «Алып директор».</b></p>
                        <p>Это и есть ваш пассивный доход, о котором люди мечтают всю жизнь!</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="start-other-section -mysterious">
            <div class="container-std">
                <div class="start-other-img">
                    <img src="/alyp_group/img/img-start-section-3.jpg" alt="">
                </div>
                <div class="start-other-text ">
                    <h3>Секрет бонус</h3>
                    <h4>Создайте свою бизнес-команду</h4>
                    <p><b>Секрет бонус</b> – это вершина Алыпа, достигнув которой вы выходите на новый уровень дохода, мышления и окружения. </p>
                    <p><b>Вы выходите на пассивный доход.</b> И с этого момента можете создавать и открывать новые бизнес-проекты с учредителями и партнерами, закрывшими этот статус.</p>
                    <p>Вести за собой осознанных людей, став причиной их успеха через служение людям.</p>
                    <button class="start-btn btn1">Начать бизнес</button>
                </div>
            </div>
        </div>
    </section>
@endsection

