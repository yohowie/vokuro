<h1 class="mt-3">搜索用户</h1>
<div class="mb-5">
    {{ link_to('users/create', '创建用户', 'class': 'btn btn-primary') }}
</div>
<h6 id="usersAssetManagerDemoTextContainer">分离的 javascript 已加载</h6>

{{ flash.output() }}
<form class="form-inline" method="get" action="{{ url('users/search') }}">
    <div class="form-group">
        <label for="id" class="sr-only">Id</label>
        {{ form.render('id', ['class': 'form-control mr-sm-2', 'placeholder': 'Id']) }}
    </div>
    <div class="form-group">
        <label for="name" class="sr-only">用户名</label>
        {{ form.render('name', ['class': 'form-control mr-sm-2', 'placeholder': '用户名']) }}
    </div>
    <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        {{ form.render('email', ['class': 'form-control mr-sm-2']) }}
    </div>
    <div class="form-group">
        {{ form.render('profilesId', ['class': 'form-control mr-sm-2']) }}
    </div>

    <button type="submit" class="btn btn-primary">搜索</button>
</form>
