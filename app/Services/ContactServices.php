<?php

namespace App\Services;

use App\Repositories\ContactRepository;
use Illuminate\Database\Eloquent\Collection;

use SimpleXMLElement;
class ContactServices
{
    /**
     * Create a new class instance.
     */
	 protected $contact;
    public function __construct(ContactRepository $contact)
    {
        $this->contact=$contact;
    }
	public function getAllContract()
	{
		return $this->contact->getAll();
	}
	public function getAllContractById($id)
	{
		return $this->contact->getById($id);
	}
	public function createContact(array $data)
	{
		return $this->contact->create($data);
	}
	public function updateContact(int $id, array $data)
	{
		return $this->contact->update((int) $id, $data);
	}
	public function deleteContact(int $id)
	{
		return $this->contact->delete($id);
	}
	
	public function xmlDataInsertBulk(String $fullPath): void
	{ 
		if (!file_exists($fullPath)) 
		{
		throw new \Exception("File not found: $fullPath");
		}
		
		
		$xmlData = file_get_contents($fullPath);
        $xmlDataObject = new SimpleXMLElement($xmlData);
        $contacts = collect();
		foreach ($xmlDataObject->contact as $contact) {
		$contacts->push([
			'name' => (string) $contact->name,
			'country_code' => (string) $contact->country_code,
			'mobile' => (string) $contact->mobile,
			'created_at' => now(),
			'updated_at' => now(),
		]);
		}
		 $contacts = new Collection($contacts->toArray());
		$this->contact->xmlDataInsert($contacts);
	}	
	
	
}
