@extends('layouts.app') @section('content')
<div class="container" id="container">

  <div class="col-sm-offset-1 col-sm-10">

    <div class="panel panel-primary">
      <div class="panel-heading">
        <div class="panel-title">
          <h1 >Search Results</h1>
        </div>
      </div>
      {{-- The Algolia logo is required for the free account--}}
      <img style="margin: 10px;" src="{{asset('storage/images/algolia-logo.png')}}" >
      <div class="panel-body text-center">

        <!-- Current Groups -->
        @include('search.group-list')

      </div>
    </div>
  </div>
</div>

@endsection
