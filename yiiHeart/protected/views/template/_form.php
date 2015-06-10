<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'template-form',
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
        <br />
        <b>Элементы</b>
        <br />
<?php
//данные для элементов    
$type_list = CHtml::listData(Element::model()->findAll(), 'id', 'name');

if (isset($model->id))
{
    $arr = TemplateHas::model()->findAll("template_id=:id", array(':id' => $model->id));
}

if (isset($arr))
{
    for($i = 0; $i < count($arr); $i++)
    {                    
        $arr_bit[] = $arr[$i]->element_id;
    }
}
else
    $arr_bit = array();

// $data = CHtml::textField('textField'); 
echo CHtml::checkBoxList('im_id2', $arr_bit, $type_list, array(
    'template' => "{input} {labelTitle}",
    'class' => 'chclass',
    'labelOptions'=>array('style'=>'display:inline'),
        )
);
//просто рисуем чекбокслитс из базы
//данные для элементов
?>  

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Создать' : 'Сохранить',
		)); ?>
</div>

<?php $this->endWidget(); ?>
