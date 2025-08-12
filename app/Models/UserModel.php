<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    // 회원 입력으로 받는 필드만 허용 (보안)
    protected $allowedFields = ['user_name', 'email', 'password', 'bio'];

    // 타임스탬프/소프트삭제 컬럼
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // 저장 전 비밀번호 해시
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data) {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    function __construct() {
        $this->db = \Config\Database::connect();
    }

    public function getUserList() {
        return $this->db
            ->table($this->table)
            ->select('id, email, user_name, bio, login_count, last_login_at, created_at, updated_at')
            ->get()
            ->getResultArray(); // 명시적으로 배열 반환
    }

    function getUserByID(int $id = null) {
        $builder = $this->db->table('users');

        $builder->select('id, email, user_name, bio, login_count, last_login_at, created_at, updated_at');
        $builder->where('id', $id);
        return $builder->get()->getRowObject();
    }
}
