@php
use App\Models\CustomClass;
@endphp

<style>
.page_405 {
    padding: 40px 0;
    background: #fff;
}

.page_405 img {
    width: 100%;
}

.four_zero_four_bg {
    background-image: url('{{app(CustomClass::class)->rootApp()}}/assets/images/dribbble_1.gif');
    height: 400px;
    background-position: center;
}

.four_zero_four_bg h1 {
    font-size: 80px;
}

.four_zero_four_bg h3 {
    font-size: 80px;
}

.link_405 {
    color: #fff !important;
    padding: 10px 20px;
    background: #ac3131;
    margin: 20px 0;
    display: inline-block;
}

.contant_box_405 {
    margin-top: -50px;
}
</style>

<section class="page_405">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 ">
                <div class="col-sm-10 col-sm-offset-1  text-center">
                    <div class="four_zero_four_bg">
                        <!-- <h1 class="text-center ">405</h1> -->
                    </div>
                    <div class="contant_box_405">
                        <h3 class="h2">
                            {{ app(CustomClass::class)->notifHeaderForbiddenAkses() }}
                        </h3>
                        <p>{{ app(CustomClass::class)->notifBodyForbiddenAkses() }} {{ config('app.name') }}</p>
                        <a href="{{app(CustomClass::class)->rootApp()}}/" class="link_405">kembali ke Dashboard</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>