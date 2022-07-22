<?php


class StudentController
{
    // I need a property to store the json file name.
    private $json_underG_file = '';
    private $json_postG_file = '';

    // I will need a property to retrieve all stored_students form the file.
    private $stored_underG_data;
    private $stored_postG_data;

    // Next i need a property to tell me how many users are stored in the file.
    private $number_of_underG_records;
    private $number_of_postG_records;

    // Also i need an array to hold all student ids.
    // I will use this property to autoincrement the student id.
    private $underIds = [];
    private $postIds = [];

    // And last i need an array that holds all usernames.
    // With this property i will validate the username.
    private $underUsernames = [];
    private $postUsernames = [];

    public function __construct($file_path)
    {
        // I will store the filepath in the $json_U/P_file property.
        $this->json_underG_file = $file_path;
        $this->json_postG_file = $file_path;

        // Next i will get the data from the JSON file and store them in
        // the $stored_U/P_data property.
        $this->stored_underG_data = json_decode(file_get_contents($this->json_underG_file), true);
        $this->stored_postG_data = json_decode(file_get_contents($this->json_postG_file), true);

        $this->number_of_underG_records = count($this->stored_underG_data);
        $this->number_of_postG_records = count($this->stored_postG_data);

        // Next i will set the $u/pIds, and $u/pUsernames properties.

        // First i will check the number_of_U/P_records property
        // to see if there are any records in the file.
        if ($this->number_of_underG_records != 0) {
            // If there are records in the file, i will loop through
            // the $stored_underG_data property ..
            foreach ($this->stored_underG_data as $student) {
                // and add all student ids, in the $underIds array property.
                array_push($this->underIds, $student['id']);

                // also i will add all usernames in the $underUsernames property.
                array_push($this->underUsernames, $student['FirstName']);
            }
        }

        if ($this->number_of_postG_records != 0) {
            // If there are records in the file, i will loop through
            // the $stored_postG_data property ..
            foreach ($this->stored_postG_data as $student) {
                // and add all student ids, in the $postIds array property.
                array_push($this->postIds, $student['id']);

                // also i will add all usernames in the $postUsernames property.
                array_push($this->postUsernames, $student['FirstName']);
            }
        }
    }

    #region FOR UNDERGRADUATE STUDENTS
    public function getUnderRows()
    {
        if (file_exists($this->json_underG_file))
        {
            if (!empty($this->stored_underG_data))
            {
                usort($this->stored_underG_data, function ($a, $b) {
                    return strtotime($b['id']) - strtotime($a['id']);
                });
            }
            return !empty($this->stored_underG_data) ? $this->stored_underG_data : false;
        }
        return false;
    }

    public function getUnderSingle($id)
    {
        $singleData = array_filter($this->stored_underG_data, function ($var) use ($id)
        {
            return (!empty($var['id']) && $var['id'] == $id);
        });

        $singleData = array_values($singleData)[0];

        return !empty($singleData) ? $singleData : false;
    }

    public function searchUnderSingle($id)
    {
        $searchData = array_filter($this->stored_underG_data, function ($var) use ($id)
        {
            return (!empty($var['id']) && $var['id'] == $id);
        });

        return !empty($searchData) ? $searchData : false;
    }

    // I am going to need a method which will store the new data,
    // or the edited data,back to the file.
    private function storeUnderData($data)
    {
        file_put_contents($this->json_underG_file,
            json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            LOCK_EX);
    }

    // I will write a method to create and increment the id field.
    private function setUnderStudentId($student)
    {
        if ($this->number_of_underG_records == 0) {
            $student['id'] = 1;
        } else {
            $student['id'] = max($this->underIds) + 1;
        }

        return $student;
    }

    public function insertUnder($newStudent)
    {
        if (!empty($newStudent))
        {
            array_push($this->stored_underG_data, $this->setUnderStudentId($newStudent));

            if ($this->number_of_underG_records == 0)
            {
                $insert = $this->storeUnderData($this->stored_underG_data);
            }
            else {
                // i will first check if the username is not included in the
                // $underUsernames array property ...
                if (!in_array($newStudent['FirstName'], $this->underUsernames))
                {   //..and then i store the student in the file.
                    $insert = $this->storeUnderData($this->stored_underG_data);
                }
            }

            return $insert ? $newStudent['id'] : false;
        }
        return false;
    }

    public function updateUnder($upData, $id)
    {
        if (!empty($upData) && is_array($upData) && !empty($id))
        {
            foreach ($this->stored_underG_data as $key => $value)
            {
                if ($value['id'] == $id)
                {
                    if (isset($upData['FirstName'])) {
                        $this->stored_underG_data[$key]['FirstName'] = $upData['FirstName'];
                    }
                    if (isset($upData['MiddleName'])) {
                        $this->stored_underG_data[$key]['MiddleName'] = $upData['MiddleName'];
                    }
                    if (isset($upData['LastName'])) {
                        $this->stored_underG_data[$key]['LastName'] = $upData['LastName'];
                    }
                    if (isset($upData['Gender'])) {
                        $this->stored_underG_data[$key]['Gender'] = $upData['Gender'];
                    }
                    if (isset($upData['Nationality'])) {
                        $this->stored_underG_data[$key]['Nationality'] = $upData['Nationality'];
                    }
                    if (isset($upData['Faculty'])) {
                        $this->stored_underG_data[$key]['Faculty'] = $upData['Faculty'];
                    }
                    if (isset($upData['AdmissionYear'])) {
                        $this->stored_underG_data[$key]['AdmissionYear'] = $upData['AdmissionYear'];
                    }
                    if (isset($upData['ResidentialHall'])) {
                        $this->stored_underG_data[$key]['ResidentialHall'] = $upData['ResidentialHall'];
                    }
                }
            }
            $update = $this->storeUnderData($this->stored_underG_data);

            return $update ? true : false;
        }
        return false;
    }

