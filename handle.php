<?php

error_reporting(0);
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        if ($_GET['action'] == 'encrypt') {
            $ivLength = openssl_cipher_iv_length($_POST['method']);
            $iv = openssl_random_pseudo_bytes($ivLength);
            $data = openssl_encrypt($_POST['data'], $_POST['method'], $_POST['key'], 1, $iv);
            $dataArr = [
                'data' => base64_encode($data),
                'iv' => base64_encode($iv),
            ];
            echo json_encode(['code' => 200, 'msg' => '请求成功', 'data' => $dataArr], JSON_UNESCAPED_UNICODE);
            exit;
        } else {
            $data = json_decode($_POST['data'], true);
            if (is_null($data)) {
                throw new Exception('解密失败');
            }
            $result = openssl_decrypt(base64_decode($data['data']), $_POST['method'], $_POST['key'], 1, base64_decode($data['iv']));
            if ($result === false) {
                throw new Exception('解密失败');
            }
            echo json_encode(['code' => 200, 'msg' => '请求成功', 'data' => $result], JSON_UNESCAPED_UNICODE);
            exit;
        }
    } catch (Exception $e) {
        echo json_encode(['code' => 400, 'msg' => '操作失败', 'data' => null], JSON_UNESCAPED_UNICODE);
        exit;
    }
}
