<div class="header-bof">
    <div class="row txtWhite12">
      <div class="col-xs-12 col-sm-6 col-md-8" style="vertical-align:bottom"><img src="{{asset('images/png/glyphicons_003_user.png')}}" width="23" height="22" />
      &nbsp; <?php echo Session::get('_NAME')?></div>
      <div class="col-xs-6 col-sm-6 col-md-4" style="text-align:right;vertical-align:bottom"><a href="  {{URL::to('backoffice_management/logout')}}" target="_self">Log Out &nbsp; <img src="{{asset('images/png/glyphicons_151_new_window.png')}}" width="26" height="22" /> </a></div>
    </div>
  </div>