<div class="my-3">
    <h2 class="mt-5">忘记密码</h2>
    <form class="w-50 m-auto" method="post">
        {{ flash.output() }}
        <div class="form-floating">
            {{ form.render('email', ['class': 'form-control border-primary-subtle', 'placeholder': '请输入电子邮箱']) }}
            <label>电子邮箱地址</label>
        </div>
        <div class="d-flex mt-3">
            <div class="flex-grow-1">{{ form.render('Send', ['class': 'btn btn-primary w-25']) }}</div>
            <div>{{ link_to('session/login', '&larr; 返回登录') }}</div>
        </div>
    </form>
</div>
