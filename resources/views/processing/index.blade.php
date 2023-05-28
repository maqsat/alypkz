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
                    <h3 class="text-themecolor m-b-0 m-t-0">{{ __('app.processing') }}</h3>
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

            <form method="get" class="form-horizontal user_create">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-4">
                        <label class="m-t-10">Дата фильтрации c:</label>
                        <div class="input-group">
                            <input type="date" name="date_from" value="{{ old('date_from', date('Y-m-d'))}}" class="form-control form-control-line" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="m-t-10">Дата фильтрации до:</label>
                        <div class="input-group">
                            <input type="date" name="date_to" value="{{ old('date_to', date('Y-m-d')) }}" class="form-control form-control-line" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="m-t-10"></label>
                        <span class="input-group-btn m-t-10">
                            <button class="btn btn-info" type="submit">Отправить</button>
                        </span>
                    </div>
                </div>
                <hr>
            </form>


            <div class="row">
                <!-- Column -->
                <div class="col-lg-4 col-md-4">
                    <div class="card">
                        <div class="d-flex flex-row">
                            <div class="p-10 bg-info">
                                <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                            <div class="align-self-center m-l-20">
                                <h3 class="m-b-0 text-info">{{ number_format($register+$upgrade, 0, '', ' ') }}</h3>
                                <h5 class="text-muted m-b-0">Сумма комиссионных</h5></div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-4 col-md-4">
                    <div class="card">
                        <div class="d-flex flex-row">
                            <div class="p-10 bg-success">
                                <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                            <div class="align-self-center m-l-20">
                                <h3 class="m-b-0 text-success">{{ number_format($out+$shop, 0, '', ' ') }}</h3>
                                <h5 class="text-muted m-b-0">Выведено</h5></div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-4 col-md-4">
                    <div class="card">
                        <div class="d-flex flex-row">
                            <div class="p-10 bg-inverse">
                                <h3 class="text-white box m-b-0"><i class="ti-wallet"></i></h3></div>
                            <div class="align-self-center m-l-20">
                                <h3 class="m-b-0">{{ number_format($commission, 0, '', ' ') }}</h3>
                                <h5 class="text-muted m-b-0">Комиссионные на балансах</h5></div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
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
                                        @if(isset($_GET['status']) && $_GET['status'] == 'request')<th>Ответ</th>@endif
                                        <th>Сумма</th>
                                        <th>От кого</th>
                                        <th>Отправитель</th>
                                        <th>Номер карты</th>
                                        <th>Метод вывода</th>
                                        <th>Дата</th>
                                        <th>Действие</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($list as $item)
                                        <tr>
                                            <td class="text-center">{{ $item->id }}</td>
                                            <td>
                                                @include('processing.processing-title')
                                            </td>
                                            @if(isset($_GET['status'])  && $_GET['status'] == 'request')
                                                <td  class="actions">
                                                    <form action="/processing/{{ $item->id }}" method="POST" style="display: inline-block;">
                                                        {{ csrf_field() }}
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="out">
                                                        <button class="btn btn-success" type="submit"><i class="mdi mdi-check"></i></button>
                                                    </form>
                                                    <form action="/processing/{{ $item->id }}" method="POST"  style="display: inline-block;">
                                                        {{ csrf_field() }}
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="cancel">
                                                        <button class="btn btn-danger" type="submit"><i class="mdi mdi-close"></i></button>
                                                    </form>
                                                </td>
                                            @endif
                                            <td><span class="text-success">{{ round($item->sum,2) }} PV ({{ $item->limited_sum }}$)</span></td>
                                            <?php
                                                $in_user = \App\User::find($item->in_user);
                                                $user_id = \App\User::find($item->user_id);
                                            ?>
                                            <td class="txt-oflo">@if(!is_null($user_id)) {{ $user_id->name }} @else Не найден @endif </td>
                                            <td class="txt-oflo">@if(!is_null($in_user)) {{ $in_user->name }} @else {{ $item->in_user }} @endif @if($item->status == 'matching_bonus') <i>{{ $item->matching_line }} линия</i> @endif  </td>
                                            <td>{{ $item->card_number }}</td>
                                            <td>@if($item->withdrawal_method === '2') Расчётный счёт @else Наличный счет @endif</td>
                                            <td class="txt-oflo">{{ $item->created_at }}</td>
                                            <td class="actions">
                                                <a href="/user/{{ $user_id->id }}/processing" target="_blank" class="btn  btn-xs btn-success"  title="Финансы"><i class="mdi mdi-cash-multiple"></i></a>
                                                <a href="/user/{{ $user_id->id }}" target="_blank" class="btn  btn-xs btn-info"   title="Зайти под"><i class="mdi mdi-eye"></i></a>
                                                <a href="/profile?user_id={{ $user_id->id }}" target="_blank" class="btn  btn-xs btn-warning    "   title="Зайти под"><i class="mdi mdi-account"></i></a>

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if(isset($_GET['status']))
                                {{ $list->appends(['status' => $_GET['status']])->links() }}
                            @else
                                {{ $list->appends(request()->input())->links() }}
                            @endif
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


@push('styles')
    <style>
    .table td, .table th {
            padding: .25rem .15rem;
        }
    </style>
    <link href="/monster_admin/assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">
@endpush


@push('scripts')
    @if ($errors->has('login'))

        <script src="/monster_admin/main/js/toastr.js"></script>
        <script src="/monster_admin/assets/plugins/toast-master/js/jquery.toast.js"></script>
        @foreach ($errors->all() as $error)
            <script>
                $.toast({
                    heading: '{{ __('app.errors in login') }}',
                    text: '{{ $errors->first('login') }}',
                    position: 'top-left',
                    loaderBg:'#ffffff',
                    icon: 'warning',
                    hideAfter: 30000,
                    stack: 6
                });
            </script>
        @endforeach
    @endif
@endpush

