<h1 class="mt-3">更改密码</h1>

{{ flash.output() }}

<form method="post" action="{{ url("users/changePassword") }}">
    <div class="mb-3">
        {{ form.label('password', ['class': 'col-sm-2 col-form-label']) }}
        <div class="col-sm-10">
            {{ form.render('password', ['class': 'form-control', 'placeholder': '请输入密码']) }}
        </div>
    </div>

    <div class="mb-3">
        {{ form.label('confirmPassword', ['class': 'col-sm-2 col-form-label']) }}
        <div class="col-sm-10">
            {{ form.render('confirmPassword', ['class': 'form-control', 'placeholder': '请再次输入密码']) }}
        </div>
    </div>

    <div class="mb-3">
        <div class="col-sm-10">
            {{ submit_button("更改密码", "class": "btn btn-primary") }}
        </div>
    </div>
</form>