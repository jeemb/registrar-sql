<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Student.php";
    require_once "src/Course.php";

    $server = 'mysql:host=localhost:8889;dbname=registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class StudentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
            Course::deleteAll();
        }

        function test_save()
        {
            //Arrange
            $name = "Tennyson Wunderbar";
            $date = "2013-12-23";
            $test_student = new Student($name, $date);

            //Act
            $test_student->save();
            $result = Student::getAll();

            //Assert
            $this->assertEquals($test_student, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Tennyson Wunderbar";
            $date = "2013-12-23";
            $test_student = new Student($name, $date);
            $test_student->save();

            $name = "Sandra Handerson";
            $date = "2016-02-12";
            $test_student2 = new Student($name, $date);
            $test_student2->save();

            //Act
            $result = Student::getAll();

            //Assert
            $this->assertEquals([$test_student, $test_student2], $result);
        }

        function test_addCourse()
        {
            //Arrange
            $name = "Tennyson Wunderbar";
            $date = "2013-12-23";
            $test_student = new Student($name, $date);
            $test_student->save();

            $name = "Math 2: the Sequel";
            $number = "MAT200";
            $test_course = new Course($name, $number);
            $test_course->save();

            //Act
            $test_student->addCourse($test_course->getId());
            $result = $test_student->getCourses();

            //Assert
            $this->assertEquals($test_course, $result[0]);
        }

        function test_getCourses()
        {
            //Arrange
            $name = "Tennyson Wunderbar";
            $date = "2013-12-23";
            $test_student = new Student($name, $date);
            $test_student->save();

            $name = "Sandra Handerson";
            $date = "2016-02-12";
            $test_student2 = new Student($name, $date);
            $test_student2->save();

            $name = "Math 2: the Sequel";
            $number = "MAT200";
            $test_course = new Course($name, $number);
            $test_course->save();

            $name = "Physics of School";
            $number = "PHY001";
            $test_course2 = new Course($name, $number);
            $test_course2->save();

            //Act
            $test_student->addCourse($test_course->getId());
            $test_student->addCourse($test_course2->getId());
            $result = $test_student->getCourses();

            //Assert
            $this->assertEquals([$test_course, $test_course2], $result);
        }

        function test_delete()
        {
            //Arrange
            $name = "Tennyson Wunderbar";
            $date = "2013-12-23";
            $test_student = new Student($name, $date);
            $test_student->save();

            $name = "Sandra Handerson";
            $date = "2016-02-12";
            $test_student2 = new Student($name, $date);
            $test_student2->save();

            //Act
            $test_student->delete();
            $result = Student::getAll();

            //Assert
            $this->assertEquals([$test_student2], $result);
        }

        function test_updateName()
        {
            //Arrange
            $name = "Tennyson Wunderbar";
            $date = "2013-12-23";
            $test_student = new Student($name, $date);
            $test_student->save();

            //Act
            $test_student->updateName('Rasmus Lerdorf');
            $result = Student::getAll()[0]->getName();

            //Assert
            $this->assertEquals('Rasmus Lerdorf', $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Tennyson Wunderbar";
            $date = "2013-12-23";
            $test_student = new Student($name, $date);
            $test_student->save();

            $name = "Sandra Handerson";
            $date = "2016-02-12";
            $test_student2 = new Student($name, $date);
            $test_student2->save();

            //Act
            $result = Student::find($test_student2->getId());

            //Assert
            $this->assertEquals($test_student2, $result);
        }
    }

?>
