use MongoDB\Client as MongoClient;

class ExampleJob
{
    protected $mongoClient;

    public function __construct()
    {
        $this->mongoClient = new MongoClient();
    }

    public function handle()
    {
        // Use the MongoDB client without serializing it
        $collection = $this->mongoClient->test->users;
    }
}
