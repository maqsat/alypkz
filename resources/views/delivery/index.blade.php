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
                            <form action="/delivery">
                                <div class="row">
                                    <div class="col-lg-12 m-b-10">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="s" placeholder="Поиск по полям логин, спонсор, имя ..." value="{{ old('s',app('request')->input('s')) }}">
                                            <span class="input-group-btn">
                                                <button class="btn btn-info" type="submit">Искать!</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <form action="/delivery">
                                <div class="row">
                                    <div class="col-lg-2">
                                        <div class="input-group">
                                            <div class="input-group" >
                                                <select class="custom-select form-control required" id="package_id" name="package_id">
                                                    <option  value="0">Пакет</option>
                                                    @foreach(\App\Models\Package::where('status',1)->get() as $item)
                                                        <option value="{{ $item->id }}" @if(old('s',app('request')->input('package_id')) == $item->id) selected @endif>{{ $item->title }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('package_id'))
                                                    <span class="text-danger"><small>{{ $errors->first('package_id') }}</small></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <div class="input-group" >
                                                <select class="custom-select form-control required" name="delivery_status" required>
                                                    <option value="0">Статус доставки</option>
                                                    <option value="3">Оформление</option>
                                                    <option value="2">Отправлен</option>
                                                    <option value="1">Доставлен</option>
                                                </select>
                                                @if ($errors->has('status_id'))
                                                    <span class="text-danger"><small>{{ $errors->first('status_id') }}</small></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="input-group">
                                            <div class="input-group">
                                                <select class="form-control form-control-line" name="country_id" onchange="getCities(this)">
                                                    <option  value="0">Страна</option>
                                                    @foreach(\App\Models\Country::all() as $item)
                                                        <option value="{{ $item->id }}" @if(old('s',app('request')->input('status_id'))  == $item->id) selected @endif>{{ $item->title }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('country_id'))
                                                    <span class="text-danger"><small>{{ $errors->first('country_id') }}</small></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="input-group">
                                            <div class="input-group">
                                                <select class="custom-select form-control required" id="city_id" name="city_id">
                                                    <option value="0">Город</option>
                                                    @foreach(\App\Models\City::where('status',1)->where('country_id',1)->get() as $item)
                                                        <option value="{{ $item->id }}" @if(old('s',app('request')->input('status_id')) == $item->id) selected @endif>{{ $item->title }}</option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('city_id'))
                                                    <span class="text-danger"><small>{{ $errors->first('city_id') }}</small></span>
                                                @endif
                                            </div>

                                            <span class="input-group-btn">
                                                <button class="btn btn-info" type="submit">Филтровать!</button>
                                            </span>

                                            <span class="input-group-btn">
                                                <a href="/delivery" class="btn btn-warning" type="submit">Сбросить!</a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <br>
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
                                               Пакет: <span class="label label-info">{{ \App\Models\Package::find($item->package_id)->title }} </span> <br>
                                               Дата регистрации: {{ $item->created_at }}
                                           </td>

                                           <td  style="width:200px;">{{ \App\Models\Country::find($item->country_id)->title }}, {{ \App\Models\City::find($item->city_id)->title }},  {{ $item->address }}</td>
                                           <td>
                                               Почтовой индекс: {{ $item->post_index }}  <br>
                                               Трекинг номер: @if(!is_null($order))
                                                                    {{ $order->trucking }}
                                                              @endif  <br>
                                               @php $courier = \App\User::find($order->courier_id); @endphp
                                               Ответственный: @if(!is_null($courier)) {{ $courier->name }} @endif

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
                            {{ $users->appends(request()->input())->links() }}
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

        function getCities(country_id) {
            $.ajax({
                type: "GET",
                url: "/partner/user/cities",
                data: 'country_id='+country_id.value,
                success: function (data) {
                    console.log('Submission was successful.');
                    console.log(data);

                    $('#city_id')
                        .find('option')
                        .remove()
                        .end()
                        .append(data)
                        .val('whatever')
                    ;

                },
                error: function (data) {
                    console.log('An error occurred.');
                    console.log(data);
                },
            });
        }

        $('select').prop('selectedIndex', 0);

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

