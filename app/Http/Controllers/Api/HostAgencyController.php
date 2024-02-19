<?php

    namespace App\Http\Controllers\Api;

    use App\Http\Controllers\Controller;
    use App\Models\AgencyMember;
    use App\Models\AgencyMemberPoints;
    use App\Models\AgencyMemberStatistics;
    use App\Models\AppUser;
    use App\Models\HostAgency;
    use App\Models\Target;
    use Carbon\Carbon;
    use Illuminate\Database\QueryException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;

    class HostAgencyController extends Controller
    {
        public function getAgencyByTag($tag){
            try{
                $agencies = HostAgency::where('tag' , '=' , $tag) -> get();
                if(count($agencies) > 0){
                $agency = $agencies[0];
                return response()->json(['state' => 'success' , 'agency' => $agency]);

                } else {
                    return response()->json(['state' => 'failed' , 'message' => 'Agency not found']);

                }
            }catch(QueryException $ex){
                return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

            }
        
        }
        public function JoinAgencyRequest(Request $request){
            try{
                $agency = HostAgency::find($request -> agency_id);
                $user = AppUser::find($request -> user_id);
                if($agency && $user){
                    if($agency -> active == 1 && $agency -> allow_new_joiners == 1){
                        AgencyMember::create([
                            'agency_id' => $request -> agency_id,
                            'user_id' => $request -> user_id,
                            'state' => $agency -> automatic_accept_joiners, 
                            'joining_date' => Carbon::now(),
                            'approval_date' => Carbon::now()
                        ]);
                        return response()->json(['state' => 'success' , 'message' => 'successfully Joined!' ]);

                    } else {
                        return response()->json(['state' => 'failed' , 'message' =>  'Agency is not accepting users right now']);

                    }
            
                } else {
                    return response()->json(['state' => 'failed' , 'message' => 'Agency or user not found']);

                }

            }catch(QueryException $ex){
                return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);
            }

        }


        public function getAgencyMembers($agent_id){
        try{
            $agencies = HostAgency::where('user_id' , '=' , $agent_id) -> get();
            if(count($agencies) > 0) {
                $agency = $agencies[0];
                $members = DB::table('agency_members') -> join('app_users' , 'agency_members.user_id' , '=' , 'app_users.id')
                -> select('agency_members.*' , 'app_users.name as member_name' , 'app_users.tag as member_tag' , 'app_users.gender as member_gender' 
                , 'app_users.img as member_img' )
                -> where('agency_members.agency_id' , '=' ,   $agency -> id)
                -> get();

                return response()->json(['state' => 'success' , 'agency' => $agency , 'members' => $members]);
            }  else {
                return response()->json(['state' => 'failed' , 'message' => "Agency not found"]);

            }
            

        }catch(QueryException $ex){
            return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

        }
        }
        public function getAgencyMemberStatics($user_id){
            try{
                
                
                $members = DB::table('agency_members')-> join('app_users' , 'agency_members.user_id' , '=' , 'app_users.id')
                -> select('app_users.name as member_name' , 'app_users.tag as member_tag' , 'app_users.img as member_img' , 'agency_members.joining_date as joining_date' ) 
                -> where('agency_members.user_id' , '=' , $user_id)
                -> get();
                if(count($members) > 0){
                    $member = $members[0];
                    $statics = AgencyMemberStatistics::where('user_id' , '=' , $user_id) -> get();
                    $points = AgencyMemberPoints::where('user_id' , '=' , $user_id) -> get();
                    $ps = 0 ;
                    foreach($points as $point){
                        $ps +=  $point -> points ;
                    }
                    $targets =  Target::orderBy('id', 'asc') -> get();
                    $currentTarget = $targets -> where('gold' , '<=' , $ps) -> first();
                    if($currentTarget){
                        $nextTarget = $targets -> where('id' , '>' , $currentTarget -> id) -> first();

                    }
                    else {
                        $nextTarget = $targets[0];

                    }

                    
                    return response()->json(['state' => 'success' , 'member' => $member , 'statics' => $statics , 'points' => $points , 'currentTarget' => $currentTarget , 'nextTarget' => $nextTarget]);
        
                } else {
                    return response()->json(['state' => 'failed' , 'message' => "Member not found"]);

                }

            }catch(QueryException $ex){
                return response()->json(['state' => 'failed' , 'message' => $ex->getMessage()]);

            }
    
            
        }
    }
