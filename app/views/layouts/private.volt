{% set menus = [
    '首页': null,
    'Users': 'users',
    'Profiles': 'profiles',
    'Permissions': 'permissions'
] %}
<header>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container">
            {{ link_to(null, 'Vökuró', 'class': 'navbar-brand') }}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mt-2 mt-md-0">
                    {% for key, value in menus %}
                        {% if value == dispatcher.getControllerName() %}
                    <li class="nav-item active">{{ link_to(value, key, 'class': 'nav-link') }}</li>
                        {% else %}
                    <li class="nav-item">{{ link_to(value, key, 'class': 'nav-link') }}</li>
                        {% endif %}
                    {% endfor %}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        {{ auth.getName() }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>{{ link_to('users/changePassword', 'class': 'dropdown-item', '更改密码') }}</li>
                        </ul>
                    </li>
                    <li class="nav-item">{{ link_to('session/logout', 'class': 'nav-link', '退出') }}</li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main role="main">
    <div class="container">
        {{ content() }}
    </div>
</main>
