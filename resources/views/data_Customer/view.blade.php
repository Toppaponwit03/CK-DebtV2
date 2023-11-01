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



    <!-- hidden input -->
    <input type="hidden" name="position" id="position" value="{{Auth::user()->position}}">
    <input type="hidden" name="Branch" id="Branch" value="{{ @Auth::user()->UserToPrivilege->branch }}">

  <div class="row">
    <div class="col">
      @include('data_Customer.section-card.card-Branch')
    </div>
  </div>
    @if(@Auth::user()->UserToPrivilege->datafilter == 'yes')
    <div class="row">
      <div class="col">
        @include('data_Customer.section-card.card-dataleader')
      </div>
    </div>
   @endif

  <div class="row">
    <div class="col">
        @include('data_Customer.section-table.table_Cus')
    </div>
  </div>

    @include('data_Customer.script')

@endsection



