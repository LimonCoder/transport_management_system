<?php
namespace App\Repositories;

interface TripRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function listDataForDataTable();
    public function createTripWithAuditLog(array $data);
    public function updateTripWithAuditLog($id, array $data);
    public function getTripsForReport(array $data);
    public function detailsListDataForDataTable();
    public function updateTripDetails($id, array $data);
} 