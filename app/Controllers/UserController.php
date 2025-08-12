<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController {
    protected UserModel $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    /**
     * 회원가입 처리
     *
     * @param string $userName  사용자 이름
     * @param string $email     이메일 주소
     * @param string $password  비밀번호
     * @param string $bio       자기소개 글
     * @return bool             저장 성공 여부
     */
    public function register() {
        $data = $this->getBody();

        $validationRules = [
            'user_name' => 'required|min_length[2]|max_length[50]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
        ];

        $validationMessages = [
            'user_name' => [
                'required' => '사용자 이름을 입력해주세요.',
                'min_length' => '이름은 최소 2자 이상이어야 합니다.',
                'max_length' => '이름은 최대 50자까지 가능합니다.',
            ],
            'email' => [
                'required' => '이메일을 입력해주세요.',
                'valid_email' => '올바른 이메일 주소를 입력해주세요.',
                'is_unique' => '이미 사용 중인 이메일입니다.',
            ],
            'password' => [
                'required' => '비밀번호를 입력해주세요.',
                'min_length' => '비밀번호는 최소 8자 이상이어야 합니다.',
            ],
        ];

        // 서버 검증
        if (!$this->validate($validationRules, $validationMessages, $data)) {
            return $this->response
                ->setJSON([
                    'status' => 'error',
                    'errors' => $this->validator->getErrors(),
                ])
                ->setStatusCode(400);
        }

        if ($this->userModel->save($data)) {
            return $this->response
                ->setJSON([
                    'status' => 'success',
                    'message' => '회원가입이 완료되었습니다.',
                ])
                ->setStatusCode(201);
        }

        return $this->response
            ->setJSON([
                'status' => 'error',
                'message' => '회원가입 중 오류가 발생했습니다.',
            ])
            ->setStatusCode(500);
    }

    /**
     * 회원 목록 조회
     *
     * @return \CodeIgniter\HTTP\Response
     */
    public function getUserList() {
        $users = $this->userModel->getUserList();

        return $this->response
            ->setJSON([
                'status' => 'success',
                'data' => $users,
            ])
            ->setStatusCode(200);
    }

    /**
     * 회원 상세 조회
     *
     * @return \CodeIgniter\HTTP\Response
     */
    function getUser($id = null) {
        $user = $this->userModel->getUserByID($id);

        return $this->response
            ->setJSON([
                'status' => 'success',
                'data' => $user,
            ])
            ->setStatusCode(200);
    }
}
