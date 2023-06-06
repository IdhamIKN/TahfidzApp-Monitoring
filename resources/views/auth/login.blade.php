@extends('login.indexlogin')
<style>
    .show-password-wrapper {
        display: flex;
        align-items: center;
        margin-top: 10px;
        margin-left: -5px;
    }

    #togglePasswordBtn {
        margin-right: 5px;
    }

    #showPasswordCheckbox {
        display: none;
    }

    #showPasswordLabel {
        font-size: 12px;
        margin-left: 5px;
    }

    #showPasswordCheckbox:checked + #showPasswordLabel:before {
        content: "\f06e"; /* Font Awesome icon for eye */
    }

    #showPasswordCheckbox:not(:checked) + #showPasswordLabel:before {
        content: "\f070"; /* Font Awesome icon for eye-slash */
    }
</style>
@section('content')

<div class="login100-pic js-tilt" data-tilt>
    <img src="<?= URL::to('/layout_login/images/logo.png') ?>" alt="IMG">
</div>

<form method="POST" action="{{ route('login') }}" class="login100-form validate-form">

    @csrf

    <span class="login100-form-title">
        Tahfidz Monitoring
    </span>

    <div class="wrap-input100" data-validate = "Valid email is required: ex@abc.xyz">
        <input class="input100" type="text" name="username" placeholder="User Name" id="username">
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fa fa-envelope" aria-hidden="true"></i>
        </span>
    </div>

    {{-- <div class="wrap-input100 validate-input" data-validate = "Password is required">
        <input class="input100" type="password" name="password" placeholder="Password" id="password">
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fa fa-lock" aria-hidden="true"></i>
        </span>
    </div> --}}
    <div class="wrap-input100 validate-input" data-validate = "Password is required">
        <input class="input100" type="password" name="password" placeholder="Password" id="password">
        <span class="focus-input100"></span>
        <span class="symbol-input100">
            <i class="fa fa-lock" aria-hidden="true"></i>
        </span>
    </div>
    <div style="display:flex; justify-content:center; align-items:center; margin-top:10px;">
        <input type="checkbox" id="showPasswordCheckbox" onchange="togglePasswordVisibility()">
        <label for="showPasswordCheckbox" style="margin-left:5px; font-size:12px;">Lihat Password</label>
    </div>

    <div class="container-login100-form-btn">
        <button type="submit" class="login100-form-btn">
            Login
        </button>
    </div>

    <div class="text-center p-t-12">
        <span class="txt1">
            Lupa
        </span>
        <a class="txt2" href="{{route('show-reset')}}">
            Username / Password ?
        </a>
    </div>

    <div class="text-center p-t-12">
        @if($errors->any())
          <p style="color: red">{{$errors->first()}}</p>
        @endif
    </div>

</form>

@endsection

<script>
    function togglePasswordVisibility() {
        var passwordField = document.getElementById("password");
        var showPasswordCheckbox = document.getElementById("showPasswordCheckbox");
        if (passwordField.type === "password") {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
        showPasswordCheckbox.checked = passwordField.type === "text";
    }
</script>
