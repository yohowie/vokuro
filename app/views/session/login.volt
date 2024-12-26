<div class="form-signin w-100 m-auto my-3">
    {{ flash.output() }}
    <form class="py-3" method="post">
        {{ form.render('csrf', ['value': security.getToken()]) }}
        <div class="form-floating">
            {{ form.render('email', ['class': 'form-control border-primary-subtle', 'placeholder': 'name@example.com'])}}
            <label for="email">Email Address</label>
        </div>
        <div class="form-floating mt-2">
            {{ form.render('password', ['class': 'form-control border-primary-subtle', 'placeholder': 'Password']) }}
            <label for="password">Password</label>
        </div>
        <div class="form-check text-start my-3">
            {{ form.render('remember', ['class': 'form-check-input border-primary-subtle']) }}
            {{ form.label('remember', ['class': 'form-check-label']) }}
        </div>
        {{ form.render('login', ['class': 'btn btn-primary w-100 py-2']) }}

        <hr>
        <div class="d-flex">
            <div class="flex-grow-1">{{ link_to('session/forgotPassword', '忘记密码') }}</div>
            <div>{{ link_to('session/signup', '注册') }}</div>
        </div>
    </form>
</div>
