<li>
    <?if($data->content_type==1):// ���������� �������� �� �������?>

        <?echo CHtml::link(CHtml::image('/'.$data->folder.'/'.$data->image, $data->title, array('width'=>298, 'height'=>124)), $data->link);?>
        
    <?else:// ���������� ���?>

        <?echo $data->code;?>

    <?endif?>
</li>
<?$data->incViews();// ����������� ������� �������?>