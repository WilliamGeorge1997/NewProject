<?php


namespace Modules\Client\Service;


use Modules\Client\Entities\Address;

class AddressService
{
    function findAll(){
        return Address::all();
    }

    function findById($id){
        return Address::findOrFail($id);
    }

    function findBy($key, $value,$relation=[],$data =[])
    {
        $addresses =  Address::where($key, $value)->with($relation)
            ->when($data['sub_zone_id'] ?? null,function ($query) use ($data){
                $query->where('sub_zone_id',$data['sub_zone_id']);
            });

        return getCaseCollection($addresses,$data);
    }
    function findByMulti($key, $value,$key2, $value2)
    {
        return Address::where($key, $value)->where($key2, $value2)->orderByDesc('default')->get();
    }

    function save($data){
        $address = Address::create($data);
        if($data['default'] ?? null && $data['default'] == 1){
            Address::whereClientId($data['client_id'])->where('id','!=',$address['id'])->update(['default'=>0]);
        }
        return $address;
    }

    function makeDefault($address_id){
        $address = $this->findById($address_id);
        $address->update(['default'=>1]);
        Address::whereClientId($address['client_id'])->where('id','!=',$address_id)->update(['default'=>0]);
        return $address;
    }

    function update($id,$data){
        $address = $this->findById($id);
        if($data['default'] ?? null && $data['default'] == 1){
            Address::whereClientId($address['client_id'])->where('id','!=',$address['id'])->update(['default'=>0]);
        }
        $address->update($data);
        return $address;
    }

    function delete($id)
    {
        $Address = $this->findById($id);
        $Address->delete();
    }

}
