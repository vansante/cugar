<?php foreach ($this->modules as $module):?>
    <div class="contentpart module" id="cp_<?= $module['key']?>">
        <?php foreach ($module['pages'] as $page): ?>
            <div class="contentpart page" id="cp_<?= $module['key'].'_'.$page['key']?>">
                <?php include $this->template($module['key'] . '/' . $page['key'] . '.tpl.php'); ?>
                <?php if ($page['tabs']): ?>
                    <div class="tabset">
                        <ul>
                            <?php foreach ($page['tabs'] as $tab): ?>
                                <li><a href="#cp_<?= $module['key'].'_'.$page['key'].'_'.$tab['key']?>"><?=$tab['name']?></a></li>
                            <?php endforeach ?>
                        </ul>
                        <?php foreach ($page['tabs'] as $tab): ?>
                            <div class="contentpart tab" id="cp_<?= $module['key'].'_'.$page['key'].'_'.$tab['key']?>">
                                <?php include $this->template($module['key'] . '/' . $page['key'] . '_' . $tab['key'] . '.tpl.php'); ?>
                            </div>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>
            </div>
        <?php endforeach ?>
    </div>
<?php endforeach ?>