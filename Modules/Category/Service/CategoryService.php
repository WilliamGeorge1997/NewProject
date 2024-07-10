<?php


namespace Modules\Category\Service;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Category\Entities\Category;
use Modules\Common\Helper\UploaderHelper;
use Modules\Product\Service\ProductService;

class CategoryService
{
    use UploaderHelper;
    function findAll($relation=[]){
        return Category::with($relation)->paginate(50);

    }

    function active(){
        return Category::active()->get();
    }



    function findById($id){
        return Category::findOrFail($id);
    }

    function findBy($key, $value,$relation=[])
    {
        return Category::query()->where($key, $value)->with($relation)->get();
    }



    function save($data){
        if (request()->hasFile('image')){
            $image = request()->file('image');
            $imageName = $this->upload($image, 'category');
            $data['image'] = $imageName;
        }
        $category =  Category::create($data);
        return $category;

    }

    function update($id,$data){
        $Category = $this->findById($id);
        if (request()->hasFile('image')){
            File::delete(public_path('uploads/category/'.$this->getImageName('category',$Category->image)));
            $image = request()->file('image');
            $imageName = $this->upload($image, 'category');
            $data['image'] = $imageName;
        }

        $Category->update($data);
        return $Category;
    }

    function activate($id){
        $Category = $this->findById($id);
        $Category->is_active = !$Category->is_active;
        $Category->save();
    }
    function delete($id)
    {
        $Category = $this->findById($id);
        File::delete(public_path('uploads/category/'.$this->getImageName('category',$Category->image)));
        $Category->delete();
    }

}
