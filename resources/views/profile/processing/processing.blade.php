@extends('layouts.profile')

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

            @include('profile.processing.main-balance')

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-block">

                        @include('profile.processing.actions')

                        <div class="table-responsive">

                            <table id="demo-foo-pagination" class="table toggle-arrow-tiny" data-page-size="30">
                                <thead>
                                <tr>
                                    <th data-toggle="true">ID #</th>
                                    <th>Статус</th>
                                    <th>Сумма</th>
                                    <th>PV</th>
                                    <th>От кого</th>
                                    <th>Дата</th>
                                    <th  data-hide="all">Пакет дистрибютора</th>
                                    <th  data-hide="all">Номер карты</th>
                                    <th  data-hide="all">Ваш Ранг</th>
                                    <th  data-hide="all">Чек</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($list as $item)
                                    @php
                                        $order = \App\Models\Order::where('user_id', $item->user_id)->where('type','register')->orderBy('id','desc')->first();
                                    @endphp


                                    <tr @if($item->status == 'register' or $item->status == 'cancel'  or $item->status == 'out'  or $item->status == 'revitalization'   or $item->status == 'request' or $item->status == 'remove')
                                        style="color: #009efb"
                                        @else
                                        style="color: #5cb85c"
                                        @endif>
                                        <td class="text-center">{{ $item->id }}</td>
                                        <td>
                                            @include('processing.processing-title')
                                        </td>
                                        <td>
                                            {{ round($item->sum,2) }} PV
                                            @if($item->status == 'request' or $item->status == 'out')
                                                ({{ $item->limited_sum }}$)
                                            @endif
                                        </td>
                                        <td>{{ $item->pv}} PV</td>
                                        <?php
                                        $in_user = \App\User::find($item->in_user)
                                        ?>
                                        <td class="txt-oflo">
                                            @if(!is_null($in_user)) {{ $in_user->name }} @else {{ $item->in_user }} @endif
                                            @if($item->status == 'matching_bonus') <i>{{ $item->matching_line+1 }} линия</i> @endif
                                        </td>
                                        <td class="txt-oflo">{{ $item->created_at }}</td>
                                        <td>@if(!is_null(\App\Models\Package::find($item->package_id))){{ \App\Models\Package::find($item->package_id)->title }}@endif </td>
                                        <td>{{ $item->card_number }}</td>
                                        <td class="txt-oflo">@if(!is_null(\App\Models\Status::find($item->status_id))){{ \App\Models\Status::find($item->status_id)->title }}@endif</td>
                                        <td>
                                            @if(!is_null($order) && $order->status == 11)
                                                <a href="{{asset($order->scan)}}" target="_blank" class="btn btn-xs btn-primary"><i class="mdi mdi-account-search"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr  style="display: none">
                                    <td colspan="5">
                                        <div class="text-right">
                                            <ul class="pagination pagination-split m-t-30"> </ul>
                                        </div>
                                    </td>
                                </tr>
                                </tfoot>
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

@push('styles')
<!-- Footable CSS -->
<link href="/monster_admin/assets/plugins/footable/css/footable.core.css" rel="stylesheet">
<link href="/monster_admin/assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
@endpush

@push('scripts')

    <!-- Footable -->
    <script src="/monster_admin/assets/plugins/footable/js/footable.all.min.js"></script>
    <script src="/monster_admin/assets/plugins/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <!--FooTable init-->
    <script src="/monster_admin/main/js/footable-init.js"></script>



    @if (session('status'))
        <script>
            $.toast({
                heading: 'Вывод средств',
                text: '{{ session('status') }}',
                position: 'top-right',
                loaderBg:'#ffffff',
                icon: 'success',
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
                    icon: 'success',
                    hideAfter: 30000,
                    stack: 6
                });
            </script>
        @endforeach
    @endif
@endpush
