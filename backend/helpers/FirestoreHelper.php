<?php
namespace backend\helpers;

use common\models\FreeQar;
use common\models\FreeQarResult;
use common\models\FreeSites;
use common\models\FreeUsers;
use common\models\Settings;
use MrShan0\PHPFirestore\FirestoreClient;
use Yii;

class FirestoreHelper
{
    public $firestoreClient;
    const USERS_COLLECTION_NAME = "users";
    const QAR_COLLECTION_NAME = "qar_listing";
    const QAR_RESULT_COLLECTION_NAME = "qar_results";
    const QAR_PROCESSING_COLLECTION_NAME = "qap_data";
    const SITES_COLLECTION_NAME = "sites";
    const SYNC_TIME_SETTING = "fireStoreSyncTime";

    /**
     * Initialize class dependencies
     * FirestoreHelper constructor.
     */
    function __construct()
    {
        $this->firestoreClient = new FirestoreClient(Yii::$app->params["FIREBASE_PROJECT_ID"], Yii::$app->params["FIREBASE_API_KEY"], [
            'database' => '(default)',
        ]);
    }

    /**
     * List all documents in a collection
     * @param $collectionName
     *
     * @return array
     */
    public function listDocumentsInACollection($collectionName){
        return $this->firestoreClient->listDocuments($collectionName,
            [
                'pageSize' => 2147483647,
                //'orderBy' => 'updateTime'
            ]
        );
    }

    /**
     * Get document given the path
     * @param $documentPath
     */
    public function getDocument($documentPath){
        $this->firestoreClient->getDocument($documentPath);
    }

    public function updateFreeVersionDb(){

        $transaction = Yii::$app->db->beginTransaction();
        try {
            /*
             * Save users from firebase
             */
            $updateUserDocuments = $this->saveFreeVersionUsers();
            $this->cleanFreeVersionUsers($updateUserDocuments);
            /*
             * End save users
             */


            /*
             * Save sites from firebase
             */
            $updateUserDocuments = $this->saveFreeVersionSites();
            $this->cleanFreeVersionSites($updateUserDocuments);
            /*
             * End save sites
             */

            /*
            * Save qars from firebase
            */
            $updateUserDocuments = $this->saveFreeVersionQarList();
            $this->cleanFreeVersionQar($updateUserDocuments);
            /*
             * End save qars
             */

            /*
            * Save qars result from firebase
            */
            $updateUserDocuments = $this->saveFreeVersionQarResultList();
            $this->cleanFreeVersionQarResult($updateUserDocuments);
            /*
             * End save qars result
             */


            /*
            * Save qars result location data
            */
            $this->saveFreeVersionQarProcessingList();
            /*
             * End save qars result
             */

            $transaction->commit();
            $this->updateSyncTime();
            return true;
        } catch (\Exception $e){
            Yii::error("Could not update free version database");
            $transaction->rollBack();
        }
        return false;
    }

    /**
     * Helps to save free version users
     * @return array
     */
    public function saveFreeVersionUsers(){

        $usersFromFirebase = $this->listDocumentsInACollection(self::USERS_COLLECTION_NAME);

        $foundDocumentIds = [];
        foreach ($usersFromFirebase['documents'] as $item){

            // Instantiate new free users object
            $freeVersionUser = new FreeUsers();

            //Fetch document id
            $freeVersionUser->document_id = self::convertLongDocumentNameToSmall($item->getName());

            if(FreeUsers::find()->where(["document_id"=>$freeVersionUser->document_id])->exists())
                $freeVersionUser->isNewRecord = false;

            $freeVersionUser->user_type = $this->getDocumentKey($item, "user_type");
            $freeVersionUser->names = $this->getDocumentKey($item, "names");
            $freeVersionUser->email = $this->getDocumentKey($item, "email");
            $freeVersionUser->telephone = $this->getDocumentKey($item, "telephone");
            $freeVersionUser->created_at = $this->getDocumentKey($item, "created_at");
            $freeVersionUser->updated_at = $this->getDocumentKey($item, "updated_at");

            if($freeVersionUser->created_at)
                $freeVersionUser->created_at = date("Y-m-d H:i:s", strtotime($freeVersionUser->created_at));

            if($freeVersionUser->updated_at)
                $freeVersionUser->updated_at = date("Y-m-d H:i:s", strtotime($freeVersionUser->updated_at));

            if(!$freeVersionUser->save())
                var_dump($freeVersionUser->getErrors());
            else
                array_push($foundDocumentIds, $freeVersionUser->document_id);
        }

        return $foundDocumentIds;
    }

