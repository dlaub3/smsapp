@extends('layouts.app')

@section('content')
    <div class="container" id="container">

      <div class="col-sm-offset-1 col-sm-10">
        {{-- if there is no session data  don't show the form --}}
        @if (session()->has('success'))
            <div class="panel panel-success">
              <div class="panel-heading">
                <h4>
                    Status:
                </h4>
              </div>
                <div class="panel-body">
                    <div class="title m-b-md">
                      You have successfully joined the group.
                    </div>
                </div>
                <div class="panel-footer">
                </div>

            </div>
      @else
        <h1>Your session has expired.</h1>
      @endif

      </div>
    </div>

@endsection
