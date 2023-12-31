<h1 class="mt-3">创建用户</h1>

<div class="mb-5">
    {{ link_to('users', 'class': 'btn btn-primary', '&larr; 返回') }}
</div>
{{ flash.output() }}
<form method="post">
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">用户名</label>
        <div class="col-sm-10">
            {{ form.render('name', ['class': 'form-control', 'placeholder': '用户名']) }}
        </div>
    </div>

    <div class="form-group row">
        <label form="email" class="col-sm-2 col-form-label">电子邮箱</label>
        <div class="col-sm-10">
            {{ form.render('email', ['class': 'form-control', 'placeholder': '电子邮箱']) }}
        </div>
    </div>

    <div class="form-group row">
        <label for="profilesId " class="col-sm-2 col-form-label">Profile</label>
        <div class="col-sm-10">
            {{ form.render('profilesId', ['class': 'form-control']) }}
        </div>
    </div>

    {{ submit_button('保存', 'class': 'btn btn-success') }}
</form>
