<?php

namespace App\Http\Controllers\MobileApp;

use App\Models\MobileApp\Lessons;
use App\Models\MobileApp\Course;
use  App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LessonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($course_id)
    {
        $courses =Course::where('id',$course_id)->first();
        return view("lesson.all",compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($course_id)
    {
        return view("lesson.add_lesson",compact('course_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Lessons $lesson)
    {
        $request->validate([
            'preview' => 'required',
        ]);

        if ($request->hasFile('preview')) {
            $tmp_path = date('Y')."/".date('m')."/".date('d')."/".$request->preview->getFilename().'.'.$request->preview->getClientOriginalExtension();
            $path = $request->preview->storeAs('public/images', $tmp_path);
            $request->preview = str_replace("public", "storage", $path);

        }
        $lesson::create([
            'course_id' => $request->course_id,
            'title' => $request->title,
            'video' => $request->video,
            'preview'=> $request->preview,

        ]);
        $course = Course::where('id',$request->course_id)->first();
        $course->lessons_quantity = intval($course->lessons_quantity)+1;
        $course->save();
        return redirect('/'.$request->course_id.'/lessons');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lessons  $lessons
     * @return \Illuminate\Http\Response
     */
    public function show(Lessons $lessons)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($course_id,$id)
    {
        $lesson=Lessons::where('id',$id)->first();
        return view("lesson.edit_lesson",compact('lesson','course_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$course_id,$id)
    {

        if ($request->hasFile('preview')) {
            $tmp_path = date('Y')."/".date('m')."/".date('d')."/".$request->preview->getFilename().'.'.$request->preview->getClientOriginalExtension();
            $path = $request->preview->storeAs('public/images', $tmp_path);
            $request->preview = str_replace("public", "storage", $path);

        }

        $array=[
            'course_id' => $request->course_id,
            'title' => $request->title,
            'video' => $request->video,
            'preview'=> $request->preview,
        ];

        $lessons = Lessons::where('id',$id)->first();
        $lessons->update($array);
        return redirect('/'.$course_id.'/lessons');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lessons  $lessons
     * @return \Illuminate\Http\Response
     */
    public function destroy($course_id,$id)
    {
        Lessons::where('id',$id)->delete();
        return redirect()->back();
    }
}
