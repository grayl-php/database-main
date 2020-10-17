<?php

   namespace Grayl\Test\Database\Main;

   use Grayl\Database\Main\Controller\DeleteDatabaseController;
   use Grayl\Database\Main\Controller\InsertDatabaseController;
   use Grayl\Database\Main\Controller\SelectDatabaseController;
   use Grayl\Database\Main\Controller\UpdateDatabaseController;
   use Grayl\Database\Main\DatabasePorter;
   use Grayl\Database\Query\Controller\DeleteQueryController;
   use Grayl\Database\Query\Controller\InsertQueryController;
   use Grayl\Database\Query\Controller\SelectQueryController;
   use Grayl\Database\Query\Controller\UpdateQueryController;
   use Grayl\Gateway\PDO\PDOPorter;
   use PHPUnit\Framework\TestCase;

   /**
    * Test class for the Database package.
    *
    * @package Grayl\Database\Main
    */
   class DatabaseControllerTest extends TestCase
   {

      /**
       * A unique ID for this test.
       *
       * @var string
       */
      protected static string $id;


      /**
       * Test setup for sandbox environment.
       */
      public static function setUpBeforeClass (): void
      {

         // Change the PDO API environment to sandbox mode
         PDOPorter::getInstance()
                  ->setEnvironment( 'sandbox' );

         // Set a unique tag
         self::$id = self::generateHash( 6 );
      }


      /**
       * Tests the creation of a valid InsertDatabaseController entity.
       *
       * @return InsertDatabaseController
       * @throws \Exception
       */
      public function testCreateInsertDatabaseController (): InsertDatabaseController
      {

         // Create a controller
         $controller = DatabasePorter::getInstance()
                                     ->newInsertDatabaseController( 'default' );

         // Get the QueryController entity
         $query = $controller->getQueryController();

         // Check the type of object created
         $this->assertInstanceOf( InsertQueryController::class,
                                  $query );

         // Build the query
         $query->insert( [ 'name'  => self::$id,
                           'value' => 'inserted', ] )
               ->into( 'query_test_table' );

         // Return it
         return $controller;
      }


      /**
       * Tests the data in a InsertDatabaseController.
       *
       * @param InsertDatabaseController $controller An InsertDatabaseController to test.
       *
       * @depends testCreateInsertDatabaseController
       * @throws \Exception
       */
      public function testInsertDatabaseControllerData ( InsertDatabaseController $controller ): void
      {

         // Run the query
         $result = $controller->runQuery();

         // Make sure a last insert ID was given
         $this->assertGreaterThan( 0,
                                   $result->getReferenceID() );
         $this->assertGreaterThan( 0,
                                   $result->countRows() );
      }


      /**
       * Tests the creation of a valid UpdateDatabaseController entity.
       *
       * @return UpdateDatabaseController
       * @throws \Exception
       */
      public function testCreateUpdateDatabaseController (): UpdateDatabaseController
      {

         // Create a controller
         $controller = DatabasePorter::getInstance()
                                     ->newUpdateDatabaseController( 'default' );

         // Get the QueryController entity
         $query = $controller->getQueryController();

         // Check the type of object created
         $this->assertInstanceOf( UpdateQueryController::class,
                                  $query );

         // Build the query
         $query->update( 'query_test_table' )
               ->set( [ 'value' => 'updated' ] )
               ->where( 'name',
                        '=',
                        self::$id )
               ->orderBy( [ 'name' ] )
               ->direction( 'ASC' )
               ->limit( 1 );

         // Return it
         return $controller;
      }


      /**
       * Tests the data in a UpdateDatabaseController.
       *
       * @param UpdateDatabaseController $controller An UpdateDatabaseController to test.
       *
       * @depends testCreateUpdateDatabaseController
       * @throws \Exception
       */
      public function testUpdateDatabaseControllerData ( UpdateDatabaseController $controller ): void
      {

         // Run the query
         $result = $controller->runQuery();

         // Make sure a last insert ID was given
         $this->assertEmpty( $result->getReferenceID() );
         $this->assertGreaterThan( 0,
                                   $result->countRows() );
      }


      /**
       * Tests the creation of a valid SelectDatabaseController entity.
       *
       * @return SelectDatabaseController
       * @throws \Exception
       */
      public function testCreateSelectDatabaseController (): SelectDatabaseController
      {

         // Create a controller
         $controller = DatabasePorter::getInstance()
                                     ->newSelectDatabaseController( 'default' );

         // Get the QueryController entity
         $query = $controller->getQueryController();

         // Check the type of object created
         $this->assertInstanceOf( SelectQueryController::class,
                                  $query );

         // Build the query
         $query->select( [ 'row_id',
                           'name',
                           'value', ] )
               ->from( 'query_test_table' )
               ->where( 'row_id',
                        '>',
                        0 )
               ->andWhere( 'name',
                           '=',
                           self::$id )
               ->orderBy( [ 'name' ] )
               ->direction( 'ASC' )
               ->limit( 1 );

         // Return it
         return $controller;
      }


      /**
       * Tests the data in a SelectDatabaseController.
       *
       * @param SelectDatabaseController $controller A SelectDatabaseController to test.
       *
       * @depends testCreateSelectDatabaseController
       * @throws \Exception
       */
      public function testSelectDatabaseControllerData ( SelectDatabaseController $controller ): void
      {

         // Run the query
         $result = $controller->runQuery();

         // Make sure a last insert ID was given
         $this->assertEmpty( $result->getReferenceID() );
         $this->assertGreaterThan( 0,
                                   $result->countRows() );

         // Fetch the data
         $row = $result->fetchNextRowAsArray();

         // Test data
         $this->assertGreaterThan( 0,
                                   $row[ 'row_id' ] );

         $this->assertEquals( self::$id,
                              $row[ 'name' ] );
         $this->assertEquals( 'updated',
                              $row[ 'value' ] );
      }


      /**
       * Tests the creation of a valid DeleteDatabaseController entity.
       *
       * @return DeleteDatabaseController
       * @throws \Exception
       */
      public function testCreateDeleteDatabaseController (): DeleteDatabaseController
      {

         // Create a controller
         $controller = DatabasePorter::getInstance()
                                     ->newDeleteDatabaseController( 'default' );

         // Get the QueryController entity
         $query = $controller->getQueryController();

         // Check the type of object created
         $this->assertInstanceOf( DeleteQueryController::class,
                                  $query );

         // Build the query
         $query->delete()
               ->from( 'query_test_table' )
               ->where( 'name',
                        '=',
                        self::$id )
               ->limit( 1 );

         // Return it
         return $controller;
      }


      /**
       * Tests the data in a DeleteDatabaseController.
       *
       * @param DeleteDatabaseController $controller A DeleteDatabaseController to test.
       *
       * @depends testCreateDeleteDatabaseController
       * @throws \Exception
       */
      public function testDeleteDatabaseControllerData ( DeleteDatabaseController $controller ): void
      {

         // Run the query
         $result = $controller->runQuery();

         // Make sure a last insert ID was given
         $this->assertEmpty( $result->getReferenceID() );
         $this->assertGreaterThan( 0,
                                   $result->countRows() );
      }


      /**
       * Generates a unique testing hash.
       *
       * @param int $length The length of the hash.
       *
       * @return string
       */
      private static function generateHash ( int $length ): string
      {

         // Generate a random string
         $hash = openssl_random_pseudo_bytes( $length );

         // Convert the binary data into hexadecimal representation and return it
         $hash = strtoupper( bin2hex( $hash ) );

         // Trim to length and return
         return substr( $hash,
                        0,
                        $length );
      }

   }
