<h1 class="mt-3">创建 Profile</h1>
{{ flash.output() }}

<div class="mb-5">
    {{ link_to('profiles', 'class': 'btn btn-primary', '&larr; 返回') }}
</div>

<form method="post">
    <div class="form-group row">
        {{ form.label('name', ['class': 'col-sm-2 col-form-label']) }}
        <div class="col-sm-10">
            {{ form.render('name', ['class': 'form-control', 'placeholder': '名称']) }}
        </div>
    </div>

    <div class="form-group row">
        <label for="active" class="col-sm-2 col-form-label">Active?</label>
        <div class="col-sm-10">
            {{ form.render('active', ['class': 'form-control', 'placeholder': 'Active?']) }}
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-10">
            {{ submit_button('保存', 'class': 'btn btn-success') }}
        </div>
    </div>
</form>
