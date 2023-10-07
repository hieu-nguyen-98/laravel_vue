<?php
namespace App\Repositories;

use App\Models\Appointment;
use App\Enums\TypePaginate;
use App\Enums\AppointmentStatus;
use Illuminate\Http\Request;

class AppointmentRepository implements BaseRepositoryInterface
{
    protected $appointment;

    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    public function all()
    {
        return $this->appointment->paginate();
    }

    public function find($id)
    {
        return $this->appointment->find($id);
    }

    public function create(array $data)
    {
        return $this->appointment->create($data);
    }

    public function update($id, array $data)
    {
        $appointment = $this->appointment->find($id);
        $appointment->update($data);
        return $appointment;
    }

    public function delete($id)
    {
        $appointment = $this->appointment->find($id);
        $appointment->delete();
    }
    
    public function getAppointments(){
        $appointments = $this->appointment->query()
        ->with('client')
        ->when(request('status'), function ($q) {
            $status = request('status');
            if (in_array($status, [AppointmentStatus::SCHEDULED, AppointmentStatus::CONFIRMED, AppointmentStatus::CANCELLED])) {
                return $q->where('status', $status);
            }
        })
        ->latest()
        ->get()
        ->map(fn ($appoinment) => [
            'id' => $appoinment->id,
            'start_time' => $appoinment->start_time->format('Y-m-d h:i A'),
            'end_time' => $appoinment->end_time->format('Y-m-d h:i A'),
            'status' => [
                'name' => $this->getStatusName($appoinment->status->value), // Check the original value in the "status" column
                'color' => $appoinment->status->color(),
            ],
            
            'client' => $appoinment->client,
        ]);

        return $appointments;
    }

    private function getStatusName($status){
        switch ($status) {
            case AppointmentStatus::SCHEDULED:
                return 'SCHEDULED';
            case AppointmentStatus::CONFIRMED:
                return 'CONFIRMED';
            case AppointmentStatus::CANCELLED:
                return 'CANCELLED';
            default:
                return 'Unknown';
        }
    }

    public function getStatus(){

        $enumValues = [
            'SCHEDULED' => AppointmentStatus::SCHEDULED,
            'CONFIRMED' => AppointmentStatus::CONFIRMED,
            'CANCELLED' => AppointmentStatus::CANCELLED,
        ];
        
        $statusInfo = [];
        
        foreach ($enumValues as $name => $value) {
            $count = Appointment::where('status', $value)->count();
            $color = AppointmentStatus::fromValue($value)->color();

            $statusInfo[] = [
                'name' => $name,
                'value' => $value,
                'count' => $count,
                'color' => $color,
            ];
        }

        return $statusInfo;
    }
}