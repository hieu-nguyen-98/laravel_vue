<?php
namespace App\Repositories;

use App\Models\Client;
use App\Enums\TypePaginate;

class ClientRepository implements BaseRepositoryInterface
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function all()
    {
        return Client::all();
    }

    public function find($id)
    {
        return Client::find($id);
    }

    public function create(array $data)
    {
        return Client::create($data);
    }

    public function update($id, array $data)
    {
        $client = Client::find($id);
        $client->update($data);
        return $client;
    }

    public function delete($id)
    {
        $client = Client::find($id);
        $client->delete();
    }

}