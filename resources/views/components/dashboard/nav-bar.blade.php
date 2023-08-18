<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
  <div class="container-fluid">
    <div class="navbar-wrapper">
      <a class="navbar-brand" href="javascript:;">Dashboard</a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="sr-only">Toggle navigation</span>
      <span class="navbar-toggler-icon icon-bar"></span>
      <span class="navbar-toggler-icon icon-bar"></span>
      <span class="navbar-toggler-icon icon-bar"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <i class="material-icons">person</i>{{ Auth::user()->name }}
            @if (Auth::user()->hasNotification())
            <span class="badge badge-danger">{{ sizeOf(auth()->user()->notifications()->where('status','unread')->get())
              }}</span>
            @endif
            <p class="d-lg-none d-md-block">
              Account
            </p>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
            <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
            <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault();document.getElementById('logout-form').submit();">Log out</a>
            <a class="dropdown-item" href="{{ route('notificatoion') }}">notification</a>
            <button class="dropdown-item" onclick="changepassword({{ auth()->user() }})">change password</button>
          </div>
        </li>
      </ul>

    </div>

  </div>

</nav>
<div class="modal fade" id="changepassword" tabindex="-1" role="dialog" aria-labelledby="changepassword"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        Change Password
      </div>
      <div class="modal-body">
        <form action="{{ route('profile.password') }}" method="POST">
          @csrf
          @method('put')
          <div class="form-group">
            <label for="current_password">current password</label><br>
            <input type="password" id="current_password" name="old_password"><br>
            @if ($errors->has('old_password'))
              <div class="danger">{{ $error->first('old_password') }}</div>
            @endif
            <label for="new_passowrd">new password</label><br>
            <input type="password" id="new_password" name="password"><br>
            @if ($errors->has('password'))
              <div class="danger">{{ $errors->first('password') }}</div>
            @endif
            <label for="password confirmation">Confirm password</label><br>
            <input type="text" name="password confirmation">

          </div>
          <button type="submit" class="btn btn success">save</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function changepassword(user)
{
  $('#changepassword').modal('show');
}
</script>