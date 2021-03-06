{{ flash.output() }}

<header class="p-4  mb-4 mt-3 bg-light rounded-3" id="overview">
    <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">欢迎！</h1>
        <p class="col-md-8 fs-4">这是一个使用 Phalcon 框架创建的网站</p>
        <hr class="my-4">
        {{ link_to("session/signup", "<i class='icon-ok icon-white'></i> 创建帐户", "class": "btn btn-primary btn-lg") }}
    </div>
</header>

<div class="row pb-4">
    <div class="col-md-12 col-lg-4">
        <div class="card">
            <div class="card-body">
                <h3>Awesome Section</h3>
                <p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec sed odio dui.</p>
            </div>
        </div>
    </div>

    <div class="col-md-12 col-lg-4">
        <h3>Important Stuff</h3>
        <p>Nullam quis risus eget urna mollis ornare vel eu leo. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
        <p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Donec sed odio dui.</p>
    </div>

    <div class="col-md-12 col-lg-4">
        <h3>Example addresses</h3>
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