<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SurveyForm;
use App\Models\SurveySection;
use App\Models\SurveySectionField;
use App\Models\SurveyOpenPeriod;
use App\Models\Program;
use App\Models\BatchYear;
use App\Models\SurveyResponse;
use App\Models\SurveyResponseField;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use PDF;

class SurveyController extends Controller
{
    public function index()
    {
        return view('survey.main');
    }

    public function editSurveyForm($form_id)
    {
        $previousUrl = url()->previous();
        $defaultBackUrl = route('tracerMgmt.form-list');
        $overviewUrl = route('survey.survey-form-overview', $form_id);
        $backUrl = $defaultBackUrl;

        if ($previousUrl && !str_contains($previousUrl, 'survey-form-edit') && !str_contains($previousUrl, 'questionaire'))
            {
                $backUrl = $previousUrl;
            }
        else if ($previousUrl && str_contains($previousUrl, 'questionaire'))
            {
                $backUrl = $overviewUrl;
            }

        return view('survey.edit-form', compact('form_id', 'backUrl'));
    }

    public function viewSurveyFormOverview($form_id)
    {
        $form = SurveyForm::findOrFail($form_id);
        $is_published = $form->is_published;

        return view('survey.survey-form-overview', compact('form_id', 'is_published'));
    }

    public function showQuestionaire($form_id)
    {
        $form = SurveyForm::findOrFail($form_id);
        $program = null;
        $returnUrl = route('survey.form-edit', ['form_id' => $form->id ]);
        $batch_year = null;

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user()->load('programTaken');
            $program = $user->programTaken;
            $batch_year = $user->batch_year;
        }

