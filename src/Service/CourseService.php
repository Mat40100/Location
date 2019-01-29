<?php

namespace App\Service;


use App\Entity\Course;

class CourseService
{
    /**
     * @param Course $course
     * @return bool
     */
    public function checkCustomerNumber(Course $course)
    {
        if (count($course->getCustomers()) < $course->getMaximumCustomerNumber()) {
            return true;
        }

        return false;
    }
}