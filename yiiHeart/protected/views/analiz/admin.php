<?php
/* @var $this AnalizController */
/* @var $model Analiz */

$this->breadcrumbs=array(
	'Analizs'=>array('index'),
	'Управление',
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'Analiz','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#analiz-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Manage Analizs',
        'headerIcon' => 'icon- fa fa-tasks',
        'headerButtons' => array(
            array(
                'class' => 'bootstrap.widgets.TbButtonGroup',
                'type' => 'success',
                // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'buttons' => $this->menu
            ),
        ) 
    )
);?>		<?php $this->widget('bootstrap.widgets.TbAlert', array(
		    'block'=>false, // display a larger alert block?
		    'fade'=>true, // use transitions?
		    'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
		    'alerts'=>array( // configurations per alert type
		        'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		        'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		        'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		        'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		        'danger'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), //success, info, warning, error or danger
		    ),
		));
		?>
<p>
	You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>
		&lt;&gt;</b>
	or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php echo CHtml::beginForm(array('export')); ?>
<?php
function num($analiz_id, $elem_id)
{
        $num = Yii::app()->db->createCommand()
            ->select('value')
            ->from('analiz_has_element')
            ->where("analiz_id=$analiz_id"
                    . " and element_id = $elem_id")
            ->queryScalar();
        return (isset($num)) ? $num : '';
}
$myarray[] = array('header'=>'No','value'=>'($this->grid->dataProvider->pagination->currentPage*
					 $this->grid->dataProvider->pagination->pageSize
					)+ ($row+1)',
				'htmlOptions' => array('style' =>'width: 25px; text-align:center;'),
		);
$myarray[] = 			array(
		   //     'header' => 'Name',
		        'name'=> 'name',
		        'type'=>'raw',
		        'value' => '($data->name)',
		        'class' => 'bootstrap.widgets.TbEditableColumn',
	            'headerHtmlOptions' => array('style' => 'text-align:center'),
				'editable' => array(
					'type'    => 'textarea',
					'url'     => $this->createUrl('editable'),
					'params' => array('YII_CSRF_TOKEN' => Yii::app()->request->csrfToken),
				)
		);

$template = 11;
//находим все элементы из шаблона 
$connection = Yii::app()->db;
$sql = "
        SELECT te.`element_id`,
               el.name
        FROM `template_has_element` `te`,
             `element` el
        WHERE el.id= te.`element_id`
          AND te.`template_id`=$template
                            ";
$dataReader = $connection->createCommand($sql)->query();
$rows = $dataReader->readAll();


/* -----------------Данные для таблицы------------------------------------------- */

  for($i = 0, $cnt = count($rows); $i < $cnt; $i++) //формируем столбцы
  {
  $id = $rows[$i]['element_id'];
  $myarray[] = array(
  'header' =>  $rows[$i]['name'], 
  'id' => $id,
  'value' => 'num($data->id,'.$id.')',
  'htmlOptions' => array('style' => 'width: 15px; text-align:center;'),
  'headerHtmlOptions' => array('style' => 'text-align:center'),
  );
  }

$myarray[] = array(
    'class' => 'bootstrap.widgets.TbButtonColumn',
    'buttons' => array
        (
        'view' => array
            (
            'url' => '$data->id."|".$data->name',
            'click' => 'function(){
                		data=$(this).attr("href").split("|")
                		$("#myModalHeader").html(data[1]);
	        			$("#myModalBody").load("' . $this->createUrl('view') . '&id="+data[0]+"&asModal=true");
                		$("#myModal").modal();
                		return false;
                	}',
        ),
    )
);
$this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'analiz-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'type' => 'striped hover', //bordered condensed
	'columns'=>$myarray, 
)); ?>

<select name="fileType" style="width:150px;">
	<option value="Excel5">EXCEL 5 (xls)</option>
	<option value="Excel2007">EXCEL 2007 (xlsx)</option>
	<option value="HTML">HTML</option>
	<option value="PDF">PDF</option>
	<option value="WORD">WORD (docx)</option>
</select>
<br>

<?php 
$this->widget('bootstrap.widgets.TbButton', array(
	'buttonType'=>'submit', 'icon'=>'fa fa-print','label'=>'Export', 'type'=> 'primary'));
?>
<?php echo CHtml::endForm(); ?>
<?php $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Import Data',
        'htmlOptions' => array('style' => 'width:25%; text-align:center;margin-top:-100px', 'class'=>'pull-right'),
    )
);?>
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
		'id'=>'import-admin-form',
		'type' => 'inline',
		'enableAjaxValidation'=>false,
		'htmlOptions'=>array(
			'enctype'=>'multipart/form-data',
		),
		'action' => $this->createUrl('import'),  //<- your form action here
	)); ?>
	<?php echo $form->fileFieldRow($model,'fileImport'); ?> 
	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'buttonType'=>'submit',
		'type'=>'primary',
		'label'=>'Import',
		'icon'=>'fa fa-download'
	)); ?>
	<br>
	(file type permitted: xls, xlsx, ods only)
	<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>
<?php  $this->beginWidget(
    'bootstrap.widgets.TbModal',
    array('id' => 'myModal')
); ?>
 
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4 id="myModalHeader">Modal header</h4>
    </div>
 
    <div class="modal-body" id="myModalBody">
        <p>One fine body...</p>
    </div>
 
    <div class="modal-footer">
        <?php  $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'label' => 'Close',
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
    </div>
 
<?php  $this->endWidget(); ?>
