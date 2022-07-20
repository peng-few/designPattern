<?php
abstract class CustomerForm
{
    protected CustomerInfo $info;
    protected CustomerInfo $paramInfo;

    final public function submit($data)
    {
        $this->setRequiredInfo($data);
        $this->setOtherInfo($data);
        $this->info = $this->changeCustomerData();
        $this->showCustomerData();
    } 
    //unchangable step
    final public function setRequiredInfo(Array $data)
    {
        $this->paramInfo = new CustomerInfo();
        $this->paramInfo->name = $data['name'];
        $this->paramInfo->gender = $data['gender'];
        $this->paramInfo->age = $data['age'];
        $this->paramInfo->phone = $data['phone']??null;
        $this->paramInfo->mail = $data['mail']??null;
    }
    //hook
    public function setOtherInfo($data){}

    abstract public function changeCustomerData():CustomerInfo;
    final public function showCustomerData()
    {
        echo '姓名:'.$this->info->name;
        echo '性別:'.$this->info->gender?'男':'女';
        echo '年齡:'.$this->info->age;
        echo '電話:'.$this->info->phone;
        echo '信箱:'.$this->info->mail;
    }
}
class AddCustomer extends CustomerForm
{
    public function setOtherInfo($data)
    {
        $this->paramInfo->createdTime = date("Y/m/d");
    }
    public function changeCustomerData():CustomerInfo
    {
        //Add new To DB...
        return  $this->paramInfo;
    }
}

class EditCustomer extends CustomerForm
{
    public function setOtherInfo($data)
    {
        $this->paramInfo->id = $data['id'];
        $this->paramInfo->updatedTime = date("Y/m/d");
    }
    public function changeCustomerData():CustomerInfo
    {
        //Edit new To DB...
        return  $this->paramInfo;
    }
}

class CustomerInfo
{
    public $name;
    public $age;
    public $phone;
    public $gender;
    public $mail;
    public $id;
    public $updatedTime;
    public $createdTime;
}

$newCustomer = new AddCustomer();
$newCustomer->submit(['name'=>'王曉明','age'=>18,'gender'=>1]);
$editCustomer = new EditCustomer();
$editCustomer->submit(['name'=>'王曉明','age'=>18,'gender'=>1,'id'=>25]);
?>