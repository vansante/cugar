<?
/**
 * @desc Build HTML for menu. The menu works by click handlers in init.js
 */
?>

<ul id="menu" class="ui-corner-all ui-widget-content ui-widget">
    <?php foreach ($this->pages as $page): ?>
        <li class="page_link"><a href="#<?=$page['key']?>" rel="<?=$page['key']?>" id="<?=$page['key']?>"><?=$page['name']?></a></li>
    <?php endforeach ?>
    <li><a href="#" id="logout_link">Logout</a></li>
</ul>