    public function deleteUnder($id)
    {
        $newData = array_filter($this->stored_underG_data, function ($var) use ($id) {
            return ($var['id'] != $id);
        });

        $delete = $this->storeUnderData($newData);

        return $delete ? true : false;
    }
    #endregion

    #region FOR POSTGRADUATE STUDENTS
    public function getPostRows()
    {
        if (file_exists($this->json_postG_file))
        {
            if (!empty($this->stored_postG_data))
            {
                usort($this->stored_postG_data, function ($a, $b) {
                    return strtotime($b['id']) - strtotime($a['id']);
                });
            }
            return !empty($this->stored_postG_data) ? $this->stored_postG_data : false;
        }
        return false;
    }

    public function getPostSingle($id)
    {
        $singleData = array_filter($this->stored_postG_data, function ($var) use ($id)
        {
            return (!empty($var['id']) && $var['id'] == $id);
        });

        $singleData = array_values($singleData)[0];

        return !empty($singleData) ? $singleData : false;
    }

    public function searchPostSingle($id)
    {
        $searchData = array_filter($this->stored_postG_data, function ($var) use ($id)
        {
            return (!empty($var['id']) && $var['id'] == $id);
        });

        return !empty($searchData) ? $searchData : false;
    }

    // I am going to need a method which will store the new data,
    // or the edited data, back to the file.
    private function storePostData($data)
    {
        file_put_contents($this->json_postG_file,
            json_encode($data,JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            LOCK_EX);
    }

    // I will write a method to create and increment the id field.
    private function setPostStudentId($student)
    {
        if ($this->number_of_postG_records == 0) {
            $student['id'] = 1;
        } else {
            $student['id'] = max($this->postIds) + 1;
        }

        return $student;
    }

    public function insertPost($newStudent)
    {
        if (!empty($newStudent))
        {
            array_push($this->stored_postG_data, $this->setPostStudentId($newStudent));

            if ($this->number_of_postG_records == 0)
            {
                $insert = $this->storePostData($this->stored_postG_data);
            }
            else {
                // i will first check if the username is not included in the
                // $postUsernames array property ...
                if (!in_array($newStudent['FirstName'], $this->postUsernames))
                {   //..and then i store the student in the file.
                    $insert = $this->storePostData($this->stored_postG_data);
                }
            }

            return $insert ? $newStudent['id'] : false;
        }
        return false;
    }

    public function updatePost($upData, $id)
    {
        if (!empty($upData) && is_array($upData) && !empty($id))
        {
            foreach ($this->stored_postG_data as $key => $value)
            {
                if ($value['id'] == $id)
                {
                    if (isset($upData['FirstName'])) {
                        $this->stored_postG_data[$key]['FirstName'] = $upData['FirstName'];
                    }
                    if (isset($upData['MiddleName'])) {
                        $this->stored_postG_data[$key]['MiddleName'] = $upData['MiddleName'];
                    }
                    if (isset($upData['LastName'])) {
                        $this->stored_postG_data[$key]['LastName'] = $upData['LastName'];
                    }
                    if (isset($upData['Gender'])) {
                        $this->stored_postG_data[$key]['Gender'] = $upData['Gender'];
                    }
                    if (isset($upData['Nationality'])) {
                        $this->stored_postG_data[$key]['Nationality'] = $upData['Nationality'];
                    }
                    if (isset($upData['Faculty'])) {
                        $this->stored_postG_data[$key]['Faculty'] = $upData['Faculty'];
                    }
                    if (isset($upData['AdmissionYear'])) {
                        $this->stored_postG_data[$key]['AdmissionYear'] = $upData['AdmissionYear'];
                    }
                    if (isset($upData['SupervisorName'])) {
                        $this->stored_postG_data[$key]['SupervisorName'] = $upData['SupervisorName'];
                    }
                    if (isset($upData['ResearchTopic'])) {
                        $this->stored_postG_data[$key]['ResearchTopic'] = $upData['ResearchTopic'];
                    }
                }
            }
            $update = $this->storePostData($this->stored_postG_data);

            return $update ? true : false;
        }
        return false;
    }

    public function deletePost($id)
    {
        $newData = array_filter($this->stored_postG_data, function ($var) use ($id) {
            return ($var['id'] != $id);
        });

        $delete = $this->storePostData($newData);

        return $delete ? true : false;
    }
    #endregion
}