<?php

namespace App\Admin\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class LessonController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Lesson';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $YOUR_DOMAIN = env('APP_URL');

        $grid = new Grid(new Lesson());

        $grid->column('id', __('Id'));
        $grid->column('course_id', __('Course id'));
        $grid->column('name', __('Name'));
        $grid->column('thumbnail', __('Thumbnail'))->image($YOUR_DOMAIN . 'uploads/', 50, 50);
        $grid->column('description', __('Description'));
        //      $grid->column('video', __('Video'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Lesson::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('name', __('Name'));
        $show->field('course_id', __('Course name'));
        $show->field('thumbnail', __('Thumbnail'));
        $show->field('description', __('Description'));
        $show->field('video', __('Video'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Lesson());

        $result = Course::pluck('name', 'id');
        $form->text('name', __('Name'));
        //      dd($result);
        $form->select('course_id', __('courses'))->options($result);

        //     $form->number('course_id', __('Course id'));
        $form->image('thumbnail', __('Thumbnail'))->uniqueName();
        $form->textarea('description', __('Description'));
        //    $form->text('video', __('Video'));

        if($form->isEditing()){

            //access this during form eddting
          //   dump($form->video);

                $form->table('video', 'video',function ($form) {
                $form->text('name');
                $form->hidden('old_url');
                $form->hidden('old_thumbnail');
                $form->image('thumbnail')->uniqueName();

                //any kind of media
                //$result[$key]['url'] = env('APP_URL')."uploads/".$value['url'];
           //     $form->file($fullurl);
                $form->file('url');
            });
            
        }else{
            
            //normal form submission or form creating
            
            $form->table('video','video', function ($form) {
     
                $form->text('name')->rules('required');
                $form->image('thumbnail')->uniqueName()->rules('required');
                //any kind of media
                $form->file('url')->rules('required');
            });
        }
        $form->display('created_at', __('Created at'));
        $form->display('updated_at', __('Updated at'));
        return $form;
    }
}
