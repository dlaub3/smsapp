<div class="panel panel-primary" style="margin-bottom: 5px;">
  <div class="panel-heading  radius">
    <a href="#adduser-{{$group->id}}" data-toggle="collapse" data-parent="#messageupdate">
      <button class="btn btn-primary btn-raised">
        <i class="glyphicon glyphicon-user" aria-hidden="true"></i> Add A User
      </button>
    </a>
  </div>

  <div id="adduser-{{$group->id}}" class="panel-collapse collapse
      {{-- If there are errors this form remains open. --}}
      @if ($errors->first('name') || $errors->first('phone_number'))
        in
      @endif">
    <div class="panel-body">
      <div class="alert alert-dismissible alert-info"><h4> Users can also join or leave the group by texting {{env('TWILIO_NUMBER')}} the message:
      <p>
        <ul>
        <li>leave{{'@' . $group->slug}}</li>
        <li>join{{'@' . $group->slug}}@John Doe</li>
      </p>
      </h4>
      </div>
      <!-- New User Form -->
      <form action="{{ url('my-groups/add-user/' . $group->slug) }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- User Name -->
        <div class="form-group">
          <label for="group-user-name" class="col-sm-3 control-label">
                  User Name
                </label>
          <div class="col-sm-6">
            <input type="text" name="name" class="form-control"> @if ($errors->has('name'))
            <p class="alert alert-dismissible alert-danger">
              <strong>{{ $errors->first('name') }}</strong>
            </p>
            @endif
          </div>
        </div>

        <!-- Add User Cell Number -->
        <div class="form-group">
          <label for="group-user-number" class="col-sm-3 control-label">
              Cell Number
            </label>
          <div class="col-sm-6">
            <input type="tel" name="phone_number" class="form-control">
            @if ($errors->has('phone_number'))
            <p class="alert alert-dismissible alert-danger">
              <strong>{{ $errors->first('phone_number') }}</strong>
            </p>
            @endif
          </div>
        </div>

        <!-- Add User Button -->
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-6">
            <button type="submit" class="btn btn-primary">
              <i class="glyphicon glyphicon-plus" aria-hidden="true"></i>
                        Add User
                    </button>
          </div>
        </div>
      </form>

    </div>
  </div>
</div>
