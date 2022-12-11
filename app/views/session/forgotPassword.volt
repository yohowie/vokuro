<h1 class="mt-3">忘记密码</h1>

{{ flash.output() }}

<form method="post">
    <div class="mb-3">
        <label for="forgot-email-input">电子邮箱地址</label>
        {{ form.render('email', ['class': 'form-control', 'id': 'forgot-email-input', 'placeholder': '请输入电子邮箱']) }}
    </div>

    {{ form.render('Send') }}
</form>

<hr />

{{ link_to('session/login', '&larr; 返回登录') }}