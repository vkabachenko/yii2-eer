<?php

namespace common\helpers;

use yii\db\Query;


class ResultHelper {

    public static function StudentResults($id)
    {
        // $id - StudentEducation
        $result = new Query();
        $result->
            select(['student_result.*'])->
            from('student_result')->
            innerJoin('student_education',
                'student_education.id = student_result.id_student_education')->
            where(['student_education.id' => $id]);

        $disciplineSemester = new Query();
        $disciplineSemester->
            select(['discipline_semester.*',
                'student_education.id as id_student'])->
            from('discipline_semester')->
            innerJoin('student_education',
                'discipline_semester.course = student_education.course')->
            where(['student_education.id' => $id]);


        $query = new Query();
        $query->
            select(["concat([[discipline.code_first]],'.',[[discipline.code_last]]) as code",
                'cast([[discipline.code_last]] as decimal(10,3)) as code_last_num',
                'semester.id_student',
                'semester.semester',
                'semester.id_discipline',
                'semester.max_rating',
                'semester.id as id_semester',
                'result.assesment',
                'result.rating',
                'result.id as id_result',
            ])->
            from(['semester' => $disciplineSemester])->
            innerJoin('discipline','semester.id_discipline = discipline.id' )->
            leftJoin(['result' => $result],
                'semester.id = result.id_discipline_semester')->
            orderBy('semester.semester, discipline.code_first,code_last_num');

        return $query;

    }

    public static function DisciplineResults($id)
    {
        // $id - DisciplineSemester
        $discipline_studied = new Query();
        $discipline_studied->
            select([
                'discipline.*',
                'discipline_semester.course',
                'discipline_semester.semester',
                'discipline_semester.id as id_semester'
                ])->
            from('discipline')->
            innerJoin('discipline_semester',
                'discipline_semester.id_discipline = discipline.id')->
            where(['discipline_semester.id' => $id]);

        $studentCurrent = new Query();
        $studentCurrent->
            select([
                'student_education.*',
                'student.name',
                'discipline.id_semester',
            ])->
            from('student_education')->
            innerJoin('student','student_education.id_student = student.id')->
            innerJoin(['discipline' => $discipline_studied],
                'discipline.id_program = student_education.id_program and
                student_education.course = discipline.course')->
            where([
                'student_education.year' => YearHelper::getYear(),
            ]);

        $result = new Query();
        $result->
            select(['student_result.*','discipline_semester.max_rating'])->
            from('student_result')->
            innerJoin('student_education',
                'student_education.id = student_result.id_student_education')->
            innerJoin('discipline_semester',
                'discipline_semester.id = student_result.id_discipline_semester')->
            where(['discipline_semester.id' => $id]);

        $query = new Query();
        $query->
            select([
                'student.name',
                'student.id as id_student',
                'student.id_semester',
                'result.assesment',
                'result.rating',
                'result.max_rating',
                'result.id as id_result',
            ])->
            from(['student' => $studentCurrent])->
            leftJoin(['result' => $result],'student.id = result.id_student_education')->
            orderBy('student.name');

        return $query;

    }

} 