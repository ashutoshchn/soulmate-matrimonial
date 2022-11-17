<?php

namespace App\Models;
use App\Models\Member;
use App\Models\Package;
use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Str;
use Auth;
use Hash;

class MembersExport implements FromCollection, WithHeadings
{
    use Exportable;

    public function collection()
    {
        //return User::query(); 
        //return \DB::select('SELECT * from UsersDataTest'); 
        $temp= \DB::table(\DB::raw("DownloadAllUserData"))->orderBy('created_at','ASC');

        return $temp->get();
    }
    public function headings(): array
    {
        return [
            'MemberId',
'first_name',
'last_name',
'email',
'email_verified_at',
'phone',
'phone_verified_at',
'blocked',
'deactivated',
'permanently_delete',
'approved',
'created_at',
'deleted_at',
'gender',
'birthday',
'introduction',
'maritalstatus',
'mother_tongue',
'package_name',
'remaining_interest',
'remaining_contact_view',
'remaining_photo_gallery',
'auto_profile_match',
'package_validity',
'profile_picture_privacy',
'gallery_image_privacy',
'present_country',
'present_state',
'present_city',
'present_postal_code',
'perm_country',
'perm_state',
'perm_city',
'perm_postal_code',
'sun_sign',
'moon_sign',
'time_of_birth',
'city_of_birth',
'astrologies_manglik',
'careers',
'education',
'father',
'mother',
'sibling',
'hobbies',
'interests',
'diet',
'lifestyles_drink',
'smoke',
'living_with',
'partner_expectations_general',
'partner_expectations_min_height',
'partner_expectations_marital_status',
'partner_expectations_residence_country',
'partner_expectations_religion',
'partner_expectations_caste',
'partner_expectations_sub_caste',
'education',
'profession',
'smoking_acceptable',
'partner_expectations_diet',
'partner_expectations_drinking_acceptable',
'partner_expectations_manglik',
'partner_expectations_language',
'partner_expectations_preferred_country_id',
'partner_expectations_preferred_state',
'partner_age_from',
'partner_age_to',
'payment_status',
'amount',
'package_payments_created_at',
'height',
'disability',
'birth_country',
'recidency_country',
'citizen_country',
'immigration_status',
'spiritual_backgrounds_religion',
'spiritual_backgrounds_caste',
'spiritual_backgrounds_sub_caste',
'ethnicity',
'family_value'
        ];
    }
}
