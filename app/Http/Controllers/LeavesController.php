<?php

namespace App\Http\Controllers;

use App\Models\Leaves;
use Dotenv\Parser\Lexer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LeavesController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Add leaves.
     *
     * @return void
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|min:5|max:200',
            'from' => 'required|date_format:Y-m-d',
            'to' => 'required|date_format:Y-m-d',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $current = strtotime(date("Y-m-d"));
        // For To
        $to_date    = strtotime($request->get('to'));
        $datediff = $to_date - $current;
        $difference_to = floor($datediff / (60 * 60 * 24));

        // For From
        $from_date    = strtotime($request->get('from'));
        $datedifff = $from_date - $current;
        $difference_from = floor($datedifff / (60 * 60 * 24));

        // From & To incorrect dates
        $datediffff =  $to_date - $from_date;
        $difference_to_from = floor($datediffff / (60 * 60 * 24));
        if (!($difference_to >= 0 && $difference_from >= 0 && $difference_to_from >= 0)) {
            return response()->json("{error: 'wrong date!'}", 400);
        }

        // Checks current year and get only working days
        $leaves = DB::table('leaves')->select('to','from')->whereYear('from','=', date("Y"))->get();
        $workingDays = 0;
        for ($i=0; $i < count($leaves); $i++) {
            $startTimestamp = strtotime($leaves[$i]->from);
            $endTimestamp = strtotime($leaves[$i]->to);
            for ($j = $startTimestamp; $j <= $endTimestamp; $j = $j + (60 * 60 * 24)) {
                if (date("N", $j) <= 5) $workingDays = $workingDays + 1;
            }
        }
        if ($workingDays > 25) {
            return response()->json(['masg' => "you can't take more then 25 days leave in a year!"], 400);
        }

        $leave = new Leaves();
        $leave->reason = $request->get('reason');
        $leave->to = $request->get('to');
        $leave->from = $request->get('from');
        $leave->user()->associate($request->user());

        $leave->save();

        return 'Success';
    }

    /**
     * Get all users leaves.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_all(Request $request)
    {
        if ($request->user()->type != "mang") {
            return response()->json("{error: 'Not Allowed'}", 405);
        }
        $leaves = Leaves::with('user')->get();
        return response()->json($leaves);
    }

    /**
     * Get self leaves.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_self(Request $request)
    {
        $leaves = Leaves::where('user_id','=', $request->user()->id)->get();
        return response()->json($leaves);
    }

    /**
     * Update users leaves by leave id.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_leave(Request $request)
    {
        if ($request->user()->type != "mang") {
            return response()->json(['masg' => 'Not Allowed'], 405);
        }
        $validator = Validator::make($request->all(), [
            'approved' => 'required|boolean',
            'leave_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $leave = Leaves::find($request->leave_id);
        $leave->is_approved = $request->approved;
        $leave->update();
        return response()->json($leave);
    }
}
