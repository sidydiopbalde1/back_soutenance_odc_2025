<?php

namespace Tests\Unit;

use App\Services\Mongoose\MongoDBService;
use Tests\TestCase;

class MongoDBServiceTest extends TestCase
{
    protected MongoDBService $mongoService;

    protected function setUp(): void
    {
        parent::setUp();
        // Initialiser le service MongoDB avec les configurations
        $this->mongoService = new MongoDBService();
    }

    /**
     * Test de la connexion à MongoDB.
     */
    public function test_mongodb_connection()
    {
        try {
            // Récupérer une collection pour valider la connexion
            $collections = $this->mongoService->getCollection('test_collection');

            // Assertion : la collection doit être un tableau
            $this->assertIsArray($collections, 'MongoDB connection is successful and collection is accessible.');
        } catch (\Exception $e) {
            $this->fail("MongoDB connection failed: " . $e->getMessage());
        }
    }

    /**
     * Test de l'insertion et de la récupération d'un document.
     */
    public function test_save_and_get_document()
    {
        $testData = [
            '_id' => uniqid(),
            'libelle' => 'Campagne Marketing',
            'description' => 'Campagne pour promouvoir le produit X',
        ];

        // Sauvegarder un document
        $isSaved = $this->mongoService->saveDocument('test_collection', $testData['_id'], $testData);

        // Assertion : vérifiez si le document a bien été sauvegardé
        $this->assertTrue($isSaved, 'Document should be saved successfully.');

        // Récupérer le document
        $document = $this->mongoService->getDocument('test_collection', $testData['_id']);

        // Assertions
        $this->assertNotNull($document, 'Document should be found in the collection.');
        $this->assertEquals($testData['libelle'], $document['libelle'], 'Document libelle should match.');
        $this->assertEquals($testData['description'], $document['description'], 'Document description should match.');
    }
}

