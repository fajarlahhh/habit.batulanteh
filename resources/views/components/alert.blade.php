<div>
  @if (Session::has('danger'))
    <div class="alert alert-session alert-danger fade show">
      <span class="close" data-dismiss="alert">×</span>
      {!! Session::get('danger') !!}
    </div>
  @endif
  @if (Session::has('warning'))
    <div class="alert alert-session alert-warning fade show">
      <span class="close" data-dismiss="alert">×</span>
      {!! Session::get('warning') !!}
    </div>
  @endif
  @if (Session::has('info'))
    <div class="alert alert-session alert-info fade show">
      <span class="close" data-dismiss="alert">×</span>
      {!! Session::get('info') !!}
    </div>
  @endif
  @if (Session::has('success'))
    <div class="alert alert-session alert-success fade show">
      <span class="close" data-dismiss="alert">×</span>
      {!! Session::get('success') !!}
    </div>
  @endif
</div>