        return view('survey.form.questionaire', compact('form', 'program', 'returnUrl', 'batch_year'));
    }

    public function setTargetParticipants(Request $request)
    {
        $participants = $request->input('participants');

        $validator = Validator::make($request->all(), [
            'form_id' => [
                'required',
                'integer',
                Rule::exists('survey_forms', 'id')
            ],
            'participants' => 'array',
            'participants.*' => 'array',
            'participants.*.*' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Validate program abbreviations (keys of participants)
        $programAbbreviations = array_keys($participants);
        $validProgramAbbreviations = DB::table('programs')->pluck('program_abbreviation')->toArray();

        $invalidPrograms = array_diff($programAbbreviations, $validProgramAbbreviations);
        if (!empty($invalidPrograms)) {
            return response()->json([
                'message' => 'Invalid program abbreviations.',
                'invalid_programs' => $invalidPrograms
            ], 422);
        }

        // Validate batch years
        $allBatchYears = DB::table('batch_year')->pluck('batch_year')->toArray();
        $invalidBatchYears = [];

        foreach ($participants as $programAbbreviation => $batchYears) {
            foreach ($batchYears as $year) {
                if (!in_array($year, $allBatchYears)) {
                    $invalidBatchYears[$programAbbreviation][] = $year;
                }
            }
        }

        if (!empty($invalidBatchYears)) {
            return response()->json([
                'message' => 'Invalid batch years found.',
                'invalid_batch_years' => $invalidBatchYears
            ], 422);
        }

        // Save the data
        $form = SurveyForm::findOrFail($request->form_id);
        $form->update([
            'target_participants' => json_encode($participants)
        ]);

        return response()->json([
            'message' => 'Target participants set successfully.'
        ]);
    }

    public function showUserSurveyLanding()
    {
        return view('survey.user-landing');
    }

    public function showQuestionaireToParticipate($form_id, $period_id)
    {
        $user = Auth::guard('web')->user()->load('programTaken');
        $program = $user->programTaken;
        $batch_year = $user->batch_year;
        $form = SurveyForm::findOrFail($form_id);
        $returnUrl = route('survey.user-survey-landing');
        $period = SurveyOpenPeriod::where(['survey_form_id' => $form->id, 'id' => $period_id])->first();
        $endpoint = route('survey.save-response', ['form_id' => $form->id]);
        $periodId;

        if ($period) $periodId = $period->id;

        return view('survey.form.questionaire', 
            compact('form', 'program', 'returnUrl', 'batch_year', 'periodId', 'period', 'endpoint'));
    }

    public function viewSurveyOverviewPerPeriod($form_id) {
        $form = SurveyForm::findOrFail($form_id);
        $periods = SurveyOpenPeriod::where(['survey_form_id' => $form->id])->get();
        $periodArray = [];

        if (count($periods) > 0)
        {
            foreach ($periods as $period) 
            {
                $obj = new \stdClass();
                $obj->id = $period->id;
                $obj->start_date = $period->start_date;
                $obj->end_date = $period->end_date;
                $obj->response_count = SurveyResponse::where(['survey_period_id' => $period->id, 'survey_form_id' => $form_id])->count();
                $periodArray[] = $obj; 
            }
        }

        $backUrl = route('survey.survey-form-overview', $form_id);

        return view('survey.overview-per-period', compact('form', 'periodArray', 'backUrl'));
    }

    public function viewSurveyOverviewPerProgram($form_id, $period_id) 
    {
        $form = SurveyForm::findOrFail($form_id);
        $programArray = [];

        if ($form->target_participants)
        {
            $targetParticipants = json_decode($form->target_participants, true);

            foreach ($targetParticipants as $keys => $batches) 
            {
                $program = Program::where('program_abbreviation', $keys)->first();

                if ($program)
                {
                    $obj = new \stdClass();
                    $obj->id = $program->id;
                    $obj->program_abbreviation = $program->program_abbreviation;
                    $obj->program_name = $program->program_name;
                    $obj->response_count = SurveyResponse::where([
                        'program_id' => $program->id,
                        'survey_form_id' => $form_id,
                        'survey_period_id' => $period_id
                        ])->count();
                    $programArray[] = $obj; 
                }
            }
        }

        return view('survey.overview-per-program', compact('form', 'programArray', 'period_id'));
    }

    public function viewTracerResponseStatsPerProgramPerBatch($form_id, $program_id, $period_id) 
    {
        $form = SurveyForm::findOrFail($form_id);
        $program = Program::findOrFail($program_id);
        $batchesArray = [];

        if ($form->target_participants)
        {
            $targetParticipants = json_decode($form->target_participants, true);
            $batches = $targetParticipants[$program->program_abbreviation];

            foreach ($batches as $batch) 
            {
                $obj = new \stdClass();
                $obj->batch = $batch;
                $obj->response_count = SurveyResponse::where([
                    'program_id' => $program->id,
                    'survey_form_id' => $form_id,
                    'survey_period_id' => $period_id,
                    'batch_year' => $batch
                    ])->count();
                $batchesArray[] = $obj; 
            }
        }

        return view('survey.overview-per-batches', compact('form', 'batchesArray', 'program_id', 'period_id'));
    }

    public function viewSurveyResponseAnalysis($form_id, $program_id, $period_id, $batch) 
    {
        $form = SurveyForm::findOrFail($form_id);
        $program = Program::findOrFail($program_id);

        $batch_yearObj = BatchYear::where('batch_year', $batch)->first();
        $form = SurveyForm::with(['sections' => function ($query) {
                $query->orderBy('order');
            }])->findOrFail($form_id);
        
        $fields = $form->fields;
        $sections = $form->sections;
        $responseCount = 0;
        $batch_year = $batch_yearObj->batch_year;

        $responses = SurveyResponse::where([
                'program_id' => $program->id,
                'survey_form_id' => $form->id,
                'batch_year' => $batch_year,
                'survey_period_id' => $period_id
            ])
            ->with('user')
            ->get();

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

        return view('survey.survey-responses-analysis', 
            compact('form', 'responses', 'fields', 'program_id', 'program',
            'sections', 'batch_year', 'responseCount',
            'maleParticipants', 'femaleParticipants', 'period_id'  ));
    }

    public function generateReport(Request $request) {

        $validatedData = $request->validate([
            'form_id' => [
                'required'
            ],
            'program_id' => [
                'required'
            ],
            'batch_year' => [
                'required'
            ],
            'period_id' => [
                'required'
            ]
        ]);

        $form = SurveyForm::findOrFail($validatedData['form_id']);
        $program = Program::findOrFail($validatedData['program_id']);
        $batch_year = $validatedData['batch_year'];
        $period = SurveyOpenPeriod::findOrFail($validatedData['period_id']);

        $statistics = new \stdClass();
        $statistics->totalRegistrations = User::where(['program_id' => $program->id, 'batch_year' => $batch_year])->count();
        
        $alumniResponses = SurveyResponse::with('user')->where([
                'program_id' => $program->id,
                'survey_form_id' => $form->id,
                'batch_year' => $batch_year,
                'survey_period_id'=> $validatedData['period_id'],
            ])->get();

        $statistics->respondents = $alumniResponses->count();
        
        $sections = SurveySection::where(['survey_form_id' => $form->id])->orderBy('order')->get();

        $section_list = [];

        foreach ($sections as $section) 
        {
            $sectionObj = new \stdClass();
            $sectionObj->title = $section->survey_section_title;

            $sectionFields = [];
            $fields = SurveySectionField::where(['section_id' => $section->id])->orderBy('order')->get();
            
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
                    $answers = SurveyResponseField::where([
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
                    $qAnalysisObj->responses_total_Count = SurveyResponseField::whereIn('response_id', $responseIds)
                        ->where(['field_id' => $question->id])->count();

                    $choiceObj_list = [];

                    $choices = array_map('trim', explode('|', $question->choices));

                    foreach($choices as $choice)
                    {
                        $choiceStatsObj = new \stdClass();
                        $choiceStatsObj->choice = $choice;
                        $answerCount = 0;

                        if ($question->type == "checkbox") {
                            $answerCount = SurveyResponseField::whereIn('response_id', $responseIds)
                            ->where(['field_id' => $question->id, 'section_id'=>$section->id])
                            ->where(function ($query) use ($choice) {
                                $query->where('value', 'LIKE', '%' . $choice . '%');
                            })
                            ->count();
                        }
                        else 
                        {
                            $answerCount = SurveyResponseField::whereIn('response_id', $responseIds)
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
                        $choiceObj_list[] = $choiceStatsObj;
                    }

                    $qAnalysisObj->choices = $choiceObj_list;
                    $responseAnalysis_list[] = $qAnalysisObj;
                }
            }

            $sectionObj->responseAnalysis_list = $responseAnalysis_list;
            $section_list[] = $sectionObj;
        }

        $pdf = PDF::loadView('pdf.survey-report', [
            'form' => $form,
            'program' => $program,
            'statistics' => $statistics,
            'section_list' => $section_list,
            'batch_year' => $batch_year,
            'period' => $period,
        ]);
        return $pdf->stream('survey.pdf');
    }
}