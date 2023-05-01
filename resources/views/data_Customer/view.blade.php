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
  <div class="row">
    <div class="col">
      @include('data_Customer.section-card.card-dataleader')
    </div>
  </div>
  <div class="row">
    <div class="col">
        @include('data_Customer.section-table.table_Cus')
    </div>
  </div>
  
    @include('data_Customer.script')

@endsection

@section('modal')

<div class="modal fade" id="modal-xl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-lg">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="modal-md">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-body">
        </div>
      </div>
    </div>
  </div>



  <!-- Modal -->
<div class="modal fade " id="modal-sm"  data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered ">
    <div class="modal-content bg-transparent" style="border:0;">
      <div class="modal-body">
        ...
      </div>
    </div>
  </div>
</div>
  
@endsection

