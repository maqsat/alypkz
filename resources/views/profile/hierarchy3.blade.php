@extends('layouts.profile')

@section('in_content')

    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">

            <!-- partial:index.partial.html -->
            <div class="body user-body user-scroll">
                <div class="user-tree">
                    <ul class="parent-tree">
                        <li>
                            <a href="javascript:void(0);">
                                <div class="member-view-box">
                                    <div class="member-image">
                                        <img src="{{$user->photo}}" alt="" class="bg-red">
                                    </div>
                                    <div class="member-details">
                                        <h6>{{ $user->name }}</h6>
                                        <p>{{ \App\Facades\Hierarchy::getStatusName($user->id) }} | {{ \App\Facades\Hierarchy::getPackageName($user->id) }}</p>
                                        <p>id: {{ $user->id }} | <i class="mdi mdi-account-multiple-plus"></i> {{ \App\Facades\Hierarchy::inviterCount($user->id) }} | <i class="mdi mdi-sitemap"></i> {{ \App\Facades\Hierarchy::teamCount($user->id) }}</p>
                                        <p>PV {{ \App\Facades\Hierarchy::pvCounter($user->id,2) }} | PV {{ \App\Facades\Hierarchy::pvCounter($user->id,1) }}</p>
                                    </div>
                                </div>
                            </a>
                            {!! \App\Facades\Hierarchy::getHierarchyBinarTree($user->id) !!}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('body-class')
    fix-header card-no-border fix-sidebar
@endsection

@push('styles')
    <link rel="stylesheet" href="/user-tree-view/dist/style.css">
@endpush

@push('scripts')
    <!-- partial -->

    <script  src="/user-tree-view/dist/script.js"></script>
    <script>
        $('#child'+{{$user->id}}).addClass('active');
    </script>

@endpush
