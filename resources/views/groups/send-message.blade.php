<div class="panel panel-primary"  style="margin-bottom: 5px;">
  <div class="panel-heading  radius">
    <a href="#send-{{$group->id}}" data-toggle="collapse" data-parent="#messageupdate">
      <button class="btn btn-primary btn-raised">
        <i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> Send A Message
      </button>
    </a>
  </div>

  <div id="send-{{$group->id}}" class="panel-collapse collapse
    {{-- If there are errors this form remains open. --}}
    @if ($errors->first('message') || $errors->first('message'))
      in
    @endif">
    <div class="panel-body">
      <div class="alert alert-dismissible alert-info"><h4> You can also send messages by texting {{env('TWILIO_NUMBER')}} the message: {{$group->slug}}@your message</h4> </div>
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
