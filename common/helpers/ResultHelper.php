<?php

namespace common\helpers;

use yii\db\Query;
use common\models\StudentResult;
use common\models\StudentEducation;


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

    /*
     * Экзаменационная ведомость с теми же характеристиками, что и в таблице
     * student_result c id = id_result
     */

    public static function examList($id_result)
    {

        $currentResult = StudentResult::findOne($id_result);
        $currentStudent = StudentEducation::findOne($currentResult->id_student_education);

        $results = StudentResult::find()->
            innerJoinWith([
                'idStudentEducation' => function($query) use ($currentStudent) {
                        $query->joinWith([
                            'idStudent' => function($query2) {
                                    $query2->orderBy('name');
                                }
                        ])->
                            where([
                                'year' => $currentStudent->year,
                                'group' => $currentStudent->group
                            ]);
                    }
            ])->
            where([
                'id_discipline_semester' => $currentResult->id_discipline_semester,
                'examiner' => $currentResult->examiner,
                'passing_date' => StudentResult::convertDate(
                        $currentResult->passing_date),
            ])->
            all();

        return $results;
    }

    /*
     * Новая экзаменационная ведомость для студента id_student и
     * дисциплины id_semester
     */

    public static function newExamList($id_student, $id_semester)
    {

        $currentStudent = StudentEducation::findOne($id_student);

        $studentResults = StudentResult::find()->
                innerJoinWith([
                    'idStudentEducation' => function($query) use ($currentStudent) {
                            $query->where([
                                'year' => $currentStudent->year,
                                'group' => $currentStudent->group
                            ]);
                        }
                ])->
                where(['id_discipline_semester' => $id_semester])->
                select('id_student');

        $students = StudentEducation::find()->
                joinWith([
                    'idStudent' => function($query) {
                            $query->orderBy('name');
                        }
                ])->
                where([
                    'year' => $currentStudent->year,
                    'id_program' => $currentStudent->id_program,
                    'course' => $currentStudent->course,
                    'group' => $currentStudent->group
                ])->
                andWhere(['not in','id_student',$studentResults])->
                all();

        $results = [];
        foreach ($students as $student) {
                $result = new StudentResult();
                $result->id_student_education = $student->id;
                $result->id_discipline_semester = $id_semester;
                $results[] = $result;
        }

        return $results;
    }


} 