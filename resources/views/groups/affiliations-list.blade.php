@extends('layouts.app')
@section('content')
<div class="container" id="container">

  <div class="col-sm-offset-1 col-sm-10">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3>  Manage Your Group Affiliations </h3>
      </div>
      <div class="panel-body">
        @if (count($affiliations) > 0)
        @foreach ($affiliations as $affiliate)
        <div class="panel panel-primary">
          <div class="panel-heading">
            <div> {{$affiliate->userGroups->name}}</div>
          </div>
          <div class="panel-body">
            <form action="{{ url('/affilition/delete/' . $affiliate->id) }}" method="POST" class="pull-right">
              {{ csrf_field() }} {{ method_field('DELETE') }}

              <button type="submit" class="btn btn-danger btn-raised">
                <i class="glyphicon glyphicon-trash" aria-hidden="true">
                </i>  Leave
              </button>
            </form>
          </div>
        </div>
       @endforeach
      @else
        <h4> You have not joined any groups.</h4>
      @endif
      </div>
      <div class="panel-footer">
        <a href="{{ url('dashboard') }}">
          <button type="submit" class="btn btn-primary">
        <i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i>
            Back
          </button>
        </a>
      </div>
    </div>
  </div>
</div>
@endsection
