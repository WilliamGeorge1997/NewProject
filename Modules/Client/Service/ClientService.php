<?php


namespace Modules\Client\Service;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Modules\Client\Entities\BalanceTransaction;
use Modules\Client\Entities\Client;
use Modules\Common\Helper\UploaderHelper;

class ClientService
{
    use UploaderHelper;
    function findAll(){
        return Client::available()->paginate(1);
    }

    function findById($id){
        return Client::find($id);
    }

    function active()
    {
        return Client::available()->active()->get();
    }

    function findBy($key, $value)
    {
        return Client::where($key, $value)->get();
    }

    function findToken($id)
    {
        return Client::where('id',$id)->where('allow_notification',1)->first()['fcm_token'];
    }

    function save($data){
        if (request()->hasFile('image')){
            $image = request()->file('image');
            $imageName = $this->upload($image, 'Client');
            $data['image'] = $imageName;
        }
        return Client::create($data);
    }

    function update($id,$data){
        $Client = $this->findById($id);
        if (request()->hasFile('image')){
            File::delete(public_path('uploads/Client/'.$this->getImageName('Client',$Client->image)));
            $image = request()->file('image');
            $imageName = $this->upload($image, 'Client');
            $data['image'] = $imageName;
        }
        if ($data['balance'] ?? null) {
            $data['balance'] = $data['balance'] + $Client->balance;
            BalanceTransaction::create([
                'to_client' => $id,
                'amount' => $data['balance'],
                'to_client_balance_before' => $Client->balance,
                'to_client_balance_after' => $data['balance']
            ]);
        }
        $Client->update($data);
        return $Client;
    }

    function activate($id){
        $Client = $this->findById($id);
        $Client->is_active = !$Client->is_active;
        $Client->save();
    }
    function delete($id)
    {
        $Client = $this->findById($id);
        File::delete(public_path('uploads/Client/'.$this->getImageName('Client',$Client->image)));
        $Client->delete();
    }

    function changeLang($id){
        $Client = $this->findById($id);
        $lang = $Client->lang == 'en' ? 'ar' :'en';
        $Client->update(['lang'=>$lang]);
        return $Client;
    }
    function activeFcm()
    {
        return Client::available()->whereNotNull('fcm_token')->active()->get();
    }

}
