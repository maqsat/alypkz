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
                    <h3 class="text-themecolor m-b-0 m-t-0">Доставка</h3>
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
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-block">
                            <form action="/user">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="s" placeholder="Поиск по полям логин, спонсор, имя ..." value="{{ old('s',app('request')->input('s')) }}">
                                            <span class="input-group-btn">
                                                <button class="btn btn-info" type="submit">Искать!</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <!-- form-group -->
                            </form>
                            <div class="table-responsive">
                                <table class="table color-table success-table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Данные пользователя</th>
                                            <th>Адрес</th>
                                            <th>Доставка</th>
                                            <th>Телефон</th>
                                            <th>Статус</th>
                                            <th>Действие</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $key => $item)
                                        @php
                                            $order =  \App\Models\Order::where('user_id',$item->id)->where('type', 'register')->first();
                                        @endphp
                                       <tr>
                                           <td>{{ $item->id }}</td>
                                           <td>
                                               ФИО: {{ $item->name }} <br>
                                               Пакет: {{ \App\Models\Package::find($item->package_id)->title }} <br>
                                               Дата регистрации: {{ $item->created_at }}
                                           </td>

                                           <td  style="width:200px;">{{ \App\Models\Country::find($item->country_id)->title }}, {{ \App\Models\City::find($item->city_id)->title }},  {{ $item->address }}</td>
                                           <td>
                                               Почтовой индекс: {{ $item->post_index }}  <br>
                                               Трекинг номер: @if(!is_null($order))
                                                                    {{ $order->trucking }}
                                                              @endif

                                           </td>
                                           <td>{{ $item->number }}</td>
                                           <td>
                                               @if(!is_null($order))
                                                   @if($order->delivery_status == 1)
                                                       <span class="label label-light-success">Доставлен</span></td>
                                           @elseif($order->delivery_status == 2)
                                               <span class="label label-light-warning">Отправлен</span></td>
                                           @else
                                               <span class="label label-light-danger">Оформление</span></td>
                                           @endif
                                           @else
                                               <span class="label label-light-danger">Формироваание</span></td>
                                           @endif

                                           <td><a href="/delivery/{{ $item->id }}/edit" class="btn btn-success"><i class="mdi mdi-grease-pencil"></i></a></td>
                                       </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        @include('layouts.footer')
    </div>
@endsection

@section('body-class')
    fix-header card-no-border fix-sidebar
@endsection


@push('styles')
    <style>
    .table td, .table th {
        padding: 8px 7px;
        font-size: 14px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function deleteAlert() {
            if(!confirm("Вы уверены что хотите удалить?"))
                event.preventDefault();
        }
    </script>

    @if (session('status'))
        <script>
            $.toast({
                heading: 'Результат действии',
                text: '{{ session('status') }}',
                position: 'top-left',
                loaderBg:'#ffffff',
                icon: 'warning',
                hideAfter: 30000,
                stack: 6
            });
        </script>
    @endif
@endpush

