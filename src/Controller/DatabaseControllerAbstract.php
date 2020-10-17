<?php

   namespace Grayl\Database\Main\Controller;

   use Grayl\Database\Main\Service\DatabaseService;
   use Grayl\Database\Query\Controller\QueryControllerAbstract;
   use Grayl\Gateway\PDO\Controller\PDOQueryRequestController;
   use Grayl\Gateway\PDO\Controller\PDOQueryResponseController;

   /**
    * Abstract class DatabaseController.
    * The abstract controller for working with Database Queries.
    *
    * @package Grayl\Database\Main
    */
   abstract class DatabaseControllerAbstract
   {

      /**
       * A configured PDOQueryRequestController entity.
       *
       * @var PDOQueryRequestController
       */
      protected PDOQueryRequestController $pdo_request_controller;

      /**
       * A configured QueryControllerAbstract entity.
       *
       * @var QueryControllerAbstract
       */
      protected QueryControllerAbstract $query_controller;

      /**
       * The DatabaseService instance to interact with.
       *
       * @var DatabaseService
       */
      protected DatabaseService $database_service;


      /**
       * The class constructor.
       *
       * @param PDOQueryRequestController $pdo_request_controller A configured PDOQueryRequestController entity.
       * @param QueryControllerAbstract   $query_controller       A configured QueryControllerAbstract entity.
       * @param DatabaseService           $database_service       The DatabaseService instance to use.
       */
      public function __construct ( PDOQueryRequestController $pdo_request_controller,
                                    QueryControllerAbstract $query_controller,
                                    DatabaseService $database_service )
      {

         // Set the entities
         $this->pdo_request_controller = $pdo_request_controller;
         $this->query_controller       = $query_controller;

         // Set the service entity
         $this->database_service = $database_service;
      }


      /**
       * Returns the QueryControllerAbstract object for modification.
       *
       * @return QueryControllerAbstract
       * @throws \Exception
       */
      public function getQueryController (): QueryControllerAbstract
      {

         // Return the QueryControllerAbstract
         return $this->query_controller;
      }


      /**
       * Runs a QueryControllerAbstract against a PDOQueryRequestController and returns the result.
       *
       * @return PDOQueryResponseController
       * @throws \Exception
       */
      public function runQuery (): PDOQueryResponseController
      {

         // Return a new PDOQueryRequestData via the service
         return $this->database_service->runQuery( $this->pdo_request_controller,
                                                   $this->query_controller );
      }

   }