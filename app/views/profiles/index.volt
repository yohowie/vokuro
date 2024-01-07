<h1>搜索 Profiles</h1>
{{ flash.output() }}
<div class="mb-5">
    {{ link_to('profiles/create', '<i class="icon-plus-sign"></i> 创建 Profiles', 'class': 'btn btn-primary') }}
</div>

<form method="post" class="form-inline" action="{{ url('profiles/search') }}">
    <div class="form-group">
        <label for="id" class="sr-only">Id</label>
        {{ form.render('id', ['class': 'form-control mr-sm-2', 'placeholder': 'Id']) }}
    </div>

    <div class="form-group">
        <label for="name" class="sr-only">名称</label>
        {{ form.render('name', ['class': 'form-control mr-sm-2', 'placeholder': '名称']) }}
    </div>

    {{ submit_button('搜索', 'class': 'btn btn-primary') }}
</form>
