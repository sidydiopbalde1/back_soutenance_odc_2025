<?php
namespace App\Services\Mongoose;

use App\Services\Interfaces\IDatabase;
use MongoDB\Client;
use MongoDB\Model\BSONDocument;

class MongoDBService implements IDatabase
{
    protected $client;
    protected $database;

    public function __construct()
    {
        $mongoUri = config('services.mongodb.uri');
        $this->client = new Client($mongoUri);
        $this->database = $this->client->selectDatabase($this->getDatabaseNameFromUri($mongoUri));
    }

    protected function getDatabaseNameFromUri(string $mongoUri): string
    {
        $parsedUrl = parse_url($mongoUri);
        return trim($parsedUrl['path'], '/');
    }

    public function getCollection(string $collectionName): array
    {
        return $this->database->selectCollection($collectionName)->find()->toArray();
    }

    public function getDocument(string $collectionName, string $documentId): ?array
    {
        $document = $this->database->selectCollection($collectionName)->findOne(['_id' => $documentId]);

        // Vérifiez si un document est trouvé, puis convertissez-le en tableau
        return $document instanceof BSONDocument ? $document->getArrayCopy() : null;
    }

    public function saveDocument(string $collectionName, string $documentId, array $data): bool
    {
        $result = $this->database->selectCollection($collectionName)->updateOne(
            ['_id' => $documentId],
            ['$set' => $data],
            ['upsert' => true]
        );

        return $result->getModifiedCount() > 0 || $result->getUpsertedCount() > 0;
    }

    public function deleteDocument(string $collectionName, string $documentId): bool
    {
        $result = $this->database->selectCollection($collectionName)->deleteOne(['_id' => $documentId]);
        return $result->getDeletedCount() > 0;
    }

    public function getAllDocuments(string $collectionName): array
    {
        return $this->database->selectCollection($collectionName)->find()->toArray();
    }

    public function updateDocument(string $collectionName, string $documentId, array $data): bool
    {
        $result = $this->database->selectCollection($collectionName)->updateOne(
            ['_id' => $documentId],
            ['$set' => $data]
        );

        return $result->getModifiedCount() > 0;
    }

}
