@if (count($group->groupUsers) > 0)
@foreach ($group->groupUsers as $user)
@if ($user->is_admin_approved === 0)
{{-- {{dd($errors)}} --}}
 <div class="panel panel-warning">
   <div class="panel-heading">
     <h5>You need to approve {{$user->name}}</h5>
   </div>
   <div class="panel-body">

     <!-- Approve User Info Form -->
     <form action="{{ url('my-groups/user/approve/' . $user->id ) }}" method="POST" class="form-horizontal" name="update-user">
       {{ csrf_field() }}

       <!-- User Name -->
       <div class="form-group">
         <label for="group-user-name" class="col-sm-3 control-label">
           User Name
         </label>
         <div class="col-sm-6">

           <input type="text" name="name[{{$user->id}}]" class="form-control" value="{{$user->name}}">
           @if ($errors->has('name.' . $user->id))
             <p class="alert alert-dismissible alert-danger">
               <strong>{{ $errors->first('name.' . $user->id) }}</strong>
             </p>
           @endif
         </div>
       </div>

       <!-- Add User Cell Number -->
       <div class="form-group">
         <label for="group-user-number" class="col-sm-3 control-label">Cell Number</label>
         <div class="col-sm-6">
           <input type="tel" name="phone_number[{{$user->id}}]" class="form-control" value="{{ $user->phone_number }}">
           @if ($errors->has('phone_number.' . $user->id))
           <p class="alert alert-dismissible alert-danger">
             <strong>{{ $errors->first('phone_number.' . $user->id) }}</strong>
           </p>
           @endif
         </div>
       </div>

       <!-- Approve User Button -->
       <div class="form-group">
         <div class="col-sm-offset-3 col-sm-6">
           <button type="submit" class="btn btn-primary">
             <i class="glyphicon glyphicon-ok" aria-hidden="true"></i>
               Approve
           </button>
         </div>
       </div>
     </form>

     <form action="{{ url('my-groups/user/delete/' . $user->id) }}" method="POST">
       {{ csrf_field() }} {{ method_field('DELETE') }}
       <button type="submit" class="btn btn-danger btn-raised pull-right">
         <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>
         Remove
       </button>
     </form>
   </div>
 </div>
@else
 <a href="{{url('my-groups/user/update/' . $user->id)}}">
   <div class="btn btn-primary btn-block">
     <form action="{{ url('my-groups/user/delete/' . $user->id) }}" method="POST">
       {{ csrf_field() }} {{ method_field('DELETE') }}

       <button type="submit" class="btn btn-danger btn-raised pull-right">
             <i class="glyphicon glyphicon-trash" aria-hidden="true"></i>Remove
         </button>
     </form>
     <h3><i class="glyphicon glyphicon-user" aria-hidden="true"></i>{{$user->name}}</h3>
   </div>
 </a>
@endif @endforeach
@endif
