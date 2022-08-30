@extends('layouts.admin')

@section('in_content')
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-6 col-8 align-self-center">
                    <h3 class="text-themecolor m-b-0 m-t-0">Процессинг - {{ $user->name }}</h3>
                </div>
                <div class="col-md-6 col-4 align-self-center">
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->

            @include('profile.processing.main-balance')

            <div class="row">
                <!-- Column -->
                <div class="col-md-6 col-lg-6 col-xlg-6">
                    <div class="card card-inverse card-info">
                        <div class="box bg-info text-center">
                            <h1 class="font-light text-white">{{ number_format(Hierarchy::pvCounter($user->id,1), 0, '', ' ') }}</h1>
                            <h6 class="text-white">Левая ветка PV</h6>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <div class="col-md-6 col-lg-6 col-xlg-6">
                    <div class="card card-primary card-inverse">
                        <div class="box text-center">
                            <h1 class="font-light text-white">{{ number_format(Hierarchy::pvCounter($user->id,2), 0, '', ' ') }}</h1>
                            <h6 class="text-white">Правая ветка PV</h6>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <h4 class="card-title  p-t-10 p-l-10">Редактор баланса пользователя</h4>
                        <div class="card-block">
                            <form method="POST" action="/user/{{$id}}/change" class="form-horizontal user_create">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-12">
                                        <label  class="m-t-10" for="description">Описание:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" required name="description" id="description">
                                        </div>
                                        <label  class="m-t-10" for="description">Выберите валюту:</label>
                                        <select class="form-control form-control-line" name="currency_type">
                                           <option value="1">($)</option>
                                           <option value="2">(PV)</option>
                                        </select>
                                        <label  class="m-t-10" for="description">Операция:</label>
                                        <select class="form-control form-control-line" name="operation_type">
                                            <option value="1">Увеличить</option>
                                            <option value="2">Уменьшить</option>
                                        </select>
                                        <label  class="m-t-10" for="sum">Сумма</label>
                                        <div class="input-group">
                                            <input type="number" value="0" class="form-control" required name="sum" id="sum"  min="1" />
                                        </div>
                                        <label  class="m-t-10" for="sum">От кого:</label>
                                        <div class="input-group">
                                            <select name="in_user" class="form-control form-control-line select2" id="in_user">
                                                @foreach($users as $item)
                                                    <option value="{{ $item['id'] }}"{{$item['id'] == $user->id ? ' selected="selected"' : ''}}>{{ $item['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success" type="submit">Отправить</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-block">

                        <div class="table-responsive">
                            <table id="demo-foo-addrow" class="table table-hover no-wrap contact-list" data-page-size="10">
                                <thead>
                                <tr>
                                    <th>ID #</th>
                                    <th>Статус</th>
                                    <th>Сумма</th>
                                    <th>PV</th>
                                    <th>От кого</th>
                                    <th>Пакет дистрибютора</th>
                                    <th>Номер карты</th>
                                    <th>Дата</th>
                                    <th>Ваш Ранг</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $item)
                                    <tr @if($item->status == 'register' or $item->status == 'cancel'  or $item->status == 'out'  or $item->status == 'revitalization'   or $item->status == 'request')
                                        style="color: #f62d51"
                                        @else
                                        style="color: #5cb85c"
                                        @endif>
                                            <td class="text-center">{{ $item->id }}</td>
                                            <td>
                                                @include('processing.processing-title')
                                            </td>
                                            <td>{{ round($item->sum,2) }} $</td>
                                            <td>{{ $item->pv}} PV</td>
                                            <td class="txt-oflo">@if($item->in_user != 0) {{ \App\User::find($item->in_user)->name }} @endif</td>
                                            <td class="txt-oflo">@if($item->package_id != 0) {{ \App\Models\Package::find($item->package_id)->title }} @endif</td>
                                            <td>{{ $item->card_number }}</td>
                                            <td class="txt-oflo">{{ $item->created_at }}</td>
                                            <td class="txt-oflo">@if(!is_null(\App\Models\Status::find($item->status_id))){{ \App\Models\Status::find($item->status_id)->title }}@endif</td>
                                        </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $list->links() }}
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End PAge Content -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        @include('layouts.footer')
        <!-- ============================================================== -->
    </div>
@endsection

@section('body-class')
    fix-header card-no-border fix-sidebar
@endsection

@push('scripts')
    <script src="/monster_admin/main/js/toastr.js"></script>
    <script src="/monster_admin/assets/plugins/toast-master/js/jquery.toast.js"></script>

@if (session('status'))

    <script>
        $.toast({
            heading: 'Вывод средств',
            text: '{{ session('status') }}',
            position: 'top-right',
            loaderBg:'#ffffff',
            icon: 'error',
            hideAfter: 60000,
            stack: 6
        });
    </script>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            $.toast({
                heading: '{{ __('app.errors in login') }}',
                text: '{{ __($error) }}',
                position: 'top-right',
                loaderBg:'#ffffff',
                icon: 'error',
                hideAfter: 30000,
                stack: 6
            });
        </script>
    @endforeach
@endif

@endpush

@push('styles')
<link href="/monster_admin/assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">
@endpush
