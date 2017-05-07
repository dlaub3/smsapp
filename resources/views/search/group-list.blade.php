
@if (count($groups) > 0)
    @foreach ($groups as $group)
        <div class="panel panel-primary">
          <div class="panel-heading">
              {{ $group->name}}
          </div>
          <div class="panel-body text-center">
            <a href="join/{{$group->slug}}">
              <button class="btn btn-primary">
                <i class="glyphicon glyphicon-plus" aria-hidden="true"></i>
                Join
              </button>
            </a>
          </div>
        </div>
    @endforeach
@else
  <h4> Nothing Found for: {{$for}} </h4>
@endif
