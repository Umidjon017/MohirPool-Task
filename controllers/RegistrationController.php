<?php


class RegistrationController
{
    private $json_file = '';
    private $stored_data;
    private $number_of_records;
    private $ids;
    private $usernames;

    public function __construct($file_path)
    {
        $this->json_file = $file_path;
        $this->stored_data = json_decode(file_get_contents($this->json_file), true);
        $this->number_of_records = count($this->stored_data);

        if ($this->number_of_records != 0)
        {
            foreach ($this->stored_data as $user) {
                array_push($this->ids, $user['id']);
                array_push($this->usernames, $user['FirstName']);
            }
        }
    }

    public function getRows()
    {
        if (file_exists($this->json_file))
        {
            if (!empty($this->stored_data))
            {
                usort($this->stored_data, function ($a, $b) {
                    return strtotime($b['id']) - strtotime($a['id']);
                });
            }
            return !empty($this->stored_data) ? $this->stored_data : false;
        }
        return false;
    }

    public function getSingle($id)
    {
        $singleData = array_filter($this->stored_data, function ($var) use ($id)
        {
            return (!empty($var['id']) && $var['id'] == $id);
        });

        $singleData = array_values($singleData)[0];

        return !empty($singleData) ? $singleData : false;
    }

//    public function isUserExists($email)
//    {
//        $query = "SELECT email FROM users WHERE email = $email LIMIT 1";
//        $result = $this->connection->query($query);
//
//        if ($result->num_rows > 0)
//        {
//            return true;
//        }
//        else {
//            return false;
//        }
//    }

    public function confirmPassword($password, $c_password)
    {
        if ($password == $c_password)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    private function storeData($data)
    {
        file_put_contents($this->json_file,
            json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            LOCK_EX);
    }

    private function setUserId($user)
    {
        if ($this->number_of_records == 0) {
            $user['id'] = 1;
        } else {
            $user['id'] = max($this->ids) + 1;
        }

        return $user;
    }

    public function insert($newUser)
    {
        if (!empty($newUser))
        {
            array_push($this->stored_data, $this->setUserId($newUser));

            if ($this->number_of_records == 0)
            {
                $insert = $this->storeData($this->stored_data);
            }
            else {
                if (!in_array($newUser['FirstName'], $this->usernames))
                {
                    $insert = $this->storeData($this->stored_data);
                }
            }

            return $insert ? $newUser['id'] : false;
        }
        return false;
    }

    public function update($upData, $id)
    {
        if (!empty($upData) && is_array($upData) && !empty($id))
        {
            foreach ($this->stored_data as $key => $value)
            {
                if ($value['id'] == $id)
                {
                    if (isset($upData['FirstName'])) {
                        $this->stored_data[$key]['FirstName'] = $upData['FirstName'];
                    }
                    if (isset($upData['MiddleName'])) {
                        $this->stored_data[$key]['MiddleName'] = $upData['MiddleName'];
                    }
                    if (isset($upData['LastName'])) {
                        $this->stored_data[$key]['LastName'] = $upData['LastName'];
                    }
                    if (isset($upData['Email'])) {
                        $this->stored_data[$key]['Email'] = $upData['Email'];
                    }
                    if (isset($upData['Password'])) {
                        $this->stored_data[$key]['Password'] = $upData['Password'];
                    }
                }
            }
            $update = $this->storeData($this->stored_data);

            return $update ? true : false;
        }
        return false;
    }

    public function delete($id)
    {
        $newData = array_filter($this->stored_data, function ($var) use ($id) {
            return ($var['id'] != $id);
        });

        $delete = $this->storeData($newData);

        return $delete ? true : false;
    }
}