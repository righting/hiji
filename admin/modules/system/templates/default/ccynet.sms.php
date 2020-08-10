<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>

<div class="page">
    <div class="fixed-bar">
        <div class="item-title">
            <div class="subject">
                <h3><?php echo $lang['sms_set']; ?></h3>
                <h5><?php echo $lang['sms_set_subhead']; ?></h5>
            </div>
            <?php echo $output['top_link']; ?>
        </div>
    </div>
    <!-- 操作说明 -->
    <div class="explanation" id="explanation">
        <div class="title" id="checkZoom"><i class="fa fa-lightbulb-o"></i>
            <h4 title="<?php echo $lang['nc_prompts_title']; ?>"><?php echo $lang['nc_prompts']; ?></h4>
            <span id="explanationZoom" title="<?php echo $lang['nc_prompts_span']; ?>"></span>
        </div>
        <ul>
            <li>在这里可以设置海吉壹佰提供的短信服务商完成设置。</li>
        </ul>
    </div>
    <form method="post" enctype="multipart/form-data" name="form1">
        <input type="hidden" name="form_submit" value="ok"/>
        <div class="ncap-form-default">
            <dl class="row">
                <dt class="tit"><span><?php echo $lang['ccynet_sms_type']; ?></span></dt>
                <dd class="opt">
                    <ul class="ncap-account-container-list">
                        <li>
                            <input type="radio" name="ccynet_sms_type" value="4" checked="checked"/>
                            <label for="ccynet_sms_type"><?php echo $lang['ccynet_sms_aliyun']; ?></label>
                        </li>
                    </ul>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="ccynet_sms_aliyun_key_id"><?php echo $lang['ccynet_sms_aliyun_key_id']; ?></label>
                </dt>
                <dd class="opt">
                    <input id="ccynet_sms_aliyun_key_id" name="ccynet_sms_aliyun_key_id"
                           value="<?php echo $output['list_setting']['ccynet_sms_aliyun_key_id']; ?>" class="input-txt"
                           type="text"/>
                    <p class="notic"><?php echo $lang['ccynet_sms_aliyun_key_id_notice']; ?></p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="ccynet_sms_aliyun_key_secret"><?php echo $lang['ccynet_sms_aliyun_key_secret']; ?></label>
                </dt>
                <dd class="opt">
                    <input id="ccynet_sms_aliyun_key_secret" name="ccynet_sms_aliyun_key_secret"
                           value="<?php echo $output['list_setting']['ccynet_sms_aliyun_key_secret']; ?>"
                           class="input-txt" type="text"/>
                    <p class="notic"><?php echo $lang['ccynet_sms_aliyun_key_secret_notice']; ?></p>
                </dd>
            </dl>
            </dl>

            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="ccynet_sms_signature"><?php echo $lang['ccynet_sms_signature']; ?></label>
                </dt>
                <dd class="opt">
                    <input id="ccynet_sms_signature" name="ccynet_sms_signature"
                           value="<?php echo $output['list_setting']['ccynet_sms_signature']; ?>" class="input-txt"
                           type="text"/>
                    <p class="notic"><?php echo $lang['ccynet_sms_signature_notice']; ?></p>
                </dd>
            </dl>
            <dl class="row">
                <dt class="tit">
                    <label for="ccynet_sms_bz"><?php echo $lang['ccynet_sms_bz']; ?></label>
                </dt>
                <dd class="opt">
                    <textarea name="ccynet_sms_bz" rows="6" class="tarea"
                              id="ccynet_sms_bz"><?php echo $output['list_setting']['ccynet_sms_bz']; ?></textarea>
                    <p class="notic"><?php echo $lang['ccynet_sms_bz_notice']; ?></p>
                </dd>
            </dl>
            <div class="bot"><a href="JavaScript:void(0);" class="ncap-btn-big ncap-btn-green"
                                onclick="document.form1.submit()"><?php echo $lang['nc_submit']; ?></a></div>
        </div>
    </form>
</div>