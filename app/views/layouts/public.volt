{%
set menus = ["首页": "index", "关于": "about"]
%}
<header>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="container">
            {{ link_to(null, "Vökuró", "class": "navbar-brand") }}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mt-2 mt-md-0">
                    {% for key, value in menus %}
                    <li class="nav-item">{{ link_to(value, key, 'class': 'nav-link') }}</li>
                    {% endfor %}
                </ul>
                <ul class="navbar-nav my-2 my-md-0">
                    <li class="nav-item">{{ link_to("session/login", "登录", "class": "nav-link") }}</li>
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
<footer class="footer py-3 mt-auto text-center bg-body-tertiary fw-light">
    <div class="container">
        <span class="text-muted">
            由 Phalcon 团队倾力打造

            {{ link_to("privacy", "隐私政策") }}
            {{ link_to("terms", "条款") }}

            © {{ date("Y") }} Phalcon 团队.
        </span>
    </div>
</footer>
