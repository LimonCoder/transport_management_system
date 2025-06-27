<?php
namespace App\Repositories;

interface OrganizationRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function getActiveOrganizations();
    public function listDataForDataTable();
    public function findByOrgCode($orgCode);
} 