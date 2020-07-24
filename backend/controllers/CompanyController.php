<?php

namespace backend\controllers;

use backend\models\User;
use Yii;
use backend\models\Company;
use backend\models\search\CompanySearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * CompanyController implements the CRUD actions for Company model.
 */
class CompanyController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'export-csv', 'export-pdf'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN ,  User::ROLE_ADMIN_VIEW],
                    ],

                    [
                        //'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => [User::ROLE_ADMIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Company models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Company model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Company model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Company();

        if ($model->load(Yii::$app->request->post())) {

            // get the instance of the uploaded file
            $model->logoUploaded = UploadedFile::getInstance($model, 'logoUploaded');

            if($model->uploadLogo()) {
                $model->save(false);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Company model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {


            // get the instance of the uploaded file
            $model->logoUploaded = UploadedFile::getInstance($model, 'logoUploaded');

            if($model->uploadLogo()){ // If image upload is done successfully
                $model->save(false);
                return $this->redirect(['view', 'id' => $model->id]);

            };
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Company model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     * @throws \yii\web\NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->deleteAttachments();
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Company model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Company the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Company::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Export Data to CSV
     */
    public function actionExportCsv()
    {
        $query = Company::find();
        $filter = Yii::$app->request->post();

        $filter['name'] ? $query->andFilterWhere(['name' => $filter['name']]) : null;
        $filter['city'] ? $query->andWhere(['city' => $filter['city']]) : null;
        $filter['address'] ? $query->andWhere(['address' => $filter['address']]) : null;
        $filter['primary_contact'] ? $query->andWhere(['primary_contact' => $filter['primary_contact']]) : null;
        $filter['status'] ? $query->andWhere(['status' => $filter['status']]) : null;

        $data = $query->asArray()->all();

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename=companies' . date('Y/m/d h:m:s') . '.csv');

        $output = fopen("php://output", "w");
        fputcsv($output, [
            Yii::t('app', 'Name'),
            Yii::t('app', 'City'),
            Yii::t('app', 'Address'),
            Yii::t('app', 'Primary Contact'),
            Yii::t('app', 'Primary Phone'),
            Yii::t('app', 'Primary Email'),
            Yii::t('app', 'Fax Number'),
            Yii::t('app', 'Status'),
            Yii::t('app', 'Description'),
            Yii::t('app', 'Created At')
        ]);

        foreach ($data as $row) {
            fputcsv($output, [
                $row['name'],
                $row['city'],
                $row['address'],
                $row['primary_contact'],
                $row['primary_phone'],
                $row['primary_email'],
                $row['fax_number'],
                $row['status'] ? Company::getCompanyStatusByIndex($row['status']) : '',
                $row['description'],
                $row['created_at']
            ]);
        }
        fclose($output);
        exit();
    }

    /**
     * Export Data to PDF
     */
    public function actionExportPdf()
    {
        $searchModel = new CompanySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $html = $this->renderPartial('_pdf', ['dataProvider' => $dataProvider]);
        $mpdf = new \mPDF('c', 'A4', '', '', 0, 0, 0, 0, 0, 0);
        $mpdf->SetDisplayMode('fullpage');
        $mpdf->list_indent_first_level = 0;  // 1 or 0 - whether to indent the first level of a list
        $mpdf->WriteHTML($html);
        $mpdf->Output();
        exit;
    }
}
