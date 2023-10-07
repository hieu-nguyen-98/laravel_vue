<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\AppointmentRepository;
use App\Models\Appointment;
use App\Enums\AppointmentStatus;
use App\Enums\StatusCode;
use App\Http\Requests\Admin\StoreAppointmentRequest;
use App\Http\Requests\Admin\UpdateAppointmentRequest;

class AppointmentController extends Controller
{
    protected $appointmentRepository;
    public function __construct(AppointmentRepository $appointmentRepository )
    {
        $this->appointmentRepository = $appointmentRepository;
    }
    public function index(){
        // dd($request->all());
        $appointments = $this->appointmentRepository->getAppointments();
        return $appointments;
    }

    public function getStatusWithCount(){

        $appointmentStatus = $this->appointmentRepository->getStatus();
        return $appointmentStatus;
    }

    public function store(StoreAppointmentRequest $request){
        $data = $request->all();
        $data['status'] = AppointmentStatus::SCHEDULED;

        $appointment = $this->appointmentRepository->create($data);
        return response()->json(['message' => 'success']);
    }

    public function edit(Appointment $appointment){
        return $appointment;
    }

    public function update(UpdateAppointmentRequest $request, $id){
        $data = $request->all();
        $appointment = $this->appointmentRepository->update($id, $data);
        return response()->json(['success' => true]);
    }

    public function destroy($id){

        $appointment = $this->appointmentRepository->delete($id);
        if($appointment){
            return response()->json('message','something went wrong!');
        }

        return response()->json(['success' => true], StatusCode::OK);
    }
}
