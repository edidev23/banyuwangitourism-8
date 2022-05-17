@extends('backend/layouts/template')
@section('title', "Change User")
@section('bread')
<h2>Change User</h2>
<ol class="breadcrumb">
    <li><a href="{{ url('admin') }} ">Dashboard</a></li>
    <li class="active">
        <strong>Change Password</strong>
    </li>
</ol>
@endsection

@section('main')

<div class="row">
    <div class="col-lg-12">
        <div class="inqbox float-e-margins">
            <div class="inqbox-content">
                <form action="{{url('admin/users/change-password', Auth::user()->id )}}" method="post"
                    enctype="multipart/form-data">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group @if($errors->has('password')) has-error @endif">
                                <label class="control-label" for="password">Password Baru</label>
                                <input name="password" type="password" class="form-control" placeholder="Password Baru"
                                    value="@if(count($errors) > 0){{old('password')}}@endif" />

                                @if ($errors->has('password'))
                                <span for="password" class="help-block">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                            <div class="form-group @if($errors->has('password_confirmation')) has-error @endif">
                                <label class="control-label" for="password_confirmation">Confirm Password</label>
                                <input name="password_confirmation" type="password" class="form-control"
                                    placeholder="Password Baru"
                                    value="@if(count($errors) > 0){{old('password_confirmation')}}@endif" />

                                @if ($errors->has('password_confirmation'))
                                <span for="password_confirmation"
                                    class="help-block">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="section">
                        <button type="submit" name="btn_save" value="save_back" class="btn btn-success">
                            <i class="fa fa-check"></i> Save & Back
                        </button>
                        <a href="{{ url('admin') }}" class="btn btn-danger">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')

<script type="text/javascript">
    $(document).ready(function(){		
		$('.check-password-lama').click( function(e) {
            e.preventDefault();
            var ambilVal = $('.password-lama').attr('type')
            console.log(ambilVal);
			if(ambilVal == 'password'){
				$('.password-lama').attr('type','text');
			}else{
				$('.password-lama').attr('type','password');
			}
		});
        $('.check-password').click( function(e) {
            e.preventDefault();
            var ambilVal = $('.password').attr('type')
            console.log(ambilVal);
			if(ambilVal == 'password'){
				$('.password').attr('type','text');
			}else{
				$('.password').attr('type','password');
			}
		});
        $('.check-password-confirmation').click( function(e) {
            e.preventDefault();
            var ambilVal = $('.password-confirmation').attr('type')
            console.log(ambilVal);
			if(ambilVal == 'password'){
				$('.password-confirmation').attr('type','text');
			}else{
				$('.password-confirmation').attr('type','password');
			}
		});
	});
</script>

@endsection