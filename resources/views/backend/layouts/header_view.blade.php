
<div id="header">
    <nav class="navbar navbar-fixed-top white-bg show-menu-full" id="nav" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn" href="javascript:void(0)"><i class="fa fa-bars" style="font-size:27px;color:#00695f;"></i></a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            <li class="dropdown hidden-xs">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-envelope"></i>
                </a>
                <ul class="dropdown-menu dropdown-messages">
                    <li>
                        <div class="dropdown-messages-box">

                            <div class="animated animated-short fadeInUp">
                                <small class="pull-right"> 12d ago</small>
                                <strong></strong><br>Lorem ipsum dolor sit amet consectetur adipisicing elit.  <br>
                                <small class="text-muted">26/01/2021</small>
                            </div>
                        </div>
                    </li>


                    <li class="divider"></li>
                    <li>
                        <div class="text-center link-block">
                            <a href="#" class="animated animated-short fadeInUp">
                                <i class="fa fa-envelope"></i> <strong>Read All Messages</strong>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>

            <li class="dropdown pull-right">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                    <span class="pl15">{{ Auth::user()->name }}</span>
                    <span class="caret caret-tp"></span>
                </a>
                <ul class="dropdown-menu animated m-t-xs">
                    <li><a href="{{ url('admin/users/change-password')}}" class="animated animated-short fadeInUp"><i class="fa fa-lock"></i> Ubah Password</a></li>
                    <li class="divider"></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();" id="btn-logout" class="animated animated-short fadeInUp"><i class="fa fa-sign-out"></i> Logout</a></li>

                    <form id="formLogout" method="POST" action="{{ route('logout') }}" style="display: block;">
                        {{ csrf_field() }}
                    </form>
                </ul>
            </li>
        </ul>
    </nav>
</div>
