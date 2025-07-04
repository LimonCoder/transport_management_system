<?php
namespace App\Repositories;

interface DriverRepositoryInterface
{
    public function all();
    public function find($id);
    public function update($id, array $data);
    public function delete($id);
    public function listDataForDataTable();
    public function createWithUser(array $data);
    public function getActiveDrivers();
} 

