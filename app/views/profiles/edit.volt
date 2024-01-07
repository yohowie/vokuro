<h1 class="mt-3">编辑</h1>
{{ flash.output() }}

<div class="btn-group mb-5" role="group">
    {{ link_to('profiles/index', '&larr; 返回', 'class': 'btn btn-warning') }}
</div>

<form method="post">
    <ul class="nav nav-tabs" id="profile-edit-tabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="profile-edit-basic-tab" data-toggle="tab" href="#basic" role="tab" aria-controls="basic" aria-selected="true">Basic</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-edit-users-tab" data-toggle="tab" href="#users" role="tab" aria-controls="users" aria-selected="false">Users</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="profile-edit-basic-tab">
            <div class="form-group row mt-3">
                <label for="name" class="col-sm-2 col-form-label">名称</label>
                <div class="col-sm-10">
                    {{ form.render('name', ['class': 'form-control', 'placeholder': '名称']) }}
                </div>
            </div>
            <div class="form-group row mt-3">
                <label for="name" class="col-sm-2 col-form-label">Active?</label>
                <div class="col-sm-10">
                    {{ form.render('active', ['class': 'form-control']) }}
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="users" role="tabpanel" aria-labelledby="profile-edit-users-tab">
            <table class="table table-bordered table-striped mt-3">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>名称</th>
                        <th>Banned?</th>
                        <th>Suspended?</th>
                        <th>Active?</th>
                    </tr>
                </thead>
                <tbody>
                    {% for user in profile.users %}
                    <tr>
                        <td>{{ user.id }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.banned == 'Y' ? 'Yes' : 'No'}}</td>
                        <td>{{ user.suspended == 'Y' ? 'Yes' : 'No' }}</td>
                        <td>{{ user.active == 'Y' ? 'Yes' : 'No' }}</td>
                        <td with="12%">
                            {{ link_to('users/edit/' ~ user.id, '<i class="icon-pencil"></i> 编辑', 'class': 'btn btn-sm btn-outline-warning') }}
                        </td>
                        <td with="12%">
                            {{ link_to('users/delete/' ~ user.id, '<i class="icon-remove"></i> 删除', 'class': 'btn btn-sm btn-outline-danger') }}
                        </td>
                    </tr>
                    {% else %}
                    <tr>
                        <td colspan="3" align="center">没有用户分配给此配置文件</td>
                    </tr>
                    {% endfor %}
                </tbody>
            </table>
        </div>

        {{ form.render('id') }}
        {{ submit_button('保存', 'class': 'btn btn-success') }}
    </div>
</form>
