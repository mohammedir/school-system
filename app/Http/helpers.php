<?php


use App\Models\EngineeringOffer;
use App\Models\Settings;
use Illuminate\Support\Facades\Auth;

function getlookup($id){
    $lookup = \App\Models\Lookups::query()->find($id);

    return $lookup ;
}
function get_lookup_by_master_key($master_key){

    $lookup = \App\Models\Lookups::where('master_key', $master_key)
        ->where(function ($query) {
            $query->whereNull('parent_id')
                ->orWhere('parent_id', '!=', 0);
        })->where('status',1)
        ->where('level',null)
        ->get();

    return $lookup ;
}
function getUserData($id){
    $user = \App\Models\User::find($id);
    return $user;
}
function getInvestorData($id){
    $investor = \App\Models\Investors::find($id);
    return $investor;
}
function getSettings(){
     $settings = Settings::get()->first();
    return $settings;
}

function getEngineeringOffer($id){

    $offer = EngineeringOffer::with('project')->where('id', $id)->first();

    return $offer;
}


function getContractorData($id){
    $Contractor = \App\Models\Contractors::find($id);
    return $Contractor;
}

function format_price_email($price, $default = '-')
{
    if ($price === null) {
        return $default;
    }

    return number_format($price, 2, '.', '');
}

function getlookupId($master_key, $models_status)
{
    return \App\Models\Lookups::where('master_key', $master_key)
        ->where('item_key', $models_status)
        ->value('id');
}
