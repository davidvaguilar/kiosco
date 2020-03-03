@extends('auth.contenido')

@section('login')
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>K</b>iosco</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Inicia sesión para comenzar</p>
    <form action="{{ route('login') }}" method="POST">
      {{ csrf_field() }}
      <div class="form-group has-feedback {{ $errors->has('usuario' ? 'has-error' : '') }}">
        <input name="usuario" id="usuario" value="{{ old('usuario') }}" type="text" class="form-control" placeholder="Usuario">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        {!! $errors->first('usuario', '<span class="invalid-feedback"> :message </span>') !!}
      </div>
      <div class="form-group has-feedback {{ $errors->has('password' ? 'is-invalid' : '') }}">
        <input name="password" id="password" type="password" class="form-control" placeholder="Contraseña">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        {!! $errors->first('password', '<span class="invalid-feedback"> :message </span>') !!}
      </div>
      <div class="row">
        <!--<div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>-->
        <!-- /.col -->
        <div class="form-group col-xs-8">
          <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-2x"></i> Iniciar sesión</button> <!--  btn-flat-->
        </div>
        <!-- /.col -->
      </div>
    </form>

    <!--<div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using
        Google+</a>
    </div>-->
    <!-- /.social-auth-links

    <a href="#">I forgot my password</a><br>
    <a href="register.html" class="text-center">Register a new membership</a> -->

  </div>
  <!-- /.login-box-body -->
</div>
@endsection
