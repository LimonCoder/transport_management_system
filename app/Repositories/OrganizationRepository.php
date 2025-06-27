<?php
namespace App\Repositories;

use App\Models\V2\Organization;
use App\Models\V2\Operator;
use App\Models\V1\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class OrganizationRepository implements OrganizationRepositoryInterface
{
    public function all()
    {
        return Organization::latest()->get();
    }

    public function find($id)
    {
        return Organization::findOrFail($id);
    }

    public function create(array $data)
    {
        try {
            return DB::transaction(function () use ($data) {
                // Use user-provided organization code
                $orgCode = $data['organization_code'];
                
                // Create organization
                $organizationData = [
                    'org_code' => $orgCode,
                    'name' => $data['name'],
                    'address' => $data['address'] ?? null,
                    'org_type' => $data['org_type'],
                    'created_by' => Auth::user()->id ?? 1,
                ];
                
                $organization = Organization::create($organizationData);
                
                // Create operator user and operator record
                $this->createOperatorWithUser($organization);
                
                return $organization;
            });
        } catch (\Exception $e) {
            throw new \Exception('Organization creation failed: ' . $e->getMessage());
        }
    }

    public function update($id, array $data)
    {
        $organization = $this->find($id);
        $data['updated_by'] = Auth::user()->id ?? 1;
        $organization->update($data);
        return $organization;
    }

    public function delete($id)
    {
        $organization = $this->find($id);
        return $organization->delete(); // soft delete
    }

    public function getActiveOrganizations()
    {
        return Organization::select('id', 'name', 'org_code')
            ->get();
    }

    public function findByOrgCode($orgCode)
    {
        return Organization::where('org_code', $orgCode)->first();
    }

    public function listDataForDataTable()
    {
        try {
            Log::info('OrganizationRepository@listDataForDataTable called');
            
            $data = Organization::with(['operator'])
                ->select('id', 'org_code', 'name', 'address', 'org_type', 'created_at', 'updated_at');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('Y-m-d H:i:s') : '';
                })
                ->editColumn('address', function ($row) {
                    return $row->address ? (strlen($row->address) > 50 ? substr($row->address, 0, 50) . '...' : $row->address) : '';
                })
                ->editColumn('org_type', function ($row) {
                    return ucfirst($row->org_type);
                })
                ->addColumn('operator_username', function ($row) {
                    return $row->operator ? $row->operator->username : 'N/A';
                })
                ->addColumn('actions', function ($row) {
                    $actions = '<div class="btn-group" role="group">';
                    $actions .= '<button type="button" class="btn btn-warning btn-sm" onclick="organization_edit(' . $row->id . ')"><i class="fa fa-edit"></i> Edit</button>';
                    $actions .= '<button type="button" class="btn btn-danger btn-sm" onclick="organization_delete(' . $row->id . ')"><i class="fa fa-trash"></i> Delete</button>';
                    if ($row->operator) {
                        $actions .= '<button type="button" class="btn btn-info btn-sm" onclick="impersonate_login(' . $row->operator->id . ')"><i class="fa fa-user-secret"></i> Impersonate</button>';
                    }
                    $actions .= '</div>';
                    return $actions;
                })
                ->rawColumns(['actions'])
                ->make(true);
        } catch (\Exception $e) {
            Log::error('OrganizationRepository@listDataForDataTable error: ' . $e->getMessage());
            throw $e;
        }
    }

    private function generateUniqueOrgCode()
    {
        do {
            $orgCode = rand(1000, 9999);
        } while (Organization::where('org_code', $orgCode)->exists());
        
        return $orgCode;
    }

    private function createOperatorWithUser($organization)
    {
        // Create operator user following the OperatorController pattern
        $user = User::create([
            'username' => 'operator_' . $organization->org_code,
            'password' => Hash::make('password123'), // Default password
            'org_code' => $organization->org_code,
            'user_type' => 'operator',
            'role_id' => 2, // Assuming 2 is operator role
            'is_special_user' => 1,
            'created_by' => Auth::user()->id ?? 1,
        ]);

        // Create operator record with dummy data
        return Operator::create([
            'org_code' => $organization->org_code,
            'name' => 'Organization Operator',
            'designation' => 'System Operator',
            'date_of_joining' => now()->format('Y-m-d'),
            'mobile_number' => $this->generateUniqueMobileNumber($organization->org_code),
            'address' => 'System Generated Address',
            'user_id' => $user->id,
            'created_by' => Auth::user()->id ?? 1,
        ]);
    }

    private function generateUniqueMobileNumber($orgCode)
    {
        // Generate a unique mobile number based on org_code
        $base = '01700' . str_pad($orgCode, 6, '0', STR_PAD_LEFT);
        
        // If it's too long, take the first 11 digits
        if (strlen($base) > 11) {
            $base = substr($base, 0, 11);
        }
        
        // If it's too short, pad with zeros
        if (strlen($base) < 11) {
            $base = str_pad($base, 11, '0');
        }
        
        // Check if this mobile number already exists
        $counter = 0;
        $mobile = $base;
        while (Operator::where('mobile_number', $mobile)->exists()) {
            $counter++;
            // Modify the last digit(s) to make it unique
            $mobile = substr($base, 0, -1) . ($counter % 10);
        }
        
        return $mobile;
    }
} 