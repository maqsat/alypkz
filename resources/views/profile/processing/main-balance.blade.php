<div class="row">
    <!-- Column -->
    <div class="col-lg-4">
        <div class="card">
            <div class="card-block">
                <h4 class="card-title">Доступная сумма</h4>
                <div class="d-flex flex-row">
                    <div class="p-10 p-l-0 b-r">
                        <h6 class="font-light">Реферальный бонус</h6><b>{{ Balance::getBalanceNew($id, ['invite_bonus', 'admin_add']) }} PV /
                            <span class="text-danger">0% </span></b></div>
                    <div class="p-10 b-r">
                        <h6 class="font-light">Бинарный бонус + ЛКБ</h6><b>{{ Balance::getBalanceNew($id, ['turnover_bonus','matching_bonus']) }} PV / <span class="text-danger">0,8% </span></b>
                    </div>
                </div>
            </div>
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
                        <h6 class="font-light">Реферальный бонус</h6><b>{{ Balance::getWeekBalanceByStatusNew($id, ['invite_bonus', 'admin_add']) }} PV</b></div>
                    <div class="p-10 b-r">
                        <h6 class="font-light">Бинарный бонус + ЛКБ</h6><b>{{ Balance::getWeekBalanceByStatusNew($id, ['turnover_bonus','matching_bonus']) }} PV</b>
                    </div>
                </div>
            </div>
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
                        <h6 class="font-light">Реферальный бонус</h6><b>{{ Balance::getBalanceOutNew($id, ['invite_bonus', 'admin_add']) }} PV</b></div>
                    <div class="p-10 b-r">
                        <h6 class="font-light">Бинарный бонус + ЛКБ</h6><b>{{ Balance::getBalanceOutNew($id, ['turnover_bonus','matching_bonus']) }} PV</b>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
