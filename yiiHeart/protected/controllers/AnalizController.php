<?php

class AnalizController extends Controller
    {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('index', 'view'),
                'users' => array('*'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'export', 'import', 'editable', 'toggle',),
                'users' => array('admin'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {

        if (isset($_GET['asModal']))
        {
            $this->renderPartial('view', array(
                'model' => $this->loadModel($id),
            ));
        }
        else
        {

            $this->render('view', array(
                'model' => $this->loadModel($id),
            ));
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        
        $model = new Analiz;
        $model->template_id = 11;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Analiz']))
        {
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $messageType = 'warning';
                $message = "There are some errors ";
                $model->attributes = $_POST['Analiz'];
                //$uploadFile=CUploadedFile::getInstance($model,'filename');
                if ($model->save())
                {
if (isset($_POST['elem']))
{
    $command = Yii::app()->db->createCommand();
    $max = Yii::app()->db->createCommand()
            ->select('COALESCE ((max(id)), 1) as max')
            ->from('analiz')
            ->queryScalar();

    $Ids = $_POST['elem'];
    //echo '<pre><hr />';
    $cnt = max(array_keys($Ids));
    $min = min(array_keys($Ids));
    for($i = $min; $i <= $cnt; $i++)
    {
        $val = $Ids[$i]['val'];
        //echo $Ids[$i]['per'][0];
        if (isset($val) && !empty($val))
            $command->insert('analiz_has_element', array(
                'analiz_id' => $max, ////
                'value' => $val,
                // 'f_precision' =>  $Ids[$i]['per'][0], 
                'element_id' => $i
            ));
    }
};
                    $messageType = 'success';
                    $message = "<strong>Well done!</strong> You successfully create data ";
                    /*
                      $model2 = Analiz::model()->findByPk($model->id);
                      if(!empty($uploadFile)) {
                      $extUploadFile = substr($uploadFile, strrpos($uploadFile, '.')+1);
                      if(!empty($uploadFile)) {
                      if($uploadFile->saveAs(Yii::app()->basePath.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'analiz'.DIRECTORY_SEPARATOR.$model2->id.DIRECTORY_SEPARATOR.$model2->id.'.'.$extUploadFile)){
                      $model2->filename=$model2->id.'.'.$extUploadFile;
                      $model2->save();
                      $message .= 'and file uploded';
                      }
                      else{
                      $messageType = 'warning';
                      $message .= 'but file not uploded';
                      }
                      }
                      }
                     */
                    $transaction->commit();
                    Yii::app()->user->setFlash($messageType, $message);
                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
            catch (Exception $e)
            {
                $transaction->rollBack();
                Yii::app()->user->setFlash('error', "{$e->getMessage()}");
                //$this->refresh();
            }
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {

        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Analiz']))
        {
            $messageType = 'warning';
            $message = "There are some errors ";
            $transaction = Yii::app()->db->beginTransaction();
            try
            {
                $model->attributes = $_POST['Analiz'];
                $messageType = 'success';
                $message = "<strong>Well done!</strong> You successfully update data ";
           if (isset($_POST['elem']))
                    {
                        $command = Yii::app()->db->createCommand();
                        $command->delete('analiz_has_element', 'analiz_id=:id', array(':id' => $model->id));
                        $Ids = $_POST['elem'];
                        //echo '<pre>';
                        $cnt = max(array_keys($Ids));
                        $min = min(array_keys($Ids));
                        for($i = $min; $i <= $cnt; $i++)
                        {
                            $val = $Ids[$i]['val'];
                            if (isset($val) && !empty($val))
                                $command->insert('analiz_has_element', array(
                                    'analiz_id' => $model->id, ////
                                    'value' => $val,
                                    'element_id' => $i
                                ));
                        }
                    };
                /*
                  $uploadFile=CUploadedFile::getInstance($model,'filename');
                  if(!empty($uploadFile)) {
                  $extUploadFile = substr($uploadFile, strrpos($uploadFile, '.')+1);
                  if(!empty($uploadFile)) {
                  if($uploadFile->saveAs(Yii::app()->basePath.DIRECTORY_SEPARATOR.'files'.DIRECTORY_SEPARATOR.'analiz'.DIRECTORY_SEPARATOR.$model->id.DIRECTORY_SEPARATOR.$model->id.'.'.$extUploadFile)){
                  $model->filename=$model->id.'.'.$extUploadFile;
                  $message .= 'and file uploded';
                  }
                  else{
                  $messageType = 'warning';
                  $message .= 'but file not uploded';
                  }
                  }
                  }
                 */

                if ($model->save())
                {
                    $transaction->commit();
                    Yii::app()->user->setFlash($messageType, $message);
                    $this->redirect(array('view', 'id' => $model->id));
                }
            }
            catch (Exception $e)
            {
                $transaction->rollBack();
                Yii::app()->user->setFlash('error', "{$e->getMessage()}");
                // $this->refresh(); 
            }

            $model->attributes = $_POST['Analiz'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadModel($id)->deleteByPk($id);

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        /*
          $dataProvider=new CActiveDataProvider('Analiz');
          $this->render('index',array(
          'dataProvider'=>$dataProvider,
          ));
         */

        $model = new Analiz('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Analiz']))
            $model->attributes = $_GET['Analiz'];

        $this->render('index', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {

        $model = new Analiz('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Analiz']))
            $model->attributes = $_GET['Analiz'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Analiz the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Analiz::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Analiz $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'analiz-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionExport()
    {
        $model = new Analiz;
        $model->unsetAttributes();  // clear any default values
        if (isset($_POST['Analiz']))
            $model->attributes = $_POST['Analiz'];

        $exportType = $_POST['fileType'];
        $this->widget('ext.heart.export.EHeartExport', array(
            'title' => 'List of Analiz',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'grid_mode' => 'export',
            'exportType' => $exportType,
            'columns' => array(
                'id',
                'name',
                'template_id',
            ),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionImport()
    {

        $model = new Analiz;
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Analiz']))
        {
            if (!empty($_FILES))
            {
                $tempFile = $_FILES['Analiz']['tmp_name']['fileImport'];
                $fileTypes = array('xls', 'xlsx'); // File extensions
                $fileParts = pathinfo($_FILES['Analiz']['name']['fileImport']);
                if (in_array(@$fileParts['extension'], $fileTypes))
                {

                    Yii::import('ext.heart.excel.EHeartExcel', true);
                    EHeartExcel::init();
                    $inputFileType = PHPExcel_IOFactory::identify($tempFile);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($tempFile);
                    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    $baseRow = 2;
                    $inserted = 0;
                    $read_status = false;
                    while (!empty($sheetData[$baseRow]['A']))
                    {
                        $read_status = true;
                        $id = $sheetData[$baseRow]['A'];
                        $name = $sheetData[$baseRow]['B'];
                        $template_id = $sheetData[$baseRow]['C'];

                        $model2 = new Analiz;
                        $model2->id = $id;
                        $model2->name = $name;
                        $model2->template_id = $template_id;

                        try
                        {
                            if ($model2->save())
                            {
                                $inserted++;
                            }
                        }
                        catch (Exception $e)
                        {
                            Yii::app()->user->setFlash('error', "{$e->getMessage()}");
                            //$this->refresh();
                        }
                        $baseRow++;
                    }
                    Yii::app()->user->setFlash('success', ($inserted) . ' row inserted');
                }
                else
                {
                    Yii::app()->user->setFlash('warning', 'Wrong file type (xlsx, xls, and ods only)');
                }
            }


            $this->render('admin', array(
                'model' => $model,
            ));
        }
        else
        {
            $this->render('admin', array(
                'model' => $model,
            ));
        }
    }

    public function actionEditable()
    {
        Yii::import('bootstrap.widgets.TbEditableSaver');
        $es = new TbEditableSaver('Analiz');
        $es->update();
    }

    public function actions()
    {
        return array(
            'toggle' => array(
                'class' => 'bootstrap.actions.TbToggleAction',
                'modelName' => 'Analiz',
            )
        );
    }

    }