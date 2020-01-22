<li class="dropdown user user-menu">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    Welcome ,
    <span class="hidden-xs">
        @if(Sentinel::check())
          {{ Sentinel::getUser()->first_name }}  {{ Sentinel::getUser()->last_name }}
        @endif
    </span>
  </a>
  <ul class="dropdown-menu">
    <!-- User image -->
    <li class="user-header">
      <p>
        @if(Sentinel::check())
          {{ Sentinel::getUser()->first_name }}  {{ Sentinel::getUser()->last_name }}
        @endif
      </p>
    </li>
    <!-- Menu Footer-->
    <li class="user-footer">
      <!-- <div class="pull-left">
        <a href="#" class="btn btn-default btn-flat">Profile</a>
      </div> -->
      <div class="pull-left">
        <a href="{{ url('user/change-my-password') }}" class="btn btn-default btn-flat">Change Password</a>
      </div>
      <div class="pull-right">
        <a href="{{ url('user/logout') }}" class="btn btn-default btn-flat">Sign out</a>
      </div>
    </li>
  </ul>
</li>