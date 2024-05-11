{% set isNameValidClass = form.messages("name") ? "form-control is-invalid" : 'form-control border-primary-subtle' %}
{% set isEmailValidClass = form.messages("email") ? "form-control is-invalid" : 'form-control border-primary-subtle' %}
{% set isPasswordValidClass = form.messages("password") ? "form-control is-invalid" : 'form-control border-primary-subtle' %}
{% set isConfirmPasswordValidClass = form.messages("confirmPassword") ? "form-control is-invalid" : 'form-control border-primary-subtle' %}
{% set isTermsValidClass = form.messages("terms") ? "form-check-input is-invalid" : 'form-check-input border-primary-subtle' %}

<div class="my-3">
    <h2 class="mt-5">注册</h2>
    <form class="w-50 m-auto" method="post">
        {{ flash.output() }}
        {{ form.render('csrf', ['value': security.getToken()]) }}
        <div class="form-floating mt-2">
            {{ form.render('name', ['class': isNameValidClass, 'placeholder': '请输入用户名']) }}
            {{ form.label('name') }}
            <div class="invalid-feedback">{{ form.messages('name') }}</div>
        </div>
        <div class="form-floating mt-2">
            {{ form.render('email', ['class': isEmailValidClass, 'placeholder': '请输入电子邮箱']) }}
            {{ form.label('email') }}
            <div class="invalid-feedback">{{ form.messages('email') }}</div>
        </div>
        <div class="form-floating mt-2">
            {{ form.render('password', ['class': isPasswordValidClass, 'placeholder': '请输入密码']) }}
            {{ form.label('password') }}
            <div class="invalid-feedback">{{ form.messages('password') }}</div>
        </div>
        <div class="form-floating mt-2">
            {{ form.render('confirmPassword', ['class': isConfirmPasswordValidClass, 'placeholder': '请再次输入密码']) }}
            {{ form.label('confirmPassword') }}
            <div class="invalid-feedback">{{ form.messages('confirmPassword') }}</div>
        </div>
        <div class="form-check text-start my-3">
            {{ form.render('terms', ['class': isTermsValidClass]) }}
            {{ form.label('terms') }}
            <div class="invalid-feedback">{{ form.messages('terms') }}</div>
        </div>
        <div class="d-flex">
            <div class="flex-grow-1">{{ form.render('signUp', ['class': 'btn btn-primary w-25']) }}</div>
            <div>{{ link_to('session/login', '&larr; 去登录') }}</div>
        </div>
    </form>
</div>
