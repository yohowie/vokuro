<h1 class="mt-3">登录</h1>

{{ flash.output() }}

<form method="post" role="form">
    <div class="mb-3">
        <label for="email-input" class="form-label">电子邮箱</label>
        {{ form.render("email", ["class": "form-control", "id": "email-input", "aria-describedby": "emailHelp"]) }}
        <small id="emailHelp" class="form-text text-muted">我们绝不会与其他任何人共享您的电子邮件。</small>
    </div>

    <div class="mb-3">
        <label for="password-input" class="form-label">密码</label>
        {{ form.render("password", ["class": "form-control", "id": "password-input"]) }}
    </div>

    <div class="mb-3">
        {{ form.render("remember", ["class": "form-check-input"]) }}
        {{ form.label("remember", ["class": "form-check-label", "for": "login-remember"]) }}
    </div>

	<div class="mb-3">
	    {{ form.render("csrf", ["value": security.getToken()]) }}
	    {{ form.render("登录") }}
    </div>
</form>

<hr>

<p>{{ link_to("session/forgotPassword", "忘记密码") }}</p>
<p>{{ link_to("session/signup", "注册") }}</p>