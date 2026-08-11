<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\User;
use App\Models\Field;
use App\Models\Response;
use App\Models\Program;
use App\Models\FormPublish;
use App\Models\FormSection;
use App\Models\FormSectionField;
use App\Models\ResponseField;
use App\Models\BatchYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ResponseController;
use PDF;

class TracerController extends Controller
{

    public function showQuestionaire($form_id) {
        $form = Form::findOrFail($form_id);
        $program = null;
        $returnUrl = '/form/' . $form->id;
        $batch_year = null;

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user()->load('programTaken');
            $program = $user->programTaken;
            $batch_year = $user->batch_year;
        }

        return view('tracer.form.questionaire', compact('form', 'program', 'returnUrl', 'batch_year'));
    }

    public function viewTracerParticipation() {
        return view('alumni.tracer');
    }

    public function viewConsent() {
        return view('tracer.consent');
    }

    public function processConsent(Request $request)
    {
        $request->validate([
            'agree' => 'accepted',
        ], [
            'agree.accepted' => 'You must agree to proceed.',
        ]);

        $published = Form::with('sections.fields')->where('isPublished', 1)->first();

        if ($published) {
            return redirect()->route('tracer.questionaire', $published->id);
        }

        return redirect()->route('tracer.participation');
    }


    public function viewTracerOverviewPerProgram($form_id) {
        $programs = Program::all();
        $programArray = [];

        foreach ($programs as $index => $program) {
            $obj = new \stdClass();
            $obj->id = $program->id;
            $obj->program_abbreviation = $program->program_abbreviation;
            $obj->program_name = $program->program_name;
            $obj->user_count = User::where(['program_id' => $program->id])->count();
            $obj->response_count = Response::where(['program_id' => $program->id, 'form_id' => $form_id])->count();
            $programArray[] = $obj; 
        }

        $form = Form::findOrFail($form_id);

        $previousUrl = url()->previous();
        $defaultBackUrl = route('tracerMgmt.form-list');
        $formListUrl = route('tracerMgmt.form-list', $form_id);
        $backUrl = $defaultBackUrl;

        if ($previousUrl && str_contains($previousUrl, 'form-list'))
        {
            $backUrl = $formListUrl;
        }

        return view('tracer.overview-per-program', compact('form', 'programArray', 'backUrl'));
    }

    public function viewTracerOverviewPerProgramPerBatch($form_id, $program_id) {
        $batches = BatchYear::orderBy('batch_year', 'desc')->get();

        $responseStatsPerBatch = [];

        foreach ($batches as $batch) {
            $obj = new \stdClass();
            $obj->id = $batch->id;
            $obj->batch_year = $batch->batch_year;
            $obj->user_count = User::where(['program_id' => $program_id, 'batch_year' => $batch->batch_year])->count();
            $obj->response_count = Response::where(['form_id' => $form_id, 'program_id' => $program_id, 'batch_year' => $batch->batch_year])->count();
            $responseStatsPerBatch[] = $obj; 
        }

        $form = Form::findOrFail($form_id);
        $program = Program::findOrFail($program_id);
        $totalAlumniByProgram = User::where(['program_id' => $program_id])->count();
        $male = User::whereIn('gender', ['male', 'Male'])
            ->where('program_id', $program_id)
            ->count();
        $female = User::whereIn('gender', ['female', 'Female'])
            ->where('program_id', $program_id)
            ->count();

        $responses = Response::where([
            'form_id' => $form_id,
            'program_id' => $program_id
        ])->get();

        $totalParticipants = $responses->count();

        $userIds = $responses->pluck('user_id');

        $maleParticipants = User::whereIn('gender', ['male', 'Male'])
            ->whereIn('id', $userIds)
            ->where('program_id', $program_id)
            ->count();

        $femaleParticipants = User::whereIn('gender', ['female', 'Female'])
            ->whereIn('id', $userIds)
            ->where('program_id', $program_id)
            ->count();

        return view('tracer.overview-per-batches', 
            compact('form', 'responseStatsPerBatch', 'program_id',
            'program', 'totalParticipants', 'totalAlumniByProgram',
            'male', 'female', 'maleParticipants', 'femaleParticipants'));
    }

    public function viewTracerResponseStatsPerProgramPerBatch($form_id, $program_id, $batch_id) 
    {
        $batch = BatchYear::where('id', $batch_id)->first();
        $form = Form::with(['sections' => function ($query) {
                $query->orderBy('order');
            }])->findOrFail($form_id);
        
        $fields = $form->fields;
        $sections = $form->sections;
        $responseCount = 0;
        $batch_year = $batch->batch_year;

        $responses = Response::where(['program_id' => $program_id, 'form_id' => $form_id, 'batch_year' => $batch->batch_year])
            ->with('user')
            ->get();

        $program = Program::find($program_id);
        $responseCount = $responses->count();
        $userIds = $responses->pluck("user_id");

        $maleParticipants = User::whereIn('gender', ['male', 'Male'])
            ->whereIn('id', $userIds)
            ->where('program_id', $program_id)
            ->count();
        $femaleParticipants = User::whereIn('gender', ['female', 'Female'])
            ->whereIn('id', $userIds)
            ->where('program_id', $program_id)
            ->count();

        return view('tracer.responses', 
            compact('form', 'responses', 'fields', 'program_id', 'program',
            'sections', 'batch_year', 'responseCount',
            'maleParticipants', 'femaleParticipants'  ));
    }

    /**
     * Retrieves tracer responses for a specific program.
     *
     * @param int $form_id
     * @param int $program_id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function viewTracerResponsesPerProgram($form_id, $program_id)
    {
        $form = Form::with(['sections' => function ($query) {
            $query->orderBy('order');
        }])->findOrFail($form_id);

        $fields = $form->fields;
        $sections = $form->sections;
        $responses = Response::where('program_id', $program_id)
            ->where('form_id', $form_id)
            ->with('user')
            ->get();
        $program = Program::find($program_id);

        return view('tracer.responses', compact('form', 'responses', 'fields', 'program_id', 'program', 'sections'));
    }

    // public function editTracerResponse($response_id)
    // {
    //     $response = Response::with([
    //         'form.fields.options',
    //         'responseFields.field',
    //         'program'
    //     ])->find($response_id);
        
    //     $responseData = [
    //         'id' => $response->id,
    //         'form_id' => $response->form_id,
    //         'user_id' => $response->user_id,
    //         'program_id' => $response->program_id,
    //         'form' => [
    //             'id' => $response->form->id,
    //             'title' => $response->form->title,
    //             'fields' => $response->form->fields->map(function ($field) use ($response) {
    //                 $responseField = $response->responseFields->firstWhere('field_id', $field->id);
    //                 return [
    //                     'id' => $field->id,
    //                     'label' => $field->label,
    //                     'type' => $field->type,
    //                     'options' => $field->options->map(function ($option) {
    //                         return [
    //                             'id' => $option->id,
    //                             'value' => $option->value
    //                         ];
    //                     }),
    //                     'response_field' => $responseField ? [
    //                         'id' => $responseField->id,
    //                         'value' => $responseField->value
    //                     ] : null
    //                 ];
    //             })
    //         ]
    //     ];

    //     $responseWithFields = Response::with('responseFields')->find($response_id);

    //     return view('tracer.response-edit', compact('response', 'responseWithFields'));
    // }

    public function generateTracerReport(Request $request) {

        $validatedData = $request->validate([
            'form_id' => [
                'required'
            ],
            'program_id' => [
                'required'
            ],
            'batch_year' => [
                'required'
            ]
        ]);

        $form = Form::findOrFail($validatedData['form_id']);
        $program = Program::findOrFail($validatedData['program_id']);
        $batch_year = $validatedData['batch_year'];
        
        $title = "Tracer report";

        $statistics = new \stdClass();
        $statistics->totalRegistrations = User::where(['program_id' => $program->id, 'batch_year' => $batch_year])->count();
        
        $alumniResponses = Response::with('user')->where([
            'program_id' => $program->id, 'form_id' => $form->id, 'batch_year' => $batch_year
            ])->get();

        $statistics->respondents = $alumniResponses->count();
        
        $sections = FormSection::where(['form_id' => $form->id])->orderBy('order')->get();

        $section_list = [];

        foreach ($sections as $section) 
        {
            $sectionObj = new \stdClass();
            $sectionObj->title = $section->question_section_title;

            $sectionFields = [];
            $fields = FormSectionField::where(['section_id' => $section->id])->orderBy('order')->get();
            
            if ($fields->count() > 0) 
            {
                foreach($fields as $field)
                {
                    $fieldObj = new \stdClass();
                    $fieldObj->label = $field->field_label;
                    $fieldObj->id = $field->id;
                    $fieldObj->type = $field->type;
                    $fieldObj->choices = $field->choices;
                    $sectionFields[] = $fieldObj;
                }
            }

            $sectionObj->fields = $sectionFields;

            $usersSectionResponses = [];

            foreach($alumniResponses as $userResponse)
            {
                $userResponseObj = new \stdClass();
                $userResponseObj->first_name = $userResponse->user->first_name;
                $userResponseObj->last_name = $userResponse->user->last_name;
                $userSectionResponses = [];
                
                foreach($sectionFields as $sectionField)
                {
                    $answers = ResponseField::where([
                        'section_id' =>$section->id,
                        'field_id' => $sectionField->id,
                        'response_id' => $userResponse->id,
                    ])->first();

                    $userSectionResponses[] = $answers ? $answers->value : null;
                }

                $userResponseObj->userSectionResponses = $userSectionResponses;
                $usersSectionResponses[] = $userResponseObj;
            }

            $sectionObj->usersSectionResponses = $usersSectionResponses;
            $responseAnalysis_list = [];

            $responseIds = $alumniResponses->pluck('id');

            foreach ($sectionObj->fields as $question) {
                
                if ($question->type == "radio" ||
                    $question->type == "select" ||
                    $question->type == "checkbox" )
                {
                    $qAnalysisObj = new \stdClass();
                    $qAnalysisObj->question = $question->label;
                    $qAnalysisObj->responses_total_Count = ResponseField::whereIn('response_id', $responseIds)
                        ->where(['field_id' => $question->id])->count();

                    $choiceObj_list = [];

                    $choices = array_map('trim', explode('|', $question->choices));

                    foreach($choices as $choice)
                    {
                        $choiceStatsObj = new \stdClass();
                        $choiceStatsObj->choice = $choice;
                        $answerCount = 0;

                        if ($question->type == "checkbox") 
                        {
                            $answerCount = ResponseField::whereIn('response_id', $responseIds)
                            ->where(['field_id' => $question->id, 'section_id'=>$section->id])
                            ->where(function ($query) use ($choice) {
                                $query->where('value', 'LIKE', '%' . $choice . '%');
                            })
                            ->count();
                        }
                        else
                        {
                            $answerCount = ResponseField::whereIn('response_id', $responseIds)
                            ->where(['field_id' => $question->id, 'section_id'=>$section->id])
                            ->where(function ($query) use ($choice) {
                                $query->where('value', $choice);
                            })
                            ->count();
                        }

                        $total = (int) ($qAnalysisObj->responses_total_Count ?? 0);
                        $answerCount = (int) ($answerCount ?? 0);

                        if ($total > 0) {
                            $choiceStatsObj->percentage = round(($answerCount / $total) * 100, 2);
                        } else {
                            // Decide the desired behavior when total is 0:
                            // Option A: treat as 0%
                            $choiceStatsObj->percentage = 0.0;

                            // Option B: use null to indicate "not applicable"
                            // $choiceStatsObj->percentage = null;

                            // Option C: store a string like 'N/A' if your UI expects text
                            // $choiceStatsObj->percentage = 'N/A';
                        }

                        $choiceStatsObj->answer_count = $answerCount;
                        //$choiceStatsObj->percentage = round($answerCount / $qAnalysisObj->responses_total_Count * 100, 2);
                        $choiceObj_list[] = $choiceStatsObj;
                    }

                    $qAnalysisObj->choices = $choiceObj_list;
                    $responseAnalysis_list[] = $qAnalysisObj;
                }
            }

            $sectionObj->responseAnalysis_list = $responseAnalysis_list;
            $section_list[] = $sectionObj;
        }

        $pdf = PDF::loadView('pdf.tracer-report', [
            'title' => $title, 
            'form' => $form,
            'program' => $program,
            'statistics' => $statistics,
            'section_list' => $section_list,
            'batch_year' => $batch_year,
        ]);
        return $pdf->stream('tracer.pdf');
    }
}
