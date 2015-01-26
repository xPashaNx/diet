<?php echo $model->content; ?>

<br/><hr/>
<div>
    <h3>Вывод виджита "NewsAdminmenuWidget":</h3>
    <div>
        <?php $this->widget('application.modules.news.components.NewsAdminmenuWidget'); ?>
    </div>
</div>

<br/>

<div>
    <h3>Вывод виджита "LastNewsWidget":</h3>
    <div>
        <?php $this->widget('application.modules.news.widgets.LastNewsWidget'); ?>
    </div>
</div>
<br/><hr/>