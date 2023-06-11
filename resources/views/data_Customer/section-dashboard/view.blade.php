@extends('layouts.master')
@section('content')

<style>
.scroller::-webkit-scrollbar
  {
    width: 12px;
    background-color: #F5F5F5;
  }

.scroller::-webkit-scrollbar-thumb
  {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #ddd;
  }

  .scroller {
    height: 430px;
    overflow-y: scroll;
    overflow-x: hidden;
  }

    .scroll-slide::-webkit-scrollbar
    {
    height: 10px;
    background-color: #fff;
    }

    .scroll-slide::-webkit-scrollbar-thumb
    {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
    background-color: #fff;
    }
    .scroll-slide {
        overflow-x : scroll;
    }
    .btnBranch:hover{
        scale:1.05;
        transition : 0.3s;
    }
    .btnBranch{
        transition : 0.3s;
    }
</style>

<div class="row">
    <div class="col">
        @include('data_Customer.section-dashboard.tabSearch')
    </div>
  </div>

  <!-- <div class="row">
    <div class="col">
        @include('data_Customer.section-dashboard.cardDuteDate')
    </div>
  </div> -->

  @if(Auth::user()->position == 'admin')
  <div class="row">
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
  @endif

  <div class="row">
    <div class="col">
        @include('data_Customer.section-dashboard.table_dashboard_leader')
    </div>
  </div>
  
@include('data_Customer.script')
@endsection



