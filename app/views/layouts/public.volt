{%
set menus = ["首页": "index", "关于": "about"]
%}
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    {{ link_to(null, "Vökuró", "class": "navbar-brand") }}

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mt-2 mt-lg-0">
            {% for key, value in menus %}
                <li class="nav-item">{{ link_to(value, key, "class": "nav-link") }}</li>
            {% endfor %}
        </ul>

        <ul class="navbar-nav my-2 my-lg-0">
            <li class="nav-item">{{ link_to("session/login", "登录", "class": "nav-link") }}</li>
        </ul>
    </div>
</nav>

<main role="main" class="flex-shrink-0">
    <div class="container">
        {{ content() }}
    </div>
</main>

<footer class="footer mt-auto py-3 text-center">
    <div class="container">
        <span class="text-muted">
            由 Phalcon 团队倾力打造

            {{ link_to("privacy", "隐私政策") }}
            {{ link_to("terms", "条款") }}

            © {{ date("Y") }} Phalcon 团队.
        </span>
    </div>
</footer>