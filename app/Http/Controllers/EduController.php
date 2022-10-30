<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;

class EduController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('activation');
    }

    public function index()
    {
        $course = Course::all();

        return view('edu.index', compact('course'));
    }

    public function show($id)
    {
        $course = Course::find($id);
        $lessons = Lesson::where('course_id',$id)->get();

        return view('edu.show', compact('course','lessons'));
    }

    public function lesson($id)
    {
        $lesson = Lesson::find($id);
        $course = Course::find($lesson->course_id);
        $lessons = Lesson::where('course_id',$lesson->course_id)->get();

        return view('edu.lesson', compact('course','lessons','lesson'));
    }
}
