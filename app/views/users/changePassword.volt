<div class="my-3">
    <h2 class="mt-5">更改密码</h2>
    <form method="post" class="w-50 m-auto" action="{{ url("users/changePassword") }}">
        {{ flash.output() }}
        <div class="form-floating mt-2">
            {{ form.render('password', ['class': 'form-control border-primary-subtle', 'placeholder': '请输入密码']) }}
            {{ form.label('password', ['class': 'col-sm-2 col-form-label']) }}
        </div>
        <div class="form-floating mt-2">
            {{ form.render('confirmPassword', ['class': 'form-control border-primary-subtle', 'placeholder': '请再次输入密码']) }}
            {{ form.label('confirmPassword', ['class': 'col-sm-2 col-form-label']) }}
        </div>
        <div class="d-flex mt-3">
            {{ submit_button("更改密码", "class": "btn btn-primary w-25") }}
        </div>
    </form>
</div>
