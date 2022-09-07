<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-block p-b-0">
                <h4 class="card-title">Доступные операции</h4>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs customtab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#home2" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Вывод наличными</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#home2" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down">Вывод на карту</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#checkingAccount" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> <span class="hidden-xs-down">Вывод на  Расчетный счет(ИП)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#profile2" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Вывод на TRC20</span>
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active   p-20" id="home2" role="tabpanel">
                        <form {{--action="/processing"--}} action="/request" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-control-feedback text-danger" id="demo"></div>
                                    <div class="input-group">
                                        <input type="hidden" value="1" name="program_id">
                                        <input type="hidden" value="1" name="withdrawal_method">

                                        <select class="form-control form-control-line select2" name="type" id="type" onchange="myFunction()">
                                            <option value="1">Реферальный бонус</option>
                                            <option value="2">Бинарный бонус + ЛКБ</option>
                                        </select>
                                        <input type="number"  name="sum" id="sum" class="form-control" placeholder="Выводимая сумма PV" max="{{ Balance::getBalanceNew(Auth::user()->id, ['invite_bonus', 'admin_add']) }}" required onkeyup="myFunction()">
                                        <input type="text"  name="login" class="form-control" placeholder="Номер телефона и карты Kaspi" required>
                                        <span class="input-group-btn">
                                            <button class="btn btn-info" type="submit">Вывести</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </form>
                    </div>
                    <div class="tab-pane  p-20" id="checkingAccount" role="tabpanel">
                        <form {{--action="/processing"--}} action="/request" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-control-feedback text-danger" id="demo2"></div>
                                    <div class="input-group">
                                        <input type="hidden" value="1" name="program_id">
                                        <input type="hidden" value="2" name="withdrawal_method">
                                        <select class="form-control form-control-line select2" name="type" id="type2" onchange="myFunction2()">
                                            <option value="1">Реферальный бонус</option>
                                            <option value="2">Бинарный бонус + ЛКБ</option>
                                        </select>
                                        <input type="number"  name="sum" id="sum2"  class="form-control" placeholder="Выводимая сумма" max="{{ Balance::getBalanceNew(Auth::user()->id, ['turnover_bonus','matching_bonus']) }}"  onkeyup="myFunction2()" required>
                                        <input type="text"  name="login" class="form-control" placeholder="Номер расчетного счёта" required>
                                        <input type="text"  name="iin" class="form-control" placeholder="ИИН" required>
                                        <span class="input-group-btn">
                                            <button class="btn btn-info" type="submit">Вывести</button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </form>
                    </div>
                    <div class="tab-pane  p-20" id="profile2" role="tabpanel">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function myFunction() {
        if(document.getElementById("type").value == 1) {
            var x = 1;
            document.getElementById("sum").max = {{ Balance::getBalanceNew(Auth::user()->id, ['invite_bonus', 'admin_add']) }};
            document.getElementById("demo").innerHTML = "Сумма PV*1$: " + document.getElementById("sum").value * x + "$";
        }
        else {
            var x = 0.8;
            document.getElementById("sum").max = {{ Balance::getBalanceNew(Auth::user()->id, ['turnover_bonus','matching_bonus']) }};
            document.getElementById("demo").innerHTML = "Сумма PV*0,8$: " + document.getElementById("sum").value * x + "$";
        }

    }

    function myFunction2() {
        if(document.getElementById("type2").value == 1) {
            var x = 1;
            document.getElementById("sum2").max = {{ Balance::getBalanceNew(Auth::user()->id, ['invite_bonus', 'admin_add']) }};
            document.getElementById("demo2").innerHTML = "Сумма PV*1$: " + document.getElementById("sum2").value * x + "$";
        }
        else {
            var x = 0.8;
            document.getElementById("sum2").max = {{ Balance::getBalanceNew(Auth::user()->id, ['turnover_bonus','matching_bonus']) }};
            document.getElementById("demo2").innerHTML = "Сумма PV*0,8$: " + document.getElementById("sum2").value * x + "$";
        }


    }
</script>
