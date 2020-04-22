<?php

namespace Modules\Admin\Models;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tour extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_tour_id',
        'active',
        'good',
        'rating',
        'title',
        'price_base',
        'gallery',
        'address',
        'street',
        'house',
        'region',
        'city',
        'country',
        'latitude',
        'longitude',
        'adress_desk',
        'video_url',
        'info_excerpt',
        'info_description',
        'count_person',
        'timetable',
        'included',
        'no_included',
        'first_aid',
        'drinking_water',
        'communication',
        'accommodation_photo',
        'accommodation_description',
        'conditioner',
        'wifi',
        'pool',
        'towel',
        'kitchen',
        'coffee_tea',
        'private_room',
        'dormitory_room',
        'separate_house',
        'transfer_free',
        'transfer_fee',
        'not_transfer',
        'gallery_meals',
        'meals_desc',
        'vegan',
        'vegetarianism',
        'fish',
        'ayurveda',
        'meat',
        'organic',
        'gluten_free',
        'milk_free',
        'nuts_free',
        'count_meals',
        'date_start',
        'date_end',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /*
    * у туров много тегов
    */
    public function tags()
    {
        return $this->belongsToMany(
            ToursTags::class,
            'tours_tags_tours',
            'tour_id',
            'tour_tag_id'
        );
    }

    /*
     * варианты тура
     */
    public function variants()
    {
        return $this->hasMany(TourVariant::class);
    }

    /*
     * ведущие тура
     */
    public function leaders()
    {
        return $this->belongsToMany(
            User::class,
            'tour_leader',
            'tour_id',
            'leader_id'
        );
    }


    public function category()
    {
        return $this->belongsTo(CategoryTour::class, 'category_tour_id');
    }


    /*
        public function users()
        {
            return $this->belongsToMany(User::class);
        }*/
}
