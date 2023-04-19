@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col">
        @include('data_Customer.section-dashboard.tabSearch')
    </div>
  </div>

  <div class="row">
    <div class="col">
        @include('data_Customer.section-dashboard.table_dashboard_leader')
    </div>
  </div>
  
@include('data_Customer.script')
@endsection



