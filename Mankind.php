<?php

class Human
{
    private $firstName;

    private $lastName;

    public function __construct($firstName, $lastName)
    {
        $this->setFirstName($firstName);
        $this->setLastName($lastName);
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        if (! $this->checkIsUpper($firstName[0])) {
            throw new Exception("Expected upper case letter!Argument: firstName");
        }

        if (strlen($firstName) < 4) {
            throw new Exception("Expected length at least 4 symbols!Argument: firstName");
        }

        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        if (! $this->checkIsUpper($lastName[0])) {
            throw new Exception("Expected upper case letter!Argument: lastName");
        }

        if (strlen($lastName) < 3) {
            throw new Exception("Expected length at least 3 symbols!Argument: lastName ");
        }

        $this->lastName = $lastName;
    }

    private function checkIsUpper($char)
    {
        return $char === strtoupper($char);
    }
}

class Student extends Human
{
    private $facultyNumber;

    public function __construct($firstName, $lastName, $facultyNumber)
    {
        parent::__construct($firstName, $lastName);
        $this->setFacultyNumber($facultyNumber);
    }

    public function getFacultyNumber()
    {
        return $this->facultyNumber;
    }

    public function setFacultyNumber($facultyNumber)
    {
        if (strlen($facultyNumber) < 5 || strlen($facultyNumber) > 10) {
            throw new Exception("Invalid faculty number!");
        }
        $this->facultyNumber = $facultyNumber;
    }
}

class Worker extends Human
{
    private $weekSalary;

    private $workHoursPerDay;

    public function __construct($firstName, $lastName, $weekSalary, $workHoursPerDay)
    {
        parent::__construct($firstName, $lastName);
        $this->setWeekSalary($weekSalary);
        $this->setWorkHoursPerDay($workHoursPerDay);
    }

    public function getWeekSalary()
    {
        return (float) $this->weekSalary;
    }

    public function setWeekSalary($weekSalary)
    {
        if ($weekSalary <= 10) {
            throw new Exception("Expected value mismatch!Argument: weekSalary");
        }
        $this->weekSalary = $weekSalary;
    }

    public function getWorkHoursPerDay()
    {
        return (float)$this->workHoursPerDay;
    }

    public function setWorkHoursPerDay($workHoursPerDay)
    {
        if ($workHoursPerDay < 1 || $workHoursPerDay > 12) {
            throw new Exception("Expected value mismatch!Argument: workHoursPerDay");
        }
        $this->workHoursPerDay = $workHoursPerDay;
    }

    public function setLastName($lastName)
    {
        if (strlen($lastName) <= 3) {
            throw new Exception("Expected length more than 3 symbols!Argument: lastName");
        }
        parent::setLastName($lastName);
    }

    public function getSalaryPerHour()
    {
        return number_format($this->getWeekSalary() / (7 * $this->getWorkHoursPerDay()), 2);
    }
}


$studentInput = trim(fgets(STDIN));
$workerInput = trim(fgets(STDIN));

$studentArray = explode(' ', $studentInput);
$workerArray = explode(' ', $workerInput);

$studentFirstName = $studentArray[0];
$studentLastName = $studentArray[1];
$studentFacultyNumber = $studentArray[2];

$workerFirstName = $workerArray[0];
$workerWastName = $workerArray[1];
$workerWeakSalary = $workerArray[2];
$workerHoursPerDay = $workerArray[3];


try {
    $student = new Student($studentFirstName, $studentLastName, $studentFacultyNumber);
    $worker = new Worker($workerFirstName, $workerWastName, $workerWeakSalary, $workerHoursPerDay);

    echo 'First Name: ' . $student->getFirstName() . PHP_EOL;
    echo 'Last Name: ' . $student->getLastName(). PHP_EOL;
    echo 'Faculty number: ' . $student->getFacultyNumber() . PHP_EOL;
    echo PHP_EOL;
    echo 'First Name: ' . $worker->getFirstName() . PHP_EOL;
    echo 'Last Name: ' . $worker->getLastName() . PHP_EOL;
    echo 'Week Salary: ' . number_format($worker->getWeekSalary(), 2, '.', '') . PHP_EOL;
    echo 'Hours per day: ' . number_format($worker->getWorkHoursPerDay(), 2) . PHP_EOL;
    echo 'Salary per hour: ' . $worker->getSalaryPerHour();
} catch (Exception $e) {
    echo $e->getMessage();
}
?>