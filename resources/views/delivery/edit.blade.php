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
                    <h3 class="text-themecolor m-b-0 m-t-0">Статус доставки</h3>
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
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $key => $item)
                                    @php $order =  \App\Models\Order::where('user_id',$item->id)->first() @endphp
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
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="card-block">
                            <form action="{{url('delivery', [$order->id])}}" method="POST" class="form-horizontal form-material">
                                {{ method_field('PATCH') }}
                                {{ csrf_field() }}
                                <input type="hidden" value="{{ $order->id }}" name="order_id">
                                <div class="form-group">
                                    <label class="col-md-12">Номер трекинга</label>
                                    <div class="col-md-12">
                                        <input type="text" value="{{ $order->trucking }}" name="trucking" class="form-control form-control-line" required>
                                        @if ($errors->has('trucking'))
                                            <span class="help-block"><small>{{ $errors->first('trucking') }}</small></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Статус доставки</label>
                                    <div class="col-md-12">
                                        <select class="custom-select form-control required" name="delivery_status" required>
                                            <option value="0" @if(0 == $order->delivery_status) selected @endif>Оформление</option>
                                            <option value="2" @if(2 == $order->delivery_status) selected @endif>Отправлен</option>
                                            <option value="1" @if(1 == $order->delivery_status) selected @endif>Доставлен</option>
                                        </select>
                                        @if ($errors->has('title'))
                                            <span class="help-block"><small>{{ $errors->first('title') }}</small></span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <button class="btn btn-success" type="submit">Обновить</button>
                                    </div>
                                </div>
                            </form>
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

@push('scripts')
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

