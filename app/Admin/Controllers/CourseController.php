<?php

namespace App\Admin\Controllers;

use App\Models\CourseType;
use App\Models\Course;
use App\Models\User;

use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Tree;
use Encore\Admin\Layout\Content;

// create command
// php artisan admin:make CourseController --model=App\\Models\\Course
class CourseController extends AdminController
{

    protected function grid()
    {
        $grid = new Grid(new Course());

        $grid->column('id', __('Id'));
        $grid->column('user_token', __('Teachers'))->display(
            function ($token) {
                //value function returns a specific field from the match
                return User::where('token', '=', $token)->value('name');
            }
        );
        $grid->column('name', __('Name'));
        $grid->column('thumbnail', __('Thumbnail'))->image('', 50, 50);
        $grid->column('description', __('Description'));
        $grid->column('type_id', __('Type id'));
        $grid->column('price', __('Price'));
        $grid->column('lesson_num', __('Lesson num'));
        $grid->column('video_length', __('Video length'));
        $grid->column('downloadable_res', __('Resources num'));
        $grid->column('created_at', __('Created at'));


        return $grid;
    }
    protected function detail($id)
    {
        $show = new Show(Course::findOrFail($id));

        $show->field('id', __('Id'));
        //    $show->field('title', __('Category'));
        $show->field('description', __('Description'));
        $show->field('order', __('Order'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        $show->disableActions();
        $show->disableCreateButton();
        $show->disableExport();
        $show->disableFilter();
        return $show;
    }


    protected function form()
    {
        $form = new Form(new Course());
        $form->text('name', __('Name'));

        // get our categories
        //key value pair
        // last one is the key
        $result = CourseType::pluck('title', 'id');
        //select method helps you to select one of the options that comes from result
        $form->select('type_id', __('Category'))->options($result);

        $form->image('thumbnail', __('Thumbnail'))->uniqueName();
        //file is used for video and other formats like pdf/doc
        $form->file('video', __('Video'))->uniqueName();
        //   $form->text('title', __('Title'));
        $form->text('description', __('Description'));
        //decimal method helps with retrieving float format from the database
        $form->decimal('price', __('Price'));
        $form->number('lesson_num', __('Lesson number'));
        $form->number('video_length', __('Video length'));
        $form->number('downloadable_res', __('Resources num'));
        //for the posting, who is posting
        $result = User::pluck('name', 'token');
        $form->select('user_token', __('Teacher'))->options($result);
        $form->display('created_at', __('Created at'));
        $form->display('updated_at', __('Updated at'));
        return $form;
    }
}
