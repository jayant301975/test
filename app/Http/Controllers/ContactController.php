<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ContactServices;
use  App\Http\Requests\XmlFileRequest;
use  App\Http\Requests\AddContactRequest;
use  App\Http\Requests\UpdateContactRequest;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables as DataTables;
class ContactController extends Controller
{
     
	 protected $contactservice;
	 
	 public function __construct(ContactServices $contactservice)
	 {
		 $this->contactservice=$contactservice;
	 }
	 
	 
	 
	 
	 public function index(Request $request)
	 {
		 if ($request->ajax()) {

            $data =$this->contactservice->getAllContract();

           return Datatables::of($data)
				->addIndexColumn()
				->addColumn('action', function($row){
					$actionBtn = '<a href="javascript:void(0)" data-id="'.$row->id.'" class="edit btn btn-success btn-sm bs-upload-edit">Edit</a>
								  <a href="javascript:void(0)" data-id="'.$row->id.'" class="delete btn btn-danger btn-sm">Delete</a>';
					return $actionBtn;
				})
				->rawColumns(['action'])
				->make(true);

        }
		 
		 
		 
		 return view("Welcome");
	 }
	 
	 public function uploadXmlFile(XmlFileRequest $request)
	 {
	   try
	   {
	   $filePath = $request->file('file')->storeAs('uploads');
	    $fullPath = storage_path('app/uploads/' . $filePath); 
        $message = $this->contactservice->xmlDataInsertBulk($fullPath);
        return response()->json([
            'status' => 'success',
            'message' => 'Contact import successfully!'
        ], 200);
	   }
	   catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to import the contact. ' . $e->getMessage()
        ], 500);
    }
	 }
	 
	 public function uploadData($id)
	 {
		 $contact=$this->contactservice->getAllContractById($id);
		 if (!$contact) {
            return response()->json(['success' => false, 'message' => 'Contact not found']);
        }

        return response()->json(['success' => true, 'data' => $contact]);
	 }
	 
	 public function updateContact(UpdateContactRequest $request,$id)
	 {
		
		 
    try 
	{
        
        $contactId = (int) $id;

        
        $this->contactservice->updateContact($contactId, $request->all());

       
        return response()->json([
            'status' => 'success',
            'message' => 'Contact updated successfully!'
        ], 200);
	} 
	catch (\Exception $e) 
	{
		return response()->json([
			'status' => 'error',
			'message' => 'Failed to update contact. ' . $e->getMessage()
		], 500);
	}
		 
		 
		 
	 }
	 
	  public function destroy($id)
	  {
		  try
		  {
			$this->contactservice->deleteContact((int)$id);
		   return response()->json([
				'status' => 'success',
				'message' => 'Contact deleted successfully!'
			], 200);			
		  }
		  catch (\Exception $e) 
		{
			return response()->json([
				'status' => 'error',
				'message' => 'Failed to delete contact. ' . $e->getMessage()
			], 500);
		}
	  }
	  
	  public function addContact(AddContactRequest $request)
	  {
		  try 
			{
				
				$this->contactservice->createContact($request->all());

			   
				return response()->json([
					'status' => 'success',
					'message' => 'Contact added successfully!'
				], 200);
			} 
			catch (\Exception $e) 
			{
				return response()->json([
					'status' => 'error',
					'message' => 'Failed to add contact. ' . $e->getMessage()
				], 500);
			}
	  }
	 
}
