<?php

   namespace Grayl\Database\Main;

   use Grayl\Database\Main\Controller\DeleteDatabaseController;
   use Grayl\Database\Main\Controller\InsertDatabaseController;
   use Grayl\Database\Main\Controller\SelectDatabaseController;
   use Grayl\Database\Main\Controller\UpdateDatabaseController;
   use Grayl\Database\Main\Service\DatabaseService;
   use Grayl\Database\Query\QueryPorter;
   use Grayl\Gateway\PDO\PDOPorter;
   use Grayl\Mixin\Common\Traits\StaticTrait;

   /**
    * Front-end for the Database package.
    *
    * @package Grayl\Database\Main
    */
   class DatabasePorter
   {

      // Use the static instance trait
      use StaticTrait;

      /**
       * Creates a new SelectDatabaseController entity.
       *
       * @param string $database_id The database ID to use.
       *
       * @return SelectDatabaseController
       * @throws \Exception
       */
      public function newSelectDatabaseController ( string $database_id ): SelectDatabaseController
      {

         // Grab the default PDORequestController
         $pdo_request_controller = PDOPorter::getInstance()
                                            ->newPDOQueryRequestController( $database_id,
                                                                            'select',
                                                                            '',
                                                                            [], );

         // Return the controller
         return new SelectDatabaseController( $pdo_request_controller,
                                              QueryPorter::getInstance()
                                                         ->newSelectQueryController(),
                                              new DatabaseService() );
      }


      /**
       * Creates a new InsertDatabaseController entity.
       *
       * @param string $database_id The database ID to use.
       *
       * @return InsertDatabaseController
       * @throws \Exception
       */
      public function newInsertDatabaseController ( string $database_id ): InsertDatabaseController
      {

         // Grab the default PDORequestController
         $pdo_request_controller = PDOPorter::getInstance()
                                            ->newPDOQueryRequestController( $database_id,
                                                                            'insert',
                                                                            '',
                                                                            [], );

         // Return the controller
         return new InsertDatabaseController( $pdo_request_controller,
                                              QueryPorter::getInstance()
                                                         ->newInsertQueryController(),
                                              new DatabaseService() );
      }


      /**
       * Creates a new UpdateDatabaseController entity.
       *
       * @param string $database_id The database ID to use.
       *
       * @return UpdateDatabaseController
       * @throws \Exception
       */
      public function newUpdateDatabaseController ( string $database_id ): UpdateDatabaseController
      {

         // Grab the default PDORequestController
         $pdo_request_controller = PDOPorter::getInstance()
                                            ->newPDOQueryRequestController( $database_id,
                                                                            'update',
                                                                            '',
                                                                            [] );

         // Return the controller
         return new UpdateDatabaseController( $pdo_request_controller,
                                              QueryPorter::getInstance()
                                                         ->newUpdateQueryController(),
                                              new DatabaseService() );
      }


      /**
       * Creates a new DeleteDatabaseController entity.
       *
       * @param string $database_id The database ID to use.
       *
       * @return DeleteDatabaseController
       * @throws \Exception
       */
      public function newDeleteDatabaseController ( string $database_id ): DeleteDatabaseController
      {

         // Grab the default PDORequestController
         $pdo_request_controller = PDOPorter::getInstance()
                                            ->newPDOQueryRequestController( $database_id,
                                                                            'delete',
                                                                            '',
                                                                            [] );

         // Return the controller
         return new DeleteDatabaseController( $pdo_request_controller,
                                              QueryPorter::getInstance()
                                                         ->newDeleteQueryController(),
                                              new DatabaseService() );
      }

   }