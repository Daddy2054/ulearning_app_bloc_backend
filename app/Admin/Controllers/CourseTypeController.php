<?php

namespace App\Admin\Controllers;

use App\Models\CourseType;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Tree;
use Encore\Admin\Layout\Content;

class CourseTypeController extends AdminController
{
    public function index(Content $content){
        $tree = new Tree(new CourseType);
        return $content->header('Course Types')->body($tree);
    }

     protected function detail($id)
    {
        $show = new Show( CourseType::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Category'));
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

     //creating and editing
     protected function form()
     {
         $form = new Form(new CourseType());
 
         $form->select('parent_id', __('Parent category'))->options((new CourseType())::selectOptions());
 
         $form->text('title', __('Title')); //text is similar to string in laravel
         $form->textarea('description', __('Description')); //textarea is similar to text
         $form->number('order', __('Order')); //number is similar to int
 
         return $form;
     }
}


// php artisan make:controller ../../Admin/Controllers/CourseTypeController