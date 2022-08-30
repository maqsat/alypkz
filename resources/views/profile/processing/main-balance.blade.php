<div class="row">
    <!-- Column -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-block">
                <h4 class="card-title">Доступная сумма</h4>
                <div class="d-flex flex-row">
                    <div class="p-10 p-l-0 b-r">
                        <h6 class="font-light">Реферальный бонус + ЛКБ</h6><b>{{ Balance::getBalanceNew(Auth::user()->id, ['invite_bonus','matching_bonus']) }} PV /
                            <span class="text-danger">0% </span></b></div>
                    <div class="p-10 b-r">
                        <h6 class="font-light">Бинарный бонус</h6><b>{{ Balance::getBalanceNew(Auth::user()->id, ['turnover_bonus']) }} PV / <span class="text-danger">0,8% </span></b>
                    </div>
                </div>
            </div>
            <div id="spark1" class="sparkchart"></div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-block">
                <h4 class="card-title">Еженедельная  выплата</h4>
                <div class="d-flex flex-row">
                    <div class="p-10 p-l-0 b-r">
                        <h6 class="font-light">Реферальный бонус + ЛКБ</h6><b>{{ Balance::getWeekBalanceByStatusNew(Auth::user()->id, ['invite_bonus','matching_bonus']) }} PV</b></div>
                    <div class="p-10 b-r">
                        <h6 class="font-light">Бинарный бонус</h6><b>{{ Balance::getWeekBalanceByStatusNew(Auth::user()->id, ['turnover_bonus']) }} PV</b>
                    </div>
                </div>
            </div>
            <div id="spark2" class="sparkchart"></div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-block">
                <h4 class="card-title">Выведено</h4>
                <div class="d-flex flex-row">
                    <div class="p-10 p-l-0 b-r">
                        <h6 class="font-light">Реферальный бонус + ЛКБ</h6><b>80.40%</b></div>
                    <div class="p-10 b-r">
                        <h6 class="font-light">Бинарный бонус</h6><b>20.40%</b>
                    </div>
                </div>
            </div>
            <div id="spark3" class="sparkchart"></div>
        </div>
    </div>
    <!-- Column -->
</div>
