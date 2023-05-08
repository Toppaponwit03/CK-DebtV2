@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col">
        @include('data_Customer.section-dashboard.tabSearch')
    </div>
  </div>

  <div class="row px-4">
    <div class="col">
      <div class="card mb-2 pt-3 border border-white shadow-sm">
        @include('data_Customer.section-dashboard.barchartTeam')
      </div>
    </div>
    <!-- <div class="col-6">
      <div class="card mb-2 pt-3 border border-white shadow-sm">
        @include('data_Customer.section-dashboard.barchartGroupdebt')
      </div>
    </div> -->
  </div>

  <div class="row">
    <div class="col">
        @include('data_Customer.section-dashboard.table_dashboard_leader')
    </div>
  </div>
  
@include('data_Customer.script')
@endsection



