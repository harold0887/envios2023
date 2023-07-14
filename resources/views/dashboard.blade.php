@extends('layouts.app', ['activePage' => 'dashboard',
'menuParent' => 'dashboard',
'title' => __('Dashboard'),
'navbarClass'=>'text-primary'
])


@section('content')
@include('includes.settings')

<livewire:dashboard-render />


@endsection

@push('js')
<script>
  $(document).ready(function() {
    // Javascript method's body can be found in assets/js/demos.js
    md.initDashboardPageCharts();

    md.initVectorMap();

  });
</script>
@endpush