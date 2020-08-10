<?php defined('ByCCYNet') or exit('Access Invalid!'); ?>
<select class="class-select select-change">
    <option value="">-请选择-</option>
    <?php if (!empty($output['lists'])){ ?>
        <?php foreach ($output['lists'] as $type){ ?>
            <option data-explain="20" value="<?php echo $type['gc_id'] ?>"><?php echo $type['gc_name'] ?></option>
        <?php } ?>
    <?php } ?>
</select>