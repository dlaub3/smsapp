@extends('layouts.app') @section('content')
<div class="container" id="container">
  <div class="col-sm-offset-1 col-sm-10">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <i style="font-size: 3em;" class="glyphicon glyphicon-phone float-left threex"></i>
        <h1 style="display:inline-block;">Welcome to {{env('APP_NAME')}}</h1>
      </div>
      <div class="panel-body">
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h2>Perfect for last minute:</h2>
          </div>
          <div class="panel-body">
            <ul>
              <li><h4>Cancellations</h4></li>
              <li><h4>Updates</h4></li>
              <li><h4>Reminders</h4></li>
            </ul>

          </div>
        </div>

        <div class="panel panel-primary">
          <div class="panel-heading">
            <h2>Why use {{env('APP_NAME')}}</h2>
          </div>
          <div class="panel-body">
            <ul>
              <li><h4>SMS messages get out fast.</h4></li>
              <li><h4>Users can join on their own. So you don't have to collect a contact list.</h4></li>
              <li><h4>You won't get caught in a group messaging chat storm.</h4></li>
            </ul>
          </div>
        </div>

        <div class="panel panel-primary">
          <div class="panel-heading">
            <h2>To join a group:</h2>
          </div>
          <div class="panel-body">
            <ul>
              <li><h4>Search for the group name.</h4></li>
              <li><h4>Click 'join' and enter your contact info.</h4></li>
              <li><h4>It's not necessary to have an account when joining a group.</h4></li>
            </ul>
          </div>
        </div>

        <div class="panel panel-primary">
          <div class="panel-heading">
            <h2>To create a group:</h2>
          </div>
          <div class="panel-body">
            <ul>
              <li><h4>Register for an account.</h4></li>
              <li><h4>Create a group.</h4></li>
              <li><h4>Add users to the group.</h4></li>
            </ul>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>


</div>

@endsection
