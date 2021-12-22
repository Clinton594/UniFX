<?php 
$_today = new DateTime();
$plans = $generic->getFromTable("content", "type=investment, status=1");
$plans = array_map(function($plan) use( $_today){
    $stopdate   = date("Y-m-d", strtotime("+{$plan->product}", time()));
    $reoccur   = new DateTime($stopdate);
    $plan->duration = $_today->diff($reoccur)->days + 1;
    return $plan;
}, $plans);
?>
<section class="pricing-section" style="background-size: cover; background-attachment: fixed; background: url(<?=$uri->site?>images/table-bg.jpg);">
        <div class="container-fluid">
            <div class="heading-title">
                <h6 class="text-white"><span></span> Pricing</h6>
                <h2 class="text-white">Our <span class="c-text"> Best </span> Plan</h2>
                <p class="text-white">GlobalHill Capital Ltd gives you the option to switch investment plans as your financial
                    circumstances changes. You can change how you invest to suit your needs without additional costs!
                </p>
            </div>

            <div class="tab-content" id="pills-tabContent1">
                <div class="tab-pane fade show active" id="pills-home1" style="overflow: visible;">
                    <div class="row">

                        <?php foreach ($plans as $key => $plan) {?>
                            <div class="col-lg-3">
                            <div class="pracing-item" style="background:#fff;">
                                <div class="top-left">
                                    <p><?=($plan->auto * $plan->duration)?>%</p>
                                </div>
                                <div class="top-area">
                                    <img src="<?=$uri->site?>images/icon003.svg" alt="img">
                                    <p class="c-text"><?=strtoupper($plan->title)?></p>
                                </div>
                                <ul>
                                    <li><span><i class="fal fa-check"></i></span>Minimum Deposit <?=$currency.$fmn->format($plan->business)?></li>
                                    <li><span><i class="fal fa-check"></i></span>Maximum Deposit <?=$currency.$fmn->format($plan->label)?></li>
                                    <li><span><i class="fal fa-check"></i></span><?=$plan->auto?>% Every <?=$plan->view?></li>
                                    <li><span><i class="fal fa-check"></i></span>Duration <?=$plan->product?></li>
                                    <?php foreach (json_decode($plan->body) ?? [] as $key => $value) {?>
                                        <li><span><i class="fal fa-check"></i></span><?=$value->title?> - <?=$value->desc?></li>
                                    <?php }?>
                                </ul>
                                <a href="#" class="buy-now" onclick="form_open('sign_up')">Start Plan</a>
                            </div>
                        </div>
                        <?php } ?>

                    </div>
                </div>
            </div>

        </div>
    </section>