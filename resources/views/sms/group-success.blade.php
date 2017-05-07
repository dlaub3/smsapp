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
                      Your message has been sent.
                    </div>
                </div>
                <div class="panel-footer">
                  <a href="{{ url('dashboard') }}">
                    <button type="submit" class="btn btn-primary">
                  <i class="glyphicon glyphicon-arrow-left" aria-hidden="true"></i>
                      Dashboard
                    </button>
                  </a>
                </div>
            </div>
      @else
        <h1>Your session has expired.</h1>
      @endif

      </div>
    </div>

@endsection
