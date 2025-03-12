<?php

namespace App\Services\Interfaces;

interface IDatabase
{
    public function getCollection(string $collectionName): array;
    public function getDocument(string $collectionName, string $documentId): ?array;
    public function saveDocument(string $collectionName, string $documentId, array $data): bool;
    public function deleteDocument(string $collectionName, string $documentId): bool;
    public function getAllDocuments(string $collectionName): array;
    public function updateDocument(string $collectionName, string $documentId, array $data): bool;
}
