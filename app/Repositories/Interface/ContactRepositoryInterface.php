<?php

namespace App\Repositories\Interface;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Collection;
interface ContactRepositoryInterface
{
    public function getAll() : Collection;
	public function getById(int $id): ?Contact;
	public function create(array $data): Contact  ;
	public function update(int $id ,array $data) : bool;
	public function delete(int $id): bool;
	public function xmlDataInsert(Collection $contacts): void;
}
