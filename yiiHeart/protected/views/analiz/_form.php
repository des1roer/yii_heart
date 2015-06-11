<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'analiz-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	// 'htmlOptions'=>array('enctype'=>'multipart/form-data'),
)); ?>

	<p class="note">Поля с <span class="required">*</span> обязательны.</p>

	<?php echo $form->errorSummary($model); ?>

<?php //echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>
        
<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>45)); ?>
<?php 
//добавление данных для ввода (при создании новой записи и отсутствии записи в изменяемой)
$id_template = $model->template_id;
if (isset($id_template))
{ 
    $connection = Yii::app()->db;
    if (isset($model->id))
    {
        $id2 = $model->id;
     $sql2 = "
            SELECT dat.`element_id` AS id,
                   dat.`value` AS value,
                   `el`.`name` AS name
            FROM `analiz_has_element` dat,
                 `element` el
            WHERE `analiz_id` = $id2
              AND el.id=dat.`element_id`
                            ";
    $dataReader2 = $connection->createCommand($sql2)->query();
    $rows2 = $dataReader2->readAll();      
    for($i = 0, $cnt = count($rows2); $i < $cnt; $i++)
    {
        $id = $rows2[$i]['id'];   
        echo CHtml::label($rows2[$i]['name'], $rows2[$i]['name']);
        echo CHtml::textField("elem[$id][val]", $rows2[$i]['value'], array('id' => $rows2[$i]['name']));
        $condition .= ' AND temp.`element_id` != ' . $id;
    }
    
    }
    (isset($condition) && $condition) ? '' : $condition = null;
    $sql = "
            SELECT temp.`element_id` as id,
                   el.`name` as name
            FROM `template_has_element` TEMP,
                                        `element` el
            WHERE `template_id` = $id_template
              AND `temp`.`element_id` = el.`id`
              $condition 
                            ";
    $dataReader = $connection->createCommand($sql)->query();
    $rows = $dataReader->readAll();
  
    for($i = 0, $cnt = count($rows); $i < $cnt; $i++)
    {
        $id = $rows[$i]['id'];   
        echo CHtml::label($rows[$i]['name'], $rows[$i]['name']);
        echo CHtml::textField("elem[$id][val]", '', array('id' => $rows[$i]['name']));
    }
}
    ?>
        
<?php //echo $form->textFieldRow($model,'template_id',array('class'=>'span5')); ?>


<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Создать' : 'Сохранить',
		)); ?>
</div>

<?php $this->endWidget(); ?>