    /**
     * Helps to save free version sites
     * @return array
     */
    public function saveFreeVersionSites(){

        $sitesFromFirebase = $this->listDocumentsInACollection(self::SITES_COLLECTION_NAME);

        $foundDocumentIds = [];
        foreach ($sitesFromFirebase['documents'] as $item){

            // Instantiate new free users object
            $freeVersionSite = new FreeSites();

            //Fetch document id
            $freeVersionSite->document_id = self::convertLongDocumentNameToSmall($item->getName());

            if(FreeSites::find()->where(["document_id"=>$freeVersionSite->document_id])->exists())
                $freeVersionSite->isNewRecord = false;

            $freeVersionSite->name = $this->getDocumentKey($item, "name");
            $freeVersionSite->location = $this->getDocumentKey($item, "location");
            $freeVersionSite->owner = $this->getDocumentKey($item, "owner");
            $freeVersionSite->created_at = $this->getDocumentKey($item, "created_at");
            $freeVersionSite->updated_at = $this->getDocumentKey($item, "updated_at");

            if($freeVersionSite->created_at)
                $freeVersionSite->created_at = date("Y-m-d H:i:s", strtotime($freeVersionSite->created_at));

            if($freeVersionSite->updated_at)
                $freeVersionSite->updated_at = date("Y-m-d H:i:s", strtotime($freeVersionSite->updated_at));

            if(!$freeVersionSite->save())
                var_dump($freeVersionSite->getErrors());
            else
                array_push($foundDocumentIds, $freeVersionSite->document_id);
        }

        return $foundDocumentIds;
    }



    /**
     * Helps to save free version sites
     * @return array
     */
    public function saveFreeVersionQarList(){

        $qarFromFirebase = $this->listDocumentsInACollection(self::QAR_COLLECTION_NAME);

        $foundDocumentIds = [];
        foreach ($qarFromFirebase['documents'] as $item){

            // Instantiate new free users object
            $freeVersionQar = new FreeQar();

            //Fetch document id
            $freeVersionQar->document_id = self::convertLongDocumentNameToSmall($item->getName());

            if(FreeQar::find()->where(["document_id"=>$freeVersionQar->document_id])->exists())
                $freeVersionQar->isNewRecord = false;

            $siteDocumentId = null;
            try {
                $freeVersionQar->site = $this->getDocumentKey($item, "site");
            } catch (\Exception $e){
                Yii::error("could not extract site document id");
            }

            $fieldTechDocumentId = null;
            try {
                $freeVersionQar->field_tech = $this->getDocumentKey($item, "field_tech");
            } catch (\Exception $e){
                Yii::error("could not extract field_tech document id");
            }


            try {
                $freeVersionQar->buyer = $this->getDocumentKey($item, "buyer");
            } catch (\Exception $e){
                Yii::error("could not extract buyer document id");
            }

            $freeVersionQar->status = $this->getDocumentKey($item, "status");

            $freeVersionQar->created_at = $this->getDocumentKey($item, "created_at");

            $freeVersionQar->updated_at = $this->getDocumentKey($item, "updated_at");

            if($freeVersionQar->created_at)
                $freeVersionQar->created_at = date("Y-m-d H:i:s", strtotime($freeVersionQar->created_at));

            if($freeVersionQar->updated_at)
                $freeVersionQar->updated_at = date("Y-m-d H:i:s", strtotime($freeVersionQar->updated_at));

            if(!$freeVersionQar->save())
                var_dump($freeVersionQar->getErrors());
            else
                array_push($foundDocumentIds, $freeVersionQar->document_id);
        }

        return $foundDocumentIds;
    }



    public function saveFreeVersionQarResultList(){

        $qarResultFromFirebase = $this->listDocumentsInACollection(self::QAR_RESULT_COLLECTION_NAME);

        $foundDocumentIds = [];
        foreach ($qarResultFromFirebase['documents'] as $item){

            // Instantiate new free users object
            $freeVersionQarResult = new FreeQarResult();

            //Fetch document id
            $freeVersionQarResult->document_id = self::convertLongDocumentNameToSmall($item->getName());

            if(FreeQarResult::find()->where(["document_id"=>$freeVersionQarResult->document_id])->exists())
                $freeVersionQarResult->isNewRecord = false;

            $freeVersionQarResult->qar = self::convertLongDocumentNameToSmall($this->getDocumentKey($item, "request_id"));

            $freeVersionQarResult->kor = $this->getDocumentKey($item, "kor");
            $freeVersionQarResult->defective_rate = $this->getDocumentKey($item, "defective_rate");
            $freeVersionQarResult->foreign_material_rate = $this->getDocumentKey($item, "foreign_mat_rate");
            $freeVersionQarResult->moisture_content = $this->getDocumentKey($item, "moisture_content");
            $freeVersionQarResult->nut_count = $this->getDocumentKey($item, "nut_count");
            $freeVersionQarResult->useful_kernel = $this->getDocumentKey($item, "useful_kernel");
            $freeVersionQarResult->total_volume_of_stock = $this->getDocumentKey($item, "total_volume_of_stock");

            $freeVersionQarResult->created_at = $this->getDocumentKey($item, "created_at");

            $freeVersionQarResult->updated_at = $this->getDocumentKey($item, "updated_at");

            if($freeVersionQarResult->created_at)
                $freeVersionQarResult->created_at = date("Y-m-d H:i:s", strtotime($freeVersionQarResult->created_at));

            if($freeVersionQarResult->updated_at)
                $freeVersionQarResult->updated_at = date("Y-m-d H:i:s", strtotime($freeVersionQarResult->updated_at));

            if(!$freeVersionQarResult->save())
                var_dump($freeVersionQarResult->getErrors());
            else
                array_push($foundDocumentIds, $freeVersionQarResult->document_id);
        }

        return $foundDocumentIds;
    }



