<?php

namespace App\Repositories;
use App\Repositories\Interface\ContactRepositoryInterface as ContactRepositoryInterface;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Collection;
class ContactRepository implements ContactRepositoryInterface
{
    
	
	public function getAll() : Collection
	{
		return Contact::all();
	}
	public function getById(int $id): ?Contact
	{
		return Contact::find($id);
	}
	
	public function create(array $data): Contact
	{
		return Contact::create($data);
	}
	
	public function update(int $id ,array $data) : bool
	{
		$contact = $this->getById((int) $id);
		if(!$contact)
        {
			return false;
		}
        return $contact->update($data);		
	}
	
	public function delete (int $id) : bool
    {
		$contact = $this->getById((int) $id);
		if(!$contact)
		{
			return $false;
		}	
		return $contact->delete();	
	}

    public function xmlDataInsert(Collection $contact): void
	{
		 Contact::insert($contact->toArray());
	}
    	
}
