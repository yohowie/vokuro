{% set isNameValidClass = form.messages("name") ? "form-control is-invalid" : "form-control" %}
{% set isEmailValidClass = form.messages("email") ? "form-control is-invalid" : "form-control" %}
{% set isPasswordValidClass = form.messages("password") ? "form-control is-invalid" : "form-control" %}
{% set isConfirmPasswordValidClass = form.messages("confirmPassword") ? "form-control is-invalid" : "form-control" %}
{% set isTermsValidClass = form.messages("terms") ? "form-check-input is-invalid" : "form-check-input" %}

<h1 class="mt-3">注册</h1>

{{ flash.output() }}

<form method="post" role="form">
    <div class="row mb-3">
        {{ form.label("name", ["class": "col-sm-2 col-form-label"]) }}
        <div class="col-sm-10">
            {{ form.render("name", ["class": isNameValidClass, "placeholder": "请输入用户名"]) }}
            <div class="invalid-feedback">
                {{ form.messages("name") }}
            </div>
        </div>
    </div>

    <div class="row mb-3">
        {{ form.label("email", ["class": "col-sm-2 col-form-label"]) }}
        <div class="col-sm-10">
            {{ form.render("email", ["class": isEmailValidClass, "placeholder": "请输入电子邮箱"]) }}
            <div class="invalid-feedback">
                {{ form.messages("email") }}
            </div>
        </div>
    </div>

    <div class="row mb-3">
        {{ form.label("password", ["class": "col-sm-2 col-form-label"]) }}
        <div class="col-sm-10">
            {{ form.render("password", ["class": isPasswordValidClass, "placeholder": "请输入密码"]) }}
            <div class="invalid-feedback">
                {{ form.messages("password") }}
            </div>
        </div>
    </div>

    <div class="row mb-3">
        {{ form.label("confirmPassword", ["class": "col-sm-2 col-form-label"]) }}
        <div class="col-sm-10">
            {{ form.render("confirmPassword", ["class": isConfirmPasswordValidClass, "placeholder": "请再次输入密码"]) }}
            <div class="invalid-feedback">
                {{ form.messages("confirmPassword") }}
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-sm-2">条款和规则</div>
        <div class="col-sm-10">
            {{ form.render("terms", ["class": isTermsValidClass]) }}
            {{ form.label("terms", ["class": "form-check-label"]) }}
            <div class="invalid-feedback">
                {{ form.messages("terms") }}
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-sm-10">
            {{ form.render("csrf", ["value": security.getToken()]) }}
            {{ form.messages("csrf") }}

            {{ form.render("注册") }}
        </div>
    </div>
</form>

<hr>

{{ link_to("session/login", "&larr; 返回登录") }}