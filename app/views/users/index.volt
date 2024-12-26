<div class="my-3">
    <h2 clss="mt-5">用户列表</h2>
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Id</th>
                <th>用户名</th>
                <th>邮箱</th>
                <th>Profile</th>
                <th>Banned?</th>
                <th>Suspended?</th>
                <th>Confirmed?</th>
            </tr>
        </thead>
        <tbody>
            {% for user in page.items %}
            <tr>
                <td>{{ user.id }}</td>
                <td>{{ user.name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.profile.name }}</td>
                <td>{{ user.banned == 'Y' ? 'Yes' : 'No' }}</td>
                <td>{{ user.suspended == 'Y' ? 'Yes' : 'No' }}</td>
                <td>{{ user.active == 'Y' ? 'Yes' : 'No' }}</td>
            </tr>
            {% else %}
            <tr>
                <td colspan="7">没有记录任何用户</td>
            </tr>
            {% endfor %}
        </tbody>
        <tfoot>
            <tr>
                <td colspan="7">
                    <nav>
                        <ul class="pagination justify-content-end mb-0">
                            <li class="page-item {% if(page.current == page.first) %}disabled{% endif %}">
                                {{ link_to('users/index?page=' ~ page.previous, '<span aria-hidden="true">&laquo;</span>', 'class': 'page-link', 'aria-label': 'Previous') }}
                            </li>
                            {% set text = '   hello   '|trim  %}
                            <?php $startPage = max(1, $page->getCurrent() - 2) ?>
                            <?php $endPage = min($page->getLast(), $page->getCurrent() + 2) ?>
                            <?php if ($endPage - $startPage + 1 < 5): ?>
                                <?php $endPage = min($page->getLast(), $startPage + 5 - 1) ?>
                                <?php $startPage = max(1, $endPage - 5 + 1) ?>
                            <?php endif ?>
                            <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                            <li class="page-item">
                            {% set active = '' %}
                            {%- if i == page.current -%}
                                {%- set active = 'active' -%}
                            {%- endif -%}
                            {{ link_to('users/index?page=' ~ i, i, 'class': 'page-link ' ~ active) }}
                            </li>
                            <?php endfor ?>
                            <li class="page-item {% if(page.current == page.last) %}disabled{% endif %}">
                                {{ link_to('users/index?page=' ~ page.next, '<span aria-hidden="true">&raquo;</span>', 'class': 'page-link', 'aria-label': 'Next') }}
                            </li>
                        </ul>
                    </nav>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
