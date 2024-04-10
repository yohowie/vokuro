{{ flash.output() }}
<div class="bg-body-tertiary p-5 rounded">
    <h1 class="fw-bold">欢迎！</h1>
    <p class="lead">这是一个使用 Phalcon 框架创建的网站</p>
    <hr class="my-4">
    {{ link_to("session/signup", "<i class='icon-ok icon-white'></i> 创建帐户", "class": "btn btn-primary btn-md") }}
</div>
<div class="row g-4 py-4 row-cols-1 row-cols-md-3">
    <div class="feature col border p-3">
        <h3 class="fs-3 text-body-emphasis">Awesome Section</h3>
        <p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
        <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec sed odio dui.</p>
    </div>
    <div class="feature col">
        <h3 class="fs-3 text-body-emphasis">Important Stuff</h3>
        <p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
        <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec sed odio dui.</p>
    </div>
    <div class="feature col">
        <h3 class="fs-3 text-body-emphasis">Example addresses</h3>
        <address>
            <strong>Vökuró, Inc.</strong><br>
            456 Infinite Loop, Suite 101<br>
            <abbr title="Phone">P:</abbr>&nbsp;<a href="tel:+11234567890" title="Call us">(123) 456-7890</a>
        </address>
        <address>
            <strong>Contacts</strong><br>
            <a href="mailto:team@phalcon.io?subject=Vökuró feedback" title="Send feedback">team@phalcon.io</a>
        </address>
    </div>
</div>
