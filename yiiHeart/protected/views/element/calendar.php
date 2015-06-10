<?php
/* @var $this ElementController */
/* @var $model Element */
$this->breadcrumbs=array(
    'Elements'=>array('index'),
    'Calendar',
);

$menu=array();
require(dirname(__FILE__).DIRECTORY_SEPARATOR.'_menu.php');
$this->menu=array(
	array('label'=>'Element','url'=>array('index'),'icon'=>'fa fa-list-alt', 'items' => $menu)	
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$.fn.yiiGridView.update('training-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");
?>

<?php  $box = $this->beginWidget(
    'bootstrap.widgets.TbBox',
    array(
        'title' => 'Calendar' ,
        'headerIcon' => 'icon- fa fa-calendar',
        'headerButtons' => array(
            array(
                'class' => 'bootstrap.widgets.TbButtonGroup',
                'type' => 'success',
                // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'buttons' => $this->menu
            ),
        ) 
    )
);?>

<?php  $this->widget('ext.heart.calendar.EHeartCalendar', array(
	//'themeCssFile'=>'cupertino/jquery-ui.min.css',
	'options'=>array(
		'header'=>array(
			'left'=>'prev,next,today',
			'center'=>'title',
			'right'=>'month,basicWeek,basicDay',//agendaWeek,agendaDay',
		),
		'events'=>$this->createUrl('calendarEvents'),
		'eventClick'=> 'js:function(calEvent, jsEvent, view) {
	        $("#myModalHeader").html(calEvent.title);
	        $("#myModalBody").load("'.$this->createUrl('view').'&id="+calEvent.id+"&asModal=true");
	        $("#myModal").modal();
	    }',
	)));
?>

<?php  $this->endWidget(); ?>

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