    public function saveFreeVersionQarProcessingList(){

        $qarProcessingFromFirebase = $this->listDocumentsInACollection(self::QAR_PROCESSING_COLLECTION_NAME);

        var_dump(count($qarProcessingFromFirebase['documents']));

        foreach ($qarProcessingFromFirebase['documents'] as $item){

            $qar_id = $this->getDocumentKey($item, "request_id");
            $good_kernel = $this->getDocumentKey($item, "good_kernel");

            $location_array = [];

            try {
                if(isset($good_kernel[0]["location"])){
                    $locationData = $good_kernel[0]["location"]->getData();
                    $locationCoordinates = $locationData[0]["coords"]->getData();
                    $location_array = $locationCoordinates[0];
                }
            } catch (\Exception $exception){
                Yii::error("Could not fetch location data");
            }


            if(!empty($location_array)){
                $result = FreeQarResult::find()->where(["qar"=>$qar_id])->one();

                if($result){
                    $result->location_accuracy = $location_array["accuracy"];
                    $result->location_altitude = $location_array["altitude"];
                    $result->location_lat = $location_array["latitude"];
                    $result->location_lon = $location_array["longitude"];
                    if(!$result->save(false)){
                        Yii::error($result->getErrors());
                    }
                }
            }
        }
    }


    /**
     * Parse long document name
     * @param $longDocumentName
     */
    public static function convertLongDocumentNameToSmall($longDocumentName){
        $documentSections = explode("/", $longDocumentName);
        if($documentSections && !empty($documentSections))
            return $documentSections[count($documentSections)-1];
        return null;
    }

    /**
     * Get key in document
     * @param $document
     * @param $key
     *
     * @return bool|float|int|string|null
     */
    public function getDocumentKey($document, $key){

        $value = null;

        try {
            $value =  $document->get($key);
        } catch (\MrShan0\PHPFirestore\Exceptions\Client\FieldNotFound $e) {
            Yii::error($e->getMessage());
            return null;
        }

        // if variable type is primitive, return the value
        if(is_scalar($value))
            return $value;

        // else, it is an object, return
        return $value ?  $value->getData() : null;
    }

    /**
     * Delete documents that appear to have been removed in source
     * @param $updateUserDocuments
     */
    private function cleanFreeVersionUsers($updateUserDocuments)
    {
        if(!empty($updateUserDocuments))
            FreeUsers::deleteAll(["not in", "document_id", $updateUserDocuments]);
    }


    /**
     * Delete documents that appear to have been removed in source
     * @param $updateUserDocuments
     */
    private function cleanFreeVersionSites($updateUserDocuments)
    {
        if(!empty($updateUserDocuments))
            FreeSites::deleteAll(["not in", "document_id", $updateUserDocuments]);
    }


    /**
     * Delete documents that appear to have been removed in source
     * @param $updateUserDocuments
     */
    private function cleanFreeVersionQar($updateUserDocuments)
    {
        if(!empty($updateUserDocuments))
            FreeQar::deleteAll(["not in", "document_id", $updateUserDocuments]);
    }

    /**
     * Delete documents that appear to have been removed in source
     * @param $updateUserDocuments
     */
    private function cleanFreeVersionQarResult($updateUserDocuments)
    {
        if(!empty($updateUserDocuments))
            FreeQarResult::deleteAll(["not in", "document_id", $updateUserDocuments]);
    }

    private function updateSyncTime()
    {
        $latestSyncTime = Settings::findOne(self::SYNC_TIME_SETTING);
        if(!$latestSyncTime) {
            $latestSyncTime = new Settings();
            $latestSyncTime->key = self::SYNC_TIME_SETTING;
        }
        $latestSyncTime->value = date("Y-m-d H:i:s", strtotime("now"));
        $latestSyncTime->save();
    }
}