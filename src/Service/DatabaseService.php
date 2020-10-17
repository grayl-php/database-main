<?php

   namespace Grayl\Database\Main\Service;

   use Grayl\Database\Query\Controller\QueryControllerAbstract;
   use Grayl\Gateway\PDO\Controller\PDOQueryRequestController;
   use Grayl\Gateway\PDO\Controller\PDOQueryResponseController;

   /**
    * Class DatabaseService.
    * The service for working with Database entities.
    *
    * @package Grayl\Database\Main
    */
   class DatabaseService
   {

      /**
       * Runs a QueryControllerAbstract against a PDOQueryRequestController and returns the result.
       *
       * @param PDOQueryRequestController $pdo_request_controller A fully configured PDOQueryRequestController.
       * @param QueryControllerAbstract   $query_controller       A fully populated QueryControllerAbstract entity.
       *
       * @return PDOQueryResponseController
       * @throws \Exception
       */
      public function runQuery ( PDOQueryRequestController $pdo_request_controller,
                                 QueryControllerAbstract $query_controller ): PDOQueryResponseController
      {

         // Translate data from the QueryController into the PDO request controller
         $this->translateQueryController( $pdo_request_controller,
                                          $query_controller );

         // Return a new PDOQueryRequestData
         return $pdo_request_controller->sendRequest();
      }


      /**
       * Translates a QueryControllerAbstract into a PDOQueryRequestController.
       *
       * @param PDOQueryRequestController $pdo_request_controller A fully configured PDOQueryRequestController.
       * @param QueryControllerAbstract   $query_controller       A fully populated QueryControllerAbstract entity.
       *
       * @throws \Exception
       */
      private function translateQueryController ( PDOQueryRequestController $pdo_request_controller,
                                                  QueryControllerAbstract $query_controller ): void
      {

         // Grab the PDO request data entity
         $request_data = $pdo_request_controller->getRequestData();

         // Set the data from the QueryController into the PDOQueryRequestController
         $request_data->setAction( $query_controller->getAction() );
         $request_data->setSQLQuery( $query_controller->getSQL() );
         $request_data->setPlaceholders( $query_controller->getPlaceholders() );
      }

   }