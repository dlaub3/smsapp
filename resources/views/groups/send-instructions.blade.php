<div class="panel panel-primary" style="margin-bottom: 5px;">
  <div class="panel-heading">
    <a href="#send-{{$group->id}}" data-toggle="collapse" data-parent="#messageupdate">
      <button class="btn btn-primary btn-raised">
        <i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Send A Message
      </button>
    </a>
  </div>

  <div id="send-{{$group->id}}" class="panel-collapse collapse">
    <div class="panel-body">

      <!-- New Group Form -->
      <form action="{{ url('my-groups/send-message/' . $group->slug ) }}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- Message Content -->
        <div class="form-group">
          <label for="group-user-name" class="col-sm-3 control-label">
            Message
          </label>
          <div class="col-sm-6">
            <input type="textarea" name="message" class="form-control" value="{{ old('message') }}">
            @if ($errors->has('message'))
            <p class="alert alert-dismissible alert-danger">
              <strong>{{ $errors->first('message') }}</strong>
            </p>
            @endif
          </div>
        </div>

        <!-- Send Button -->
        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-6">
            <button type="submit" class="btn btn-primary  ">
            <i class="glyphicon glyphicon-send" aria-hidden="true"></i>
              Send Message
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
