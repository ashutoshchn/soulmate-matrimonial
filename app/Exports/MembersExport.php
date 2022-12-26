<?php

namespace App\Exports;
use DB;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\FromCollection;


class MembersExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings():array{
        return[
            'MemberId',
            'first_name',
            'last_name',
            'email',
            'email_verified_at',
            'phone',
            'phone_verified_at',
            'blocked',
            'deactivated',
            'permanently_deleted',
            'approved',
            'created_at',
            'deleted_at',
            'gender',
            'birthday',
            'introduction',
            'marital_status',
            'mother_tongue',
            'package_name',
            'remaining_interests',
            'remaining_contact_view',
            'remaining_photo_gallery',
            'auto_profile_match',
            'package_validity',
            'profile_picture_privacy',
            'gallery_image_privacy',
            'sun_sign',
            'moon_sign',
            'time_of_birth',
            'city_of_birth',
            'astrologies_manglik',
            'careers_designation',
            'careers_company',
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
            'family_value',
        ];
    } 

    public function collection()
    {
        // $data =  DB::table('users')
        //         ->rightJoin('members', 'members.user_id', '=','users.id')
        //         ->leftJoin('marital_statuses', 'members.marital_status_id', '=','marital_statuses.id')
        //         ->leftJoin('member_languages', 'members.mothere_tongue', '=','member_languages.id')
        //         ->leftJoin('packages', 'members.current_package_id', '=','packages.id')
        //         ->leftJoin('astrologies', 'members.user_id', '=','astrologies.user_id')
        //         ->leftJoin('careers', function($join) {
        //             $join->on('members.user_id','=','careers.user_id')
        //             ->where('careers.deleted_at','NULL');
        //         })
        //         ->leftJoin('families','members.user_id','=','families.user_id')
        //         ->leftJoin('hobbies','members.user_id','=','hobbies.user_id')
        //         ->leftJoin('lifestyles','members.user_id','=','lifestyles.user_id')
        //         ->leftJoin('partner_expectations','members.user_id','=','partner_expectations.user_id')
        //         ->leftJoin('package_payments','members.user_id','=','package_payments.user_id')
        //         ->leftJoin('physical_attributes','members.user_id','=','physical_attributes.user_id')
        //         ->leftJoin('recidencies','members.user_id','=','recidencies.user_id')
        //         ->leftJoin('spiritual_backgrounds','members.user_id','=','spiritual_backgrounds.user_id')
        //         //->leftJoin('addresses', 'members.user_id', '=','addresses.user_id')
        //         // ->join('cities','cities.id','=','addresses.city_id')
        //         // ->join('countries','countries.id','=','addresses.country_id')
        //         // ->join('states','states.id','=','addresses.state_id')
        //         // ->limit(10)
        //         // ->count();
        //         ->orderBy('members.user_id','desc')
        //         ->get([
        //             'users.code as MemberId','first_name','users.last_name','users.email','users.email_verified_at','users.phone','users.email_verified_at1','users.blocked','users.deactivated','users.permanently_delete','users.approved',
        //             'users.created_at','users.deleted_at',DB::raw('IF(members.gender = "1", "Male", "Female") as gender'),
        //             'members.birthday','members.introduction','marital_statuses.name as maritalstatus','member_languages.name as mother_tongue',
        //             'packages.name as package_name','members.remaining_interest','members.remaining_contact_view','members.remaining_photo_gallery',
        //             'members.auto_profile_match','members.package_validity','members.profile_picture_privacy','members.gallery_image_privacy',
        //             'astrologies.sun_sign','astrologies.moon_sign','astrologies.time_of_birth','astrologies.city_of_birth','astrologies.manglik as astrologies_manglik',
        //             'careers.designation as designation','careers.company as company',
        //             'families.father','families.mother','families.sibling',
        //             'hobbies.hobbies','hobbies.interests',
        //             'lifestyles.diet','lifestyles.drink','lifestyles.smoke',
        //             'partner_expectations.general as partner_expectations_general','partner_expectations.height as partner_expectations_min_height','partner_expectations.marital_status_id as partner_expectations_marital_status','partner_expectations.residence_country_id as partner_expectations_residence_country',
        //             'partner_expectations.religion_id as partner_expectations_religion','partner_expectations.caste_id as partner_expectations_caste','partner_expectations.sub_caste_id as partner_expectations_sub_caste','partner_expectations.education as education',
        //             'partner_expectations.profession as profession','partner_expectations.smoking_acceptable as smoking_acceptable','partner_expectations.diet as partner_expectations_diet','partner_expectations.drinking_acceptable as partner_expectations_drinking_acceptable',
        //             'partner_expectations.manglik as partner_expectations_manglik','partner_expectations.preferred_country_id as partner_expectations_preferred_country_id','partner_expectations.preferred_state_id as partner_expectations_preferred_state','partner_expectations.partner_age_from as partner_age_from',
        //             'partner_expectations.partner_age_to as partner_age_to','package_payments.payment_status','package_payments.payment_status','package_payments.amount','package_payments.amount','package_payments.created_at as package_payments_created_at',
        //             'physical_attributes.height','physical_attributes.disability',
        //             'recidencies.birth_country_id as birth_country','recidencies.recidency_country_id as recidency_country','recidencies.growup_country_id as citizen_country','recidencies.immigration_status as immigration_status',
        //             'spiritual_backgrounds.religion_id as spiritual_backgrounds_religion','spiritual_backgrounds.caste_id as spiritual_backgrounds_caste','spiritual_backgrounds.sub_caste_id as spiritual_backgrounds_sub_caste','spiritual_backgrounds.ethnicity as ethnicity','spiritual_backgrounds.family_value as family_value',
                    
        //         ]);

        //         return $data;

$data =  DB::table('users')
                ->where('users.deleted','=', 'NULL')
                ->join('members', 'members.user_id', '=','users.id')
                ->leftJoin('marital_statuses', 'members.marital_status_id', '=','marital_statuses.id')
                ->leftJoin('member_languages', 'members.mothere_tongue', '=','member_languages.id')
                ->leftJoin('packages', 'members.current_package_id', '=','packages.id')
                ->leftJoin('astrologies', 'members.user_id', '=','astrologies.user_id')
                ->leftJoin('careers', function($join) {
                    $join->on('members.user_id','=','careers.user_id')
                    ->where('careers.deleted_at','NULL');
                })
                ->leftJoin('families','members.user_id','=','families.user_id')
                ->leftJoin('hobbies','members.user_id','=','hobbies.user_id')
                ->leftJoin('lifestyles','members.user_id','=','lifestyles.user_id')
                ->leftJoin('diet_types','diet_types.id','=','lifestyles.diet')
                ->leftJoin('partner_expectations','members.user_id','=','partner_expectations.user_id')
                ->leftJoin('marital_statuses as mat','mat.id','=','partner_expectations.marital_status_id')
                ->leftJoin('countries','countries.id','=','partner_expectations.residence_country_id')
                ->leftJoin('religions','religions.id','=','partner_expectations.religion_id')
                ->leftJoin('castes','castes.id','=','partner_expectations.caste_id')
                ->leftJoin('sub_castes','sub_castes.id','=','partner_expectations.sub_caste_id')
                ->leftJoin('diet_types as part_diet','part_diet.id','=','partner_expectations.diet')
                ->leftJoin('countries as part_cunt','part_cunt.id','=','partner_expectations.preferred_country_id')
                ->leftJoin('states','states.id','=','partner_expectations.preferred_state_id')
                ->leftJoin('package_payments','members.user_id','=','package_payments.user_id')
                ->leftJoin('physical_attributes','members.user_id','=','physical_attributes.user_id')
                ->leftJoin('recidencies','members.user_id','=','recidencies.user_id')
                ->leftJoin('countries as birth_cunt','birth_cunt.id','=','recidencies.birth_country_id')
                ->leftJoin('countries as resi_cunt','resi_cunt.id','=','recidencies.recidency_country_id')
                ->leftJoin('countries as citizen_cunt','citizen_cunt.id','=','recidencies.growup_country_id')
                ->leftJoin('spiritual_backgrounds','members.user_id','=','spiritual_backgrounds.user_id')
                ->leftJoin('religions as sp_reli','sp_reli.id','=','spiritual_backgrounds.religion_id')
                ->leftJoin('castes as sp_caste','sp_caste.id','=','spiritual_backgrounds.caste_id')
                ->leftJoin('sub_castes as sub_caste','sub_caste.id','=','spiritual_backgrounds.sub_caste_id')
                // ->count();
                // ->limit(100)
                ->orderBy('members.user_id','desc')
                ->get([
                    'users.code as MemberId','users.first_name','users.last_name','users.email','users.email_verified_at','users.phone','users.email_verified_at1 as phone_verified_at','users.blocked','users.deactivated','users.permanently_delete','users.approved',
                    'users.created_at','users.deleted_at',DB::raw('IF(members.gender = "1", "Male", "Female") as gender'),
                    'members.birthday','members.introduction','marital_statuses.name as maritalstatus','member_languages.name as mother_tongue',
                    'packages.name as package_name','members.remaining_interest','members.remaining_contact_view','members.remaining_photo_gallery',
                    'members.auto_profile_match','members.package_validity','members.profile_picture_privacy','members.gallery_image_privacy',
                    'astrologies.sun_sign','astrologies.moon_sign','astrologies.time_of_birth','astrologies.city_of_birth','astrologies.manglik as astrologies_manglik',
                    'careers.designation as designation','careers.company as company',
                    'families.father','families.mother','families.sibling',
                    'hobbies.hobbies','hobbies.interests',
                    'diet_types.name as diet_name','lifestyles.drink','lifestyles.smoke',
                    'partner_expectations.general as partner_expectations_general','partner_expectations.height as partner_expectations_min_height','mat.name as partner_expectations_marital_status','countries.name as partner_expectations_residence_country',
                    'religions.name as partner_expectations_religion','castes.name as partner_expectations_caste','sub_castes.name as partner_expectations_sub_caste','partner_expectations.education as education',
                    'partner_expectations.profession as profession','partner_expectations.smoking_acceptable as smoking_acceptable','part_diet.name as partner_expectations_diet','partner_expectations.drinking_acceptable as partner_expectations_drinking_acceptable',
                    'partner_expectations.manglik as partner_expectations_manglik','part_cunt.name as partner_expectations_preferred_country_id','states.name as partner_expectations_preferred_state','partner_expectations.partner_age_from as partner_age_from',
                    'partner_expectations.partner_age_to as partner_age_to','package_payments.payment_status','package_payments.payment_status','package_payments.amount','package_payments.amount','package_payments.created_at as package_payments_created_at',
                    'physical_attributes.height','physical_attributes.disability',
                    'birth_cunt.name as birth_country','resi_cunt.name as recidency_country','citizen_cunt.name as citizen_country','recidencies.immigration_status as immigration_status',
                    'sp_reli.name as spiritual_backgrounds_religion','sp_caste.name as spiritual_backgrounds_caste','sub_caste.name as spiritual_backgrounds_sub_caste','spiritual_backgrounds.ethnicity as ethnicity','spiritual_backgrounds.family_value as family_value',
                    
                ]);

        return $data ;

    }
}
