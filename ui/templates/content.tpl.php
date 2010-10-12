<?php foreach ($this->pages as $page):?>
    <div class="contentpart page" id="cp_<?=$page['key']?>">
        <?php
        $file = $page['key'] . '/_index.tpl.php';
        if (file_exists('templates/'.$file)) {
            include $this->template($file);
        }
        ?>
        <?php if ($page['tabs']): ?>
            <div class="tabset">
                <ul>
                    <?php foreach ($page['tabs'] as $tab): ?>
                        <li><a href="#cp_<?=$page['key'].'_'.$tab['key']?>"><?=$tab['name']?></a></li>
                    <?php endforeach ?>
                </ul>
                <?php foreach ($page['tabs'] as $tab): ?>
                    <div class="contentpart tab" id="cp_<?=$page['key'].'_'.$tab['key']?>">
                        <?php include $this->template($page['key'] . '/' . $tab['key'] . '.tpl.php'); ?>
                    </div>
                <?php endforeach ?>
            </div>
        <?php endif ?>
    </div>
<?php endforeach ?>