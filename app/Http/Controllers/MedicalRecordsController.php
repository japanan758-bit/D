<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class MedicalRecordsController extends Controller
{
    /**
     * Display a listing of medical records.
     */
    public function index(Request $request)
    {
        $query = MedicalRecord::with(['patient', 'doctor', 'appointment']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('patient_name', 'like', "%{$search}%")
                  ->orWhere('diagnosis', 'like', "%{$search}%")
                  ->orWhere('treatment_plan', 'like', "%{$search}%")
                  ->orWhere('symptoms', 'like', "%{$search}%");
            });
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by doctor
        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        $medicalRecords = $query->orderBy('created_at', 'desc')
            ->paginate(15);

        $doctors = Doctor::where('is_active', true)->get();

        return view('medical-records.index', compact('medicalRecords', 'doctors'));
    }

    /**
     * Show the form for creating a new medical record.
     */
    public function create(Request $request)
    {
        $appointmentId = $request->get('appointment_id');
        $appointment = null;
        $patient = null;

        if ($appointmentId) {
            $appointment = Appointment::with(['patient', 'service', 'doctor'])->find($appointmentId);
            if ($appointment) {
                $patient = Patient::where('email', $appointment->patient_email)
                    ->orWhere('name', $appointment->patient_name)
                    ->first();
            }
        }

        $doctors = Doctor::where('is_active', true)->get();
        $patients = Patient::orderBy('name')->get();

        return view('medical-records.create', compact('appointment', 'patient', 'doctors', 'patients'));
    }

    /**
     * Store a newly created medical record in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_email' => 'required|email',
            'patient_phone' => 'required|string|max:20',
            'patient_date_of_birth' => 'nullable|date|before:today',
            'patient_gender' => 'nullable|in:male,female',
            'patient_address' => 'nullable|string',
            'patient_emergency_contact' => 'nullable|string|max:255',
            'patient_allergies' => 'nullable|string',
            'patient_current_medications' => 'nullable|string',
            'patient_medical_history' => 'nullable|string',
            'patient_blood_type' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'chief_complaint' => 'required|string',
            'symptoms' => 'required|string',
            'duration' => 'nullable|string|max:255',
            'onset' => 'nullable|string|max:255',
            'severity' => 'nullable|in:mild,moderate,severe',
            'location' => 'nullable|string|max:255',
            'radiation' => 'nullable|string|max:255',
            'aggravating_factors' => 'nullable|string',
            'relieving_factors' => 'nullable|string',
            'associated_symptoms' => 'nullable|string',
            'past_medical_history' => 'nullable|string',
            'past_surgical_history' => 'nullable|string',
            'family_history' => 'nullable|string',
            'social_history' => 'nullable|string',
            'medication_history' => 'nullable|string',
            'drug_allergies' => 'nullable|string',
            'review_of_systems' => 'nullable|string',
            'physical_examination' => 'nullable|string',
            'vital_signs' => 'nullable|array',
            'general_appearance' => 'nullable|string',
            'vitals_height' => 'nullable|numeric',
            'vitals_weight' => 'nullable|numeric',
            'vitals_bp' => 'nullable|string',
            'vitals_hr' => 'nullable|integer',
            'vitals_temp' => 'nullable|numeric',
            'vitals_resp' => 'nullable|integer',
            'vitals_spo2' => 'nullable|integer',
            'lab_results' => 'nullable|array',
            'imaging_studies' => 'nullable|array',
            'other_investigations' => 'nullable|string',
            'diagnosis' => 'required|string',
            'differential_diagnosis' => 'nullable|string',
            'diagnosis_code' => 'nullable|string|max:50',
            'treatment_plan' => 'required|string',
            'medications' => 'nullable|array',
            'dosages' => 'nullable|array',
            'frequencies' => 'nullable|array',
            'durations' => 'nullable|array',
            'instructions' => 'nullable|string',
            'follow_up_instructions' => 'nullable|string',
            'next_appointment' => 'nullable|date|after:today',
            'referrals' => 'nullable|string',
            'patient_education' => 'nullable|string',
            'notes' => 'nullable|string',
            'attachments.*' => 'nullable|file|max:10240' // 10MB max per file
        ]);

        // Handle vital signs JSON
        if (isset($validated['vital_signs'])) {
            $validated['vital_signs'] = json_encode($validated['vital_signs']);
        }

        // Handle lab results JSON
        if (isset($validated['lab_results'])) {
            $validated['lab_results'] = json_encode($validated['lab_results']);
        }

        // Handle imaging studies JSON
        if (isset($validated['imaging_studies'])) {
            $validated['imaging_studies'] = json_encode($validated['imaging_studies']);
        }

        // Handle medications JSON
        if (isset($validated['medications'])) {
            $validated['medications'] = json_encode($validated['medications']);
        }

        // Handle dosages JSON
        if (isset($validated['dosages'])) {
            $validated['dosages'] = json_encode($validated['dosages']);
        }

        // Handle frequencies JSON
        if (isset($validated['frequencies'])) {
            $validated['frequencies'] = json_encode($validated['frequencies']);
        }

        // Handle durations JSON
        if (isset($validated['durations'])) {
            $validated['durations'] = json_encode($validated['durations']);
        }

        // Handle file attachments
        $attachmentPaths = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                if ($attachment->isValid()) {
                    $filename = 'record_' . time() . '_' . uniqid() . '.' . $attachment->getClientOriginalExtension();
                    $path = $attachment->storeAs('medical-records', $filename, 'public');
                    $attachmentPaths[] = $path;
                }
            }
        }
        $validated['attachments'] = json_encode($attachmentPaths);

        // Set default values
        $validated['created_by'] = Auth::id();
        $validated['record_date'] = Carbon::now()->toDateString();

        $medicalRecord = MedicalRecord::create($validated);

        return redirect()->route('medical-records.show', $medicalRecord)
            ->with('success', 'تم إنشاء السجل الطبي بنجاح');
    }

    /**
     * Display the specified medical record.
     */
    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient', 'doctor', 'appointment', 'creator']);

        // Decode JSON fields for display
        $medicalRecord->vital_signs = json_decode($medicalRecord->vital_signs, true) ?? [];
        $medicalRecord->lab_results = json_decode($medicalRecord->lab_results, true) ?? [];
        $medicalRecord->imaging_studies = json_decode($medicalRecord->imaging_studies, true) ?? [];
        $medicalRecord->attachments = json_decode($medicalRecord->attachments, true) ?? [];
        $medicalRecord->medications = json_decode($medicalRecord->medications, true) ?? [];
        $medicalRecord->dosages = json_decode($medicalRecord->dosages, true) ?? [];
        $medicalRecord->frequencies = json_decode($medicalRecord->frequencies, true) ?? [];
        $medicalRecord->durations = json_decode($medicalRecord->durations, true) ?? [];

        return view('medical-records.show', compact('medicalRecord'));
    }

    /**
     * Show the form for editing the specified medical record.
     */
    public function edit(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient', 'doctor', 'appointment']);

        // Decode JSON fields for editing
        $medicalRecord->vital_signs = json_decode($medicalRecord->vital_signs, true) ?? [];
        $medicalRecord->lab_results = json_decode($medicalRecord->lab_results, true) ?? [];
        $medicalRecord->imaging_studies = json_decode($medicalRecord->imaging_studies, true) ?? [];
        $medicalRecord->attachments = json_decode($medicalRecord->attachments, true) ?? [];
        $medicalRecord->medications = json_decode($medicalRecord->medications, true) ?? [];
        $medicalRecord->dosages = json_decode($medicalRecord->dosages, true) ?? [];
        $medicalRecord->frequencies = json_decode($medicalRecord->frequencies, true) ?? [];
        $medicalRecord->durations = json_decode($medicalRecord->durations, true) ?? [];

        $doctors = Doctor::where('is_active', true)->get();
        $patients = Patient::orderBy('name')->get();

        return view('medical-records.edit', compact('medicalRecord', 'doctors', 'patients'));
    }

    /**
     * Update the specified medical record in storage.
     */
    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'patient_email' => 'required|email',
            'patient_phone' => 'required|string|max:20',
            'patient_date_of_birth' => 'nullable|date|before:today',
            'patient_gender' => 'nullable|in:male,female',
            'patient_address' => 'nullable|string',
            'patient_emergency_contact' => 'nullable|string|max:255',
            'patient_allergies' => 'nullable|string',
            'patient_current_medications' => 'nullable|string',
            'patient_medical_history' => 'nullable|string',
            'patient_blood_type' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_id' => 'nullable|exists:appointments,id',
            'chief_complaint' => 'required|string',
            'symptoms' => 'required|string',
            'duration' => 'nullable|string|max:255',
            'onset' => 'nullable|string|max:255',
            'severity' => 'nullable|in:mild,moderate,severe',
            'location' => 'nullable|string|max:255',
            'radiation' => 'nullable|string|max:255',
            'aggravating_factors' => 'nullable|string',
            'relieving_factors' => 'nullable|string',
            'associated_symptoms' => 'nullable|string',
            'past_medical_history' => 'nullable|string',
            'past_surgical_history' => 'nullable|string',
            'family_history' => 'nullable|string',
            'social_history' => 'nullable|string',
            'medication_history' => 'nullable|string',
            'drug_allergies' => 'nullable|string',
            'review_of_systems' => 'nullable|string',
            'physical_examination' => 'nullable|string',
            'vital_signs' => 'nullable|array',
            'general_appearance' => 'nullable|string',
            'vitals_height' => 'nullable|numeric',
            'vitals_weight' => 'nullable|numeric',
            'vitals_bp' => 'nullable|string',
            'vitals_hr' => 'nullable|integer',
            'vitals_temp' => 'nullable|numeric',
            'vitals_resp' => 'nullable|integer',
            'vitals_spo2' => 'nullable|integer',
            'lab_results' => 'nullable|array',
            'imaging_studies' => 'nullable|array',
            'other_investigations' => 'nullable|string',
            'diagnosis' => 'required|string',
            'differential_diagnosis' => 'nullable|string',
            'diagnosis_code' => 'nullable|string|max:50',
            'treatment_plan' => 'required|string',
            'medications' => 'nullable|array',
            'dosages' => 'nullable|array',
            'frequencies' => 'nullable|array',
            'durations' => 'nullable|array',
            'instructions' => 'nullable|string',
            'follow_up_instructions' => 'nullable|string',
            'next_appointment' => 'nullable|date|after:today',
            'referrals' => 'nullable|string',
            'patient_education' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        // Handle vital signs JSON
        if (isset($validated['vital_signs'])) {
            $validated['vital_signs'] = json_encode($validated['vital_signs']);
        }

        // Handle lab results JSON
        if (isset($validated['lab_results'])) {
            $validated['lab_results'] = json_encode($validated['lab_results']);
        }

        // Handle imaging studies JSON
        if (isset($validated['imaging_studies'])) {
            $validated['imaging_studies'] = json_encode($validated['imaging_studies']);
        }

        // Handle medications JSON
        if (isset($validated['medications'])) {
            $validated['medications'] = json_encode($validated['medications']);
        }

        // Handle dosages JSON
        if (isset($validated['dosages'])) {
            $validated['dosages'] = json_encode($validated['dosages']);
        }

        // Handle frequencies JSON
        if (isset($validated['frequencies'])) {
            $validated['frequencies'] = json_encode($validated['frequencies']);
        }

        // Handle durations JSON
        if (isset($validated['durations'])) {
            $validated['durations'] = json_encode($validated['durations']);
        }

        $medicalRecord->update($validated);

        return redirect()->route('medical-records.show', $medicalRecord)
            ->with('success', 'تم تحديث السجل الطبي بنجاح');
    }

    /**
     * Remove the specified medical record from storage.
     */
    public function destroy(MedicalRecord $medicalRecord)
    {
        // Delete attachments
        if ($medicalRecord->attachments) {
            $attachments = json_decode($medicalRecord->attachments, true) ?? [];
            foreach ($attachments as $attachment) {
                Storage::disk('public')->delete($attachment);
            }
        }

        $medicalRecord->delete();

        return redirect()->route('medical-records.index')
            ->with('success', 'تم حذف السجل الطبي بنجاح');
    }

    /**
     * Download medical record attachment.
     */
    public function downloadAttachment(MedicalRecord $medicalRecord, $attachmentIndex)
    {
        $attachments = json_decode($medicalRecord->attachments, true) ?? [];
        
        if (!isset($attachments[$attachmentIndex])) {
            abort(404, 'الملف غير موجود');
        }

        $attachmentPath = $attachments[$attachmentIndex];
        
        if (!Storage::disk('public')->exists($attachmentPath)) {
            abort(404, 'الملف غير موجود');
        }

        return Storage::disk('public')->download($attachmentPath);
    }

    /**
     * Search medical records by patient.
     */
    public function searchByPatient(Request $request)
    {
        $request->validate([
            'patient_email' => 'required|email',
            'patient_phone' => 'required|string',
        ]);

        $records = MedicalRecord::where('patient_email', $request->patient_email)
            ->orWhere('patient_phone', $request->patient_phone)
            ->with(['doctor', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($records);
    }

    /**
     * Generate medical report.
     */
    public function generateReport(Request $request, MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient', 'doctor', 'appointment', 'creator']);

        // Decode JSON fields
        $medicalRecord->vital_signs = json_decode($medicalRecord->vital_signs, true) ?? [];
        $medicalRecord->lab_results = json_decode($medicalRecord->lab_results, true) ?? [];
        $medicalRecord->medications = json_decode($medicalRecord->medications, true) ?? [];

        return view('medical-records.report', compact('medicalRecord'));
    }

    /**
     * Export medical record as PDF.
     */
    public function exportPdf(MedicalRecord $medicalRecord)
    {
        // This would require a PDF library like DomPDF
        // For now, we'll just show the view
        
        return view('medical-records.pdf', compact('medicalRecord'));
    }

    /**
     * Get patient history.
     */
    public function getPatientHistory(Request $request)
    {
        $request->validate([
            'patient_email' => 'required|email',
        ]);

        $records = MedicalRecord::where('patient_email', $request->patient_email)
            ->with(['doctor', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->get();

        $appointments = Appointment::where('patient_email', $request->patient_email)
            ->with(['service', 'doctor'])
            ->orderBy('appointment_date', 'desc')
            ->get();

        return response()->json([
            'records' => $records,
            'appointments' => $appointments
        ]);
    }

    /**
     * Quick medical record for appointment.
     */
    public function quickRecord(Request $request, Appointment $appointment)
    {
        if ($appointment->status !== 'completed') {
            return back()->with('error', 'لا يمكن إنشاء سجل طبي لموعد غير مكتمل');
        }

        $existingRecord = MedicalRecord::where('appointment_id', $appointment->id)->first();
        
        if ($existingRecord) {
            return redirect()->route('medical-records.show', $existingRecord);
        }

        $patient = Patient::where('email', $appointment->patient_email)
            ->orWhere('name', $appointment->patient_name)
            ->first();

        return view('medical-records.quick-create', compact('appointment', 'patient'));
    }

    /**
     * Export medical records data.
     */
    public function export()
    {
        $records = MedicalRecord::with(['patient', 'doctor'])
            ->orderBy('created_at', 'desc')
            ->get();

        $filename = 'medical_records_' . date('Y-m-d_H-i-s') . '.csv';
        $filePath = storage_path('app/exports/' . $filename);

        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }

        $handle = fopen($filePath, 'w');

        // CSV headers
        fputcsv($handle, [
            'ID',
            'Patient Name',
            'Patient Email',
            'Patient Phone',
            'Doctor',
            'Chief Complaint',
            'Diagnosis',
            'Treatment Plan',
            'Record Date',
            'Created At'
        ]);

        foreach ($records as $record) {
            fputcsv($handle, [
                $record->id,
                $record->patient_name,
                $record->patient_email,
                $record->patient_phone,
                $record->doctor->name ?? 'N/A',
                substr($record->chief_complaint, 0, 100) . '...',
                substr($record->diagnosis, 0, 100) . '...',
                substr($record->treatment_plan, 0, 100) . '...',
                $record->record_date,
                $record->created_at
            ]);
        }

        fclose($handle);

        return response()->download($filePath, $filename);
    }